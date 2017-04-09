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


        // Foward $options. Util Keys: customOptionsKey | customOptions
        $gridOptions = $container->build('zf-metal-datagrid.options',$options);


        /* @var $application \Zend\Mvc\Application */
        $application = $container->get('application');

        /* @var $mvcevent \Zend\Mvc\MvcEvent */
        $mvcevent = $application->getMvcEvent();


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
