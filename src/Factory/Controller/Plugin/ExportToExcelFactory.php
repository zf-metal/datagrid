<?php

namespace ZfMetal\Datagrid\Factory\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ExportToExcelFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $service = $container->get('zf-metal-datagrid.export_to_excel');
        return new \ZfMetal\Datagrid\Controller\Plugin\ExportToExcel($service);
    }

}
