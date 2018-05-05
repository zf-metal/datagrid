<?php

namespace ZfMetal\Datagrid\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use \DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;

class ImportFromCsv extends AbstractPlugin {

    /**
     *
     * @var \ZfMetal\Datagrid\Service\ImportFromCsv
     */
    private $serviceImportFromCsv;

    function __construct(\ZfMetal\Datagrid\Service\ImportFromCsv $serviceImportFromCsv) {
        $this->serviceImportFromCsv = $serviceImportFromCsv;
    }

    function getServiceImportFromCsv() {
        return $this->serviceImportFromCsv;
    }

    public function __invoke(\Doctrine\ORM\EntityManager $em, $entity, $file, $configKey = null) {
        $this->serviceImportFromCsv->run($em, $entity, $file, $configKey);
    }

}
