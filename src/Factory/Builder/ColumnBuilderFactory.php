<?php

namespace ZfMetal\Datagrid\Factory\Builder;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ColumnBuilderFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        
        /* @var $application \Zend\Mvc\Application */
        $application = $container->get('application');
        return new \ZfMetal\Datagrid\Builder\ColumnBuilder($application);
    }

}