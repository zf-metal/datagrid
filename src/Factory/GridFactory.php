<?php

namespace ZfMetal\Datagrid\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\Datagrid\Grid;

class GridFactory implements FactoryInterface {

    protected $container;
    protected $grid;
    protected $gridOptions;

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {
        $this->container = $container;

        /* @var $config \ZfMetal\Datagrid\Opcions\GridOptions */
        $gridOptions = $container->get('zf-metal-datagrid.options');

        /* @var $application \Zend\Mvc\Application */
        $application = $container->get('application');

        /* @var $mvcevent \Zend\Mvc\MvcEvent */
        $mvcevent = $application->getMvcEvent();

        //CUSTOM OPTIONS KEY
        if (isset($options["customOptionsKey"])) {
            $customOptions = $container->get('config')[$options["customOptionsKey"]];
            if (is_array($customOptions)) {
                $gridOptions->mergeCustomOptions($customOptions);
            } else {
                throw new \Exception("Can't get a config array by key " . $options["customOptionsKey"] . "' ");
            }
        }

        //CUSTOM OPTIONS
        if (isset($options["customOptions"]) && is_array($options["customOptions"])) {
            $gridOptions->mergeCustomOptions($options["customOptions"]);
        }

        $this->gridOptions = $gridOptions;

        //NEW GRID
        $this->grid = new Grid($mvcevent, $gridOptions);

        //SET SOURCE BY REQUEST NAME
        ($requestedName == "zf-metal-datagrid-doctrine" || (isset($this->gridOptions->getSourceConfig()["type"]) && $this->gridOptions->getSourceConfig()["type"] == "doctrine") ) ? $this->buildDoctrineSource() : null;

        return $this->grid;
    }

    protected function buildDoctrineSource() {
        $doctrineOptions = $this->gridOptions->getSourceConfig()["doctrineOptions"];
        if (isset($doctrineOptions["entityManager"])) {
            $em = $this->container->get($doctrineOptions["entityManager"]);
        } else {
            $em = $this->container->get('Doctrine\ORM\EntityManager');
        }

        if (isset($doctrineOptions["entityName"])) {
            $entityName = $doctrineOptions["entityName"];
        } else {
            throw new Exception("you must define 'entityName' config");
        }

        $qb = (isset($doctrineOptions["queryBuilder"]) && $doctrineOptions["queryBuilder"] instanceof \Doctrine\ORM\QueryBuilder) ? $doctrineOptions["queryBuilder"] : null;



        $source = new \ZfMetal\Datagrid\Source\DoctrineSource($em, $entityName, $qb);
        $source->setEm($em);
        $this->grid->setSource($source);
    }

}
