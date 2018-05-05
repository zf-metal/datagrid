<?php

namespace ZfMetal\Datagrid\Factory\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ImportFromCsvFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {

        $config = $container->get('Config');
        
        /* @var $application \Zend\Mvc\Application */
        $application = $container->get('application');

        $columnBuilder = $container->get('zf-metal-datagrid-column-builder');

        return new \ZfMetal\Datagrid\Service\ImportFromCsv(isset($config['zf-metal-datagrid.imports']) ? $config['zf-metal-datagrid.imports'] : array(), $application, $columnBuilder);
    }

}
