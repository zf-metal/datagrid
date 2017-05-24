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
    private $columnsName = array();
    private $columnsConfig = array();
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

    function getColumns() {
        return $this->columns;
    }

    public function __invoke(\Doctrine\ORM\EntityManager $em, $entity, \Doctrine\ORM\QueryBuilder $queryBuilder = null, $configKey = null) {
        $this->em = $em;

        if (!$queryBuilder) {
            /** @var $queryBuilder \Doctrine\ORM\QueryBuilder  */
            $queryBuilder = $this->getQueryBuilder($entity);
        }

        if ($configKey) {
            if (!key_exists($configKey, $this->getConfig())) {
                throw new \Exception('La key ' . $configKey . ' no existe en zf-metal-commons.exports!');
            }
            $this->columnsConfig = $this->getConfig()[$configKey]['columnsConfig'];
        }

        $this->getEntityColumns($entity);

        $this->generateColumns();

        $records = $queryBuilder
                ->getQuery()
                ->getResult();
    }

    private function getQueryBuilder($entity) {
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

    public function generateColumns() {

        $factoryColumns = new \ZfMetal\Datagrid\Factory\ColumnFactory();

        foreach ($this->columnsName as $name) {
            $this->columns[] = $factoryColumns->create($name, isset($this->columnsConfig[$name]) ? $this->columnsConfig[$name] : array());
        }
    }

    public function export() {

        $header = array(
            'created' => 'date',
            'product_id' => 'integer',
            'quantity' => '#,##0',
            'amount' => 'price',
            'description' => 'string',
            'tax' => '[$$-1009]#,##0.00;[RED]-[$$-1009]#,##0.00',
        );
        $data = array(
            array('2015-01-01', 873, 1, '44.00', 'misc', '=D2*0.05'),
            array('2015-01-12', 324, 2, '88.00', 'none', '=D3*0.05'),
        );

        $writer = new XLSXWriter();
        $writer->writeSheetHeader('Sheet1', $header);
        foreach ($data as $row)
            $writer->writeSheetRow('Sheet1', $row);
        $writer->writeToFile('example.xlsx');
    }

}
