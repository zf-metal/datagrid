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
    private $columnsName = array();

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
            $this->columnsConfig[] = $property->name;
        }
    }

    private function getColumnsName($file)
    {
        // En primer lugar supongo que el separador es el punto y coma.
        $this->delimiter = ';';
        // Leo nombre de columnas
        $this->columnsName = fgetcsv($file, 0, $this->delimiter, "\"", "\"");

        // En caso de que la cantidad de nombres sea uno, cambio el separador por coma, y vuelvo a procesar.
        if (count($this->columnsName) == 1) {
            $this->delimiter = ',';
            $this->columnsName = trim(strtoupper(explode(",", $this->columnsName[0])));
        }
    }

    private function validateColumnsName()
    {
        for ($i = 0; $i < count($this->columnsConfig); $i++) {
            if (array_search($this->columnsConfig[$i], $this->columnsName, false) === false)
                throw new \Exception("No se encontro la columna " . $this->columnsConfig[$i]);
        }
    }

    private function getRows($file)
    {
        $countNames = count($this->columnsName);
        $this->rows = array();
        while (($data = fgetcsv($file, 0, $this->delimiter, "\"", "\"")) !== FALSE) {

            $reg = array();
            for ($i = 0; $i < $countNames; $i++) {
                $reg[$this->columnsName[$i]] = trim($data[$i]);
            }
            $this->rows[] = $reg;
        }
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

        if(empty($this->columnsConfig))
            $this->getEntityColumns($this->entity);

        $this->createFileExample();
    }

    private function createFileExample()
    {
        $csv = new CSVWriter();
        $csv->addRow($this->columnsConfig);
        $csv->setDelimiter($this->delimiter ? $this->delimiter : '; ');
        $csv->saveFile($this->entity . '-Example');
    }

}