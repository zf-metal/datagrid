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

        if (isset($options["customKey"])) {
            if (key_exists($options["customKey"], $config['zf-metal-datagrid.custom'])) {
                $customConfig = $config['zf-metal-datagrid.custom'][$options["customKey"]];
                $finalConfig = \Zend\Stdlib\ArrayUtils::merge($finalConfig, $customConfig, true);
            }
        }
  

        if (isset($options["customValues"]) && is_array($options["customValues"])) {
            $finalConfig = \Zend\Stdlib\ArrayUtils::merge($finalConfig, $options["customValues"]);
        }

        return new \ZfMetal\Datagrid\Options\GridOptions($finalConfig);
    }

}
