<?php

namespace ZfMetal\Datagrid\Factory\Options;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class ModuleOptionsFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
         $config = $container->get('Config');
         
         return new \ZfMetal\Datagrid\Options\GridOptions(isset($config['zf-metal-datagrid.options']) ? $config['zf-metal-datagrid.options'] : array());
    }

}
