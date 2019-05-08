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
        $gridOptions = $container->build('zf-metal-datagrid.options', $options);
        
        /* @var $application \Zend\Mvc\Application */
        $application = $container->get('application');

        /* @var $mvcevent \Zend\Mvc\MvcEvent */
        $mvcevent = $application->getMvcEvent();

        $this->gridOptions = $gridOptions;

        /* @var $flashMessenger \Zend\Mvc\Plugin\FlashMessenger\FlashMessenger */
        $flashMessenger = $container->get('ControllerPluginManager')->get('flashmessenger');


        /** @var \ZfcRbac\Service\AuthorizationService $authService */
        try{
            $authService = $container->get(\ZfcRbac\Service\AuthorizationService::class);
        }catch (\Exception $e){
            $authService = null;
        }


        //NEW GRID
        $this->grid = new Grid($mvcevent, $gridOptions, $flashMessenger,$authService);

        //SET SOURCE BY REQUEST NAME
        ($requestedName == "zf-metal-datagrid-doctrine" || (isset($this->gridOptions->getSourceConfig()["type"]) && $this->gridOptions->getSourceConfig()["type"] == "doctrine") ) ? $this->buildDoctrineSource() : null;

        return $this->grid;
    }

    protected function buildDoctrineSource() {
        $doctrineOptions = $this->gridOptions->getSourceConfig()["doctrineOptions"];
        if (isset($doctrineOptions["entityManager"])) {
            $em = $this->container->get($doctrineOptions["entityManager"]);
            $doctrineAnnotationBuilder = $this->container->build('zf-metal-doctrine-annotation-builder', $doctrineOptions);
        } else {
            $em = $this->container->get('Doctrine\ORM\EntityManager');
            $doctrineAnnotationBuilder = $this->container->get('zf-metal-doctrine-annotation-builder');
        }

        if (isset($doctrineOptions["entityName"])) {
            $entityName = $doctrineOptions["entityName"];
        } else {
            throw new Exception("you must define 'entityName' config");
        }

        $qb = (isset($doctrineOptions["queryBuilder"]) && $doctrineOptions["queryBuilder"] instanceof \Doctrine\ORM\QueryBuilder) ? $doctrineOptions["queryBuilder"] : null;



        $source = new \ZfMetal\Datagrid\Source\DoctrineSource($em, $entityName, $qb);
        $source->setDoctrineAnnotationBuilder($doctrineAnnotationBuilder);
        $source->setEm($em);

        //EXPORTS
       
        if ($this->gridOptions->getExportConfig()->getExportToExcel()->getEnable()) {
            $serviceExportToExcel = $this->container->get('zf-metal-datagrid.export_to_excel');
            $source->setServiceExportToExcel($serviceExportToExcel);
        }

        if ($this->gridOptions->getExportConfig()->getExportToCsv()->getEnable()) {
            $serviceExportToCsv = $this->container->get('zf-metal-datagrid.export_to_csv');
            $source->setServiceExportToCsv($serviceExportToCsv);
        }

        if ($this->gridOptions->getImportConfig()->getImportFromCsv()->getEnable()) {
            $serviceImportFromCsv = $this->container->get('zf-metal-datagrid.import_from_csv');
            $source->setServiceImportFromCsv($serviceImportFromCsv);
        }

        $this->grid->setSource($source);
    }

}
