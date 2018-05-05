<?php

namespace ZfMetal\Datagrid\Factory\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ImportFromCsvFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $service = $container->get('zf-metal-datagrid.import_from_csv');
        return new \ZfMetal\Datagrid\Controller\Plugin\ImportFromCsv($service);
    }

}
