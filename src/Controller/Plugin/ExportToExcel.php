<?php

namespace ZfMetal\Datagrid\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use \DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;

class ExportToExcel extends AbstractPlugin {

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

    function __construct($config = array()) {
        $this->config = $config;
    }

    function getConfig() {
        return $this->config;
    }

    function getEm(): \Doctrine\ORM\EntityManager {
        return $this->em;
    }

    function getColumnsConfig() {
        return $this->columnsConfig;
    }

    function getQueryBuilder() {
        return $this->queryBuilder;
    }

    function getColumnsName() {
        return $this->columnsName;
    }

    function getColumns() {
        return $this->columns;
    }

    public function __invoke(\Doctrine\ORM\EntityManager $em, $entity, \Doctrine\ORM\QueryBuilder $queryBuilder = null, $configKey = null) {
        $this->em = $em;

        if (!$queryBuilder) {
            /** @var $queryBuilder \Doctrine\ORM\QueryBuilder  */
            $queryBuilder = $this->buildQueryBuilder($entity);
        }

        $this->queryBuilder = $queryBuilder;

        if ($configKey) {
            if (!key_exists($configKey, $this->getConfig())) {
                throw new \Exception('La key ' . $configKey . ' no existe en zf-metal-commons.exports!');
            }
            $this->columnsConfig = $this->getConfig()[$configKey]['columnsConfig'];
        }

        $this->getEntityColumns($entity);

        $this->generateColumns();

        $result = $this->export();

        return $result;
    }

    private function buildQueryBuilder($entity) {
        return $this->getEm()->createQueryBuilder()->select('u')->from($entity, 'u');
    }

    private function getEntityColumns($entity) {
        if (!class_exists($entity)) {
            throw new \Exception('La clase no existe.');
        }

        $properties = $this->getEm()->getClassMetadata($entity)->getReflectionProperties();


        foreach ($properties as $property) {
            $this->columnsName[] = $property->name;
        }
    }

    private function generateColumns() {

        $factoryColumns = new \ZfMetal\Datagrid\Factory\ColumnFactory();

        foreach ($this->columnsName as $name) {
            $this->columns[] = $factoryColumns->create($name, isset($this->columnsConfig[$name]) ? $this->columnsConfig[$name] : array());
        }
    }

    private function export() {
        $header = $this->getHeader();
        $data = $this->getData();
        $writer = new \XLSXWriter();
        $writer->writeSheetHeader('Sheet1', $header);
        foreach ($data as $row) {
            $writer->writeSheetRow('Sheet1', $row);
        }

        $writer->writeToFile('/tmp/test.xlsx');
        return '/tmp/test.xlsx';
    }

    private function getHeader() {
        $header = array();

        foreach ($this->columns as $column) {
            if ($column->getHidden()) {
                continue;
            }
            $header[$column->getDisplayName()] = $column->getType()=='relational'?'string':$column->getType();
        }
        return $header;
    }

    private function getData() {
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

}
