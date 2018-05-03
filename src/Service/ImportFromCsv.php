<?php

namespace ZfMetal\Datagrid\Service;

use Doctrine\Common\Collections\ArrayCollection;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use SimpleExcel\Writer\CSVWriter;
use ZfMetal\Log\Log;

class ImportFromCsv
{

    /**
     *
     * @var array
     */
    private $config;

    /**
     *
     * @var array
     */
    private $columnsConfig = array();

    /**
     *
     * @var array
     */
    private $customConfig = array();

    /**
     *
     * @var array
     */
    private $columnNames = array();

    /**
     *
     * @var array
     */
    private $fieldNames = array();

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     *
     */
    private $file;

    /**
     *
     */
    private $rows;

    /**
     *
     */
    private $delimiter;

    /**
     *
     */
    private $entity;

    /**
     *
     * @var \Zend\Mvc\Application
     */
    private $application;

    private $messages = array(
        'messageOk' => '%d records were imported.',
        'messageFail' => 'There was an error importing records.'
    );

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return \Zend\Mvc\Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @return array
     */
    public function getColumnsConfig()
    {
        return $this->columnsConfig;
    }

    /**
     * @param array $columnsConfig
     */
    public function setColumnsConfig($columnsConfig)
    {
        $this->columnsConfig = $columnsConfig;
    }


    function __construct($config = array(), \Zend\Mvc\Application $application)
    {
        $this->config = $config;
        $this->application = $application;
    }

    public function run(\Doctrine\ORM\EntityManager $em, $entity, $file, $configKey = null)
    {
        try {
            $this->em = $em;
            $this->file = $file['tmp_name'];
            $this->entity = $entity;

            if ($configKey) {
                if (!key_exists($configKey, $this->getConfig())) {
                    throw new \Exception('La key ' . $configKey . ' no existe en zf-metal-commons.imports!');
                }
                $this->customConfig = $this->getConfig()[$configKey];
                if (isset($this->customConfig['messageOk']))
                    $this->messages['messageOk'] = $this->customConfig['messageOk'];
                if (isset($this->customConfig['messageFail']))
                    $this->messages['messageFail'] = $this->customConfig['messageOk'];
                if (isset($this->customConfig['columnsConfig']))
                    $this->columnsConfig = $this->customConfig['columnsConfig'];
            }
            $this->processFile();
            $numRecors = $this->persistRegisters();

            return [
                'status' => 'ok',
                'message' => sprintf($this->messages['messageOk'], $numRecors)
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'fail',
                'message' => $this->messages['messageFail']
            ];
        }

    }

    private function processFile()
    {
        $myFile = null;
        if (($myFile = fopen($this->file, "r")) == FALSE)
            throw new \Exception("Error Processing File", 1);

        $this->getColumnsName($myFile);

        if (count($this->columnsConfig) == 0)
            $this->getEntityColumns($this->entity);
        else
            $this->getFieldNamesFromConfig();

        $this->validateColumnsName();

        $this->getRows($myFile);

        if (count($this->rows) == 0)
            throw new \Exception("Error Processing Rows", 1);

        fclose($this->file);
    }

    private function getEntityColumns($entity)
    {
        if (!class_exists($entity)) {
            throw new \Exception('La clase no existe.');
        }

        $properties = $this->getEm()->getClassMetadata($entity)->getReflectionProperties();

        foreach ($properties as $property) {
            $this->fieldNames[] = $property->name;
        }
    }

    private function getColumnsName($file)
    {
        // En primer lugar supongo que el separador es el punto y coma.
        $this->delimiter = ';';
        // Leo nombre de columnas
        $this->columnNames = fgetcsv($file, 0, $this->delimiter, "\"", "\"");

        // En caso de que la cantidad de nombres sea uno, cambio el separador por coma, y vuelvo a procesar.
        if (count($this->columnNames) == 1) {
            $this->delimiter = ',';
            $this->columnNames = trim(strtoupper(explode(",", $this->columnNames[0])));
        }
    }

    private function validateColumnsName()
    {
        if (count(array_diff($this->fieldNames, $this->columnNames)) != 0)
            throw new \Exception("The fields not match");
    }

    private function getRows($file)
    {
        $countNames = count($this->fieldNames);
        $this->rows = array();
        while (($data = fgetcsv($file, 0, $this->delimiter, "\"", "\"")) !== FALSE) {

            $reg = array();
            for ($i = 0; $i < $countNames; $i++) {
                $columnConfig = $this->getColumnConfigFromValue($this->fieldNames[$i]);
                $index = $columnConfig ? key($columnConfig) : $this->fieldNames[$i];
                $reg[$index] = $this->buildValue($columnConfig[$index], $data[$i]);
            }
            $this->rows[] = $reg;
        }
    }

    private function getColumnConfigFromValue($value)
    {
        foreach ($this->columnsConfig as $index => $config) {

            if ((isset($config['displayName']) && $config['displayName'] == $value) || $index == $value)
                return array($index => $config);
        }

        return null;
    }

    private function buildValue($config = array(), $value = null)
    {
        if (empty($config))
            return $value ? (string)$value : null;

        $type = isset($config['type']) ? $config['type'] : 'string';

        $result = null;

        switch ($type) {
            case 'relational':
                $result = $this->getRelationalValue($config, $value);
                break;
            case 'datetime':
                $result = $this->getDatetimeValue($config, $value);
                break;
            case 'boolean':
                $result = $this->getBooleanValue($config, $value);
                break;
            default:
                $result = (string)$value || null;
        }

        return $result;
    }

    private function getRelationalValue($config = array(), $value = null)
    {
        if (!$value && !isset($config['default']))
            return null;

        if (!isset($config['field']) || !isset($config['entity']))
            throw new \Exception('failed config on getRelationalValue');

        $obj = null;

        $value = $value ? $value : $config['default'];

        if ($config['field'] == 'id')
            $obj = $this->getEm()->getReference($config['entity'], $value);
        else
            $obj = $this->getEm()->getRepository($config['entity'])->findOneBy([$config['field'], $value]);

        return $obj;
    }

    private function getDatetimeValue($config = array(), $value = null)
    {
        $format = isset($config['format']) && !empty($config['format']) ? $config['format'] : 'Y-m-d H:i:s';

        if ($value)
            return \DateTime::createFromFormat($format, $value);

        $default = isset($config['default']) && !empty($config['default']) ? $config['default'] : null;

        switch ($default) {
            case 'now':
                return new \DateTime();
            case 'curdate':
                return new \DateTime('Y-m-d');
        }

        return null;
    }

    private function getBooleanValue($config = array(), $value = null)
    {
        if (isset($config['valueOfTrue']))
            return $config['valueOfTrue'] == $value ? true : false;
        elseif (isset($config['valueOfFalse']))
            return $config['valueOfFalse'] == $value ? false : true;

        return $value ? true : false;
    }

    private function persistRegisters()
    {

        $collection = new ArrayCollection();
        $hidrator = new DoctrineObject($this->em);

        $this->getEm()->getConnection()->beginTransaction();
        try {

            for ($i = 0; $i < count($this->rows); $i++) {
                $collection->add($hidrator->hydrate($this->rows[$i], new $this->entity));
            }

            foreach ($collection->getIterator() as $i => $obj) {
                $this->getEm()->persist($obj);
            }

            $this->getEm()->flush();
            $this->getEm()->getConnection()->commit();

            return $collection->count();

        } catch (\Exception $e) {
            $this->getEm()->getConnection()->rollBack();
            throw $e;
        }
    }

    public function getImportExample(\Doctrine\ORM\EntityManager $em, $entity, $configKey = null)
    {
        $this->em = $em;
        $this->entity = $entity;
        if ($configKey) {
            if (!key_exists($configKey, $this->getConfig())) {
                throw new \Exception('La key ' . $configKey . ' no existe en zf-metal-commons.imports!');
            }
            $this->customConfig = $this->getConfig()[$configKey];

            if (isset($this->customConfig['columnsConfig']))
                $this->columnsConfig = $this->customConfig['columnsConfig'];
        }

        if (empty($this->columnsConfig))
            $this->getEntityColumns($this->entity);
        else
            $this->getFieldNamesFromConfig();

        $this->createFileExample();
    }

    private function getFieldNamesFromConfig()
    {
        $this->fieldNames = array();

        foreach ($this->columnsConfig as $index => $values) {
            $this->fieldNames[] = isset($values['displayName']) && !empty($values['displayName']) ? $values['displayName'] : $index;
        }
    }

    private function createFileExample()
    {
        $csv = new CSVWriter();
        $csv->addRow($this->fieldNames);
        $csv->setDelimiter($this->delimiter ? $this->delimiter : '; ');
        $csv->saveFile($this->entity . '-Example');
    }

}