<?php

namespace ZfMetal\Datagrid\Factory\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ManagerBuilderFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        return new \ZfMetal\Datagrid\Controller\Plugin\ManagerBuilder($container);
    }

}
