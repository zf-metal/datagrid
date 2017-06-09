<?php

namespace ZfMetal\Datagrid\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use \DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;

class ExportToExcel extends AbstractPlugin {

    /**
     *
     * @var \ZfMetal\Datagrid\Service\ExportToExcel
     */
    private $serviceExportToExcel;

    function __construct(\ZfMetal\Datagrid\Service\ExportToExcel $serviceExportToExcel) {
        $this->serviceExportToExcel = $serviceExportToExcel;
    }

    function getServiceExportToExcel() {
        return $this->serviceExportToExcel;
    }

    public function __invoke(\Doctrine\ORM\EntityManager $em, $entity, \Doctrine\ORM\QueryBuilder $queryBuilder = null, $configKey = null) {
        $this->serviceExportToExcel->run($em, $entity, $queryBuilder, $configKey);
    }

}
