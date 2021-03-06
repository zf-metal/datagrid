<?php

namespace ZfMetal\Datagrid\Service;

class ExportToCsv
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
    private $columnsName = array();

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
     * @var \Doctrine\ORM\QueryBuilder
     */
    private $queryBuilder;

    /**
     *
     * @var array
     */
    private $columns = array();

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     *
     * @var \Zend\Mvc\Application
     */
    private $application;

    function __construct($config = array(), \Zend\Mvc\Application $application)
    {
        $this->config = $config;
        $this->application = $application;
    }

    function getConfig()
    {
        return $this->config;
    }

    function getEm()
    {
        return $this->em;
    }

    function getColumnsConfig()
    {
        return $this->columnsConfig;
    }

    function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    function getColumnsName()
    {
        return $this->columnsName;
    }

    function getColumns()
    {
        return $this->columns;
    }

    function getApplication()
    {
        return $this->application;
    }

    function getCustomConfig()
    {
        return $this->customConfig;
    }

    public function run(\Doctrine\ORM\EntityManager $em, $entity, \Doctrine\ORM\QueryBuilder $queryBuilder = null, $configKey = null)
    {
        $this->em = $em;

        if (!$queryBuilder) {
            /** @var $queryBuilder \Doctrine\ORM\QueryBuilder */
            $queryBuilder = $this->buildQueryBuilder($entity);
        }

        $this->queryBuilder = $queryBuilder;
        if ($configKey) {
            if (!key_exists($configKey, $this->getConfig())) {
                throw new \Exception('La key ' . $configKey . ' no existe en zf-metal-commons.exports!');
            }
            $this->customConfig = $this->getConfig()[$configKey];
            $this->columnsConfig = $this->customConfig['columnsConfig'];
        }

        $this->getEntityColumns($entity);

        $this->generateColumns();

        $result = $this->export();

        $this->dispatchResponse($result);
    }

    private function buildQueryBuilder($entity)
    {
        return $this->getEm()->createQueryBuilder()->select('u')->from($entity, 'u');
    }

    private function getEntityColumns($entity)
    {
        if (!class_exists($entity)) {
            throw new \Exception('La clase no existe.');
        }

        $properties = $this->getEm()->getClassMetadata($entity)->getReflectionProperties();


        foreach ($properties as $property) {
            $this->columnsName[] = $property->name;
        }
    }

    private function generateColumns()
    {

        $factoryColumns = new \ZfMetal\Datagrid\Factory\ColumnFactory();

        foreach ($this->columnsName as $name) {
            $this->columns[$name] = $factoryColumns->create($name, isset($this->columnsConfig[$name]) ? $this->columnsConfig[$name] : array());
        }
        $this->orderColumns();
    }

    private function export()
    {
        $export = "";
        $headers = $this->getHeader();

        foreach ($headers as $key => $header) {
            $export .= $header;

            if (end($headers) != $header) {
                $export .= ";";
            }
        }

        $export .= PHP_EOL;

        $data = $this->getData();

        foreach ($data as $row) {
            $line = "";
            foreach ($row as $key => $field) {
                $line .= $field . ";";
            }
            $export .= substr_replace($line ,"", -1).PHP_EOL;
        }
        return $export;

    }

    private function orderColumns()
    {
        foreach ($this->columns as $column) {
            $orderHeader[$column->getName()] = $column->getPriority();
        }
        asort($orderHeader);
        $this->columns = array_merge($orderHeader, $this->columns);
    }

    private function getHeader()
    {
        $header = array();

        foreach ($this->columns as $column) {
            if ($column->getHidden()) {
                continue;
            }
            $header[] = $column->getDisplayName();
        }

        return $header;
    }

    private function getData()
    {
        $columnRender = new \ZfMetal\Datagrid\Render\ExportColumn();
        $registers = $this->getQueryBuilder()->getQuery()->getResult();
        $data = array();
        foreach ($registers as $register) {
            $entityInfo = array();
            foreach ($this->columns as $column) {
                if ($column->getHidden()) {
                    continue;
                }
                $entityInfo[] = $columnRender->render($register, $column, isset($this->columnsConfig[$column->getName()]) ? $this->columnsConfig[$column->getName()] : array());
            }
            $data[] = $entityInfo;
        }

        return $data;
    }

    private function dispatchResponse($file)
    {
        $file =  "\xEF\xBB\xBF" . $file;
        $plugin = $this;
        $mvcevent = $this->getApplication()->getMvcEvent();
        $this->getApplication()->getEventManager()->attach($mvcevent::EVENT_FINISH, function ($e) use ($plugin, $file) {
            $response = $e->getResponse();
            $response->getHeaders()->addHeaders(array(
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment;filename="' . $this->getNameFile() . '"',
            ));
            $response->setContent($file);
            return $response;
        });
    }

    private function getNameFile()
    {
        $date = date('Ymd');

        return $this->getNameFileConfig() . '-' . $date . '.csv';
    }

    private function getNameFileConfig()
    {
        return isset($this->getCustomConfig()['fileName']) ? $this->getCustomConfig()['fileName'] : 'export';
    }

}
