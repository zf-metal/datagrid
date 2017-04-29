<?php

namespace ZfMetal\Datagrid\Factory\Options;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ModuleOptionsFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $config = $container->get('Config');
        $finalConfig = array();

        if (isset($config['zf-metal-datagrid.options'])) {
            $finalConfig = $config['zf-metal-datagrid.options'];
        }

        if (isset($options["customOptionsKey"])) {
            if (key_exists($options["customOptionsKey"], $config)) {
                $customConfig = $config[$options["customOptionsKey"]];
                $finalConfig = \Zend\Stdlib\ArrayUtils::merge($finalConfig, $customConfig, true);
            }
        }
  

        if (isset($options["customOptions"]) && is_array($options["customOptions"])) {
            $finalConfig = \Zend\Stdlib\ArrayUtils::merge($finalConfig, $options["customOptions"]);
        }

        return new \ZfMetal\Datagrid\Options\GridOptions($finalConfig);
    }

}
