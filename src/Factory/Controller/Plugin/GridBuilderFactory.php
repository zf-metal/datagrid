<?php

namespace ZfMetal\Datagrid\Factory\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class GridBuilderFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new \ZfMetal\Datagrid\Controller\Plugin\GridBuilder($container->get("zf-metal-datagrid-grid-builder"));
    }

}
