<?php

namespace ZfMetal\Datagrid\Service;

use Doctrine\Common\Collections\ArrayCollection;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use SimpleExcel\Writer\CSVWriter;
use ZfMetal\Datagrid\Exception\NotMatchFieldException;
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

    /**
     *
     * @var \ZfMetal\Datagrid\Builder\ColumnBuilder
     */
    private $columnBuilder;


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

    /**
     * @return \ZfMetal\Datagrid\Builder\ColumnBuilder
     */
    public function getColumnBuilder()
    {
        return $this->columnBuilder;
    }

    /**
     * @return array
     */
    public function getColumnNames()
    {
        return $this->columnNames;
    }

    /**
     * @return array
     */
    public function getFieldNames()
    {
        return $this->fieldNames;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @param array $customConfig
     */
    public function setCustomConfig($customConfig)
    {
        $this->customConfig = $customConfig;
    }

    /**
     * @param array $columnNames
     */
    public function setColumnNames($columnNames)
    {
        $this->columnNames = $columnNames;
    }

    /**
     * @param array $fieldNames
     */
    public function setFieldNames($fieldNames)
    {
        $this->fieldNames = $fieldNames;
    }

    function __construct($config = array(), \Zend\Mvc\Application $application, \ZfMetal\Datagrid\Builder\ColumnBuilder $columnBuilder)
    {
        $this->config = $config;
        $this->application = $application;
        $this->columnBuilder = $columnBuilder;
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
                    $this->messages['messageFail'] = $this->customConfig['messageFail'];
                if (isset($this->customConfig['columnsConfig']))
                    $this->columnsConfig = $this->customConfig['columnsConfig'];
            }

            $numRecors = $this->processFile();

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

        $this->getColumnNamesFromFile($myFile);

        if (count($this->columnsConfig) == 0)
            $this->getEntityColumns($this->entity);
        else
            $this->getFieldNamesFromConfig();

        $this->validateColumnsName();

        $num = $this->processRows($myFile);

        fclose($this->file);

        return $num;
    }

    private function getEntityColumns($entity)
    {
        if (!class_exists($entity)) {
            throw new \Exception('The entity class is not exist.');
        }

        $properties = $this->getEm()->getClassMetadata($entity)->getReflectionProperties();

        foreach ($properties as $property) {
            $this->fieldNames[] = $property->name;
        }
    }

    private function getColumnNamesFromFile($file)
    {
        // En primer lugar supongo que el separador es el punto y coma.
        $this->delimiter = ';';
        // Leo nombre de columnas
        $this->columnNames = fgetcsv($file, 0, $this->delimiter, "\"", "\"");

        // En caso de que la cantidad de nombres sea uno, cambio el separador por coma, y vuelvo a procesar.
        if (count($this->columnNames) == 1) {
            $this->delimiter = ',';
            $this->columnNames = explode(",", $this->columnNames[0]);
        }
    }

    private function validateColumnsName()
    {
        if (count(array_diff($this->columnNames, $this->fieldNames)) != 0)
            throw new NotMatchFieldException("The fields not match");
    }

    private function processRows($file)
    {
        $countNames = count($this->getColumnNames());
        $columnBuilder = $this->getColumnBuilder();
        $columnBuilder->setConfig($this->columnsConfig);
        $columnBuilder->setEm($this->getEm());

        $c = 0;

        $this->getEm()->getConnection()->beginTransaction();
        try {

            while (($data = fgetcsv($file, 0, $this->delimiter, "\"", "\"")) !== FALSE) {
                $reg = array();
                for ($i = 0; $i < $countNames; $i++) {
                    $reg[$columnBuilder->getKeyFromValue($this->getColumnNames()[$i])] = $columnBuilder->buildValue($this->getColumnNames()[$i], $data[$i]);
                }
                $obj = $this->getObjectForPersist($reg);
                $this->getEm()->persist($obj);

                $c++;
                if ($c % 1000 == 0) {
                    $this->getEm()->flush();
                    $this->getEm()->clear();
                }
            }

            $this->getEm()->flush();
            $this->getEm()->clear();

            $this->getEm()->getConnection()->commit();

            return $c;

        } catch (\Exception $e) {
            $this->getEm()->getConnection()->rollBack();
            throw $e;
        }
    }

    private function getObjectForPersist($data)
    {
        $obj = null;

        $identifier = $this->getEm()->getClassMetadata($this->entity)->getIdentifier();
        $countIdentifier = count($identifier);

        $count = 0;
        for ($i = 0; $i < $countIdentifier; $i++) {
            if (array_key_exists($identifier[$i], $data))
                $count++;
        }

        if ($countIdentifier == $count && $this->validateContentIdentifier($identifier, $data)) {
            $query = $this->getEm()->getRepository($this->entity)->createQueryBuilder('u');
            for ($i = 0; $i < $countIdentifier; $i++) {
                $query->where('u.' . $identifier[$i] . ' = :' . $identifier[$i]);
                $query->setParameter($identifier[$i], $data[$identifier[$i]]);
            }
            $record = $query->getQuery()->getResult();

            if(isset($record[0]))
                $obj = $record[0];
            else
                $obj = new $this->entity;
        } else {
            $obj = new $this->entity;
        }

        $hidrator = new DoctrineObject($this->getEm());
        $obj = $hidrator->hydrate($data, $obj);

        return $obj;
    }

    private function validateContentIdentifier($identifier, $data)
    {
        $result = true;

        foreach ($identifier as $key) {
            if (!isset($data[$key]) || empty($data[$key]))
                $result = false;
        }

        return $result;
    }

    public function getImportExample(\Doctrine\ORM\EntityManager $em, $entity, $configKey = null)
    {
        $this->em = $em;
        $this->entity = $entity;
        if ($configKey) {
            if (!key_exists($configKey, $this->getConfig())) {
                throw new \Exception('The key ' . $configKey . ' is not exist in zf-metal-commons.imports!');
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