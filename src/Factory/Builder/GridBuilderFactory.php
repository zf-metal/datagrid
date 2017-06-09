<?php

namespace ZfMetal\Datagrid\Factory\Builder;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class GridBuilderFactory implements FactoryInterface {

   

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {    
       return new \ZfMetal\Datagrid\Builder\GridBuilder($container);
    }

}
