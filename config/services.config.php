<?php

/**
 * User: Cristian Incarnato
 */
use Zend\ServiceManager\ServiceLocatorInterface;

$services = [
    'factories' => [
        \ZfMetal\Datagrid\Grid::class => \ZfMetal\Datagrid\Factory\GridFactory::class,
        'zf-metal-datagrid.options' => \ZfMetal\Datagrid\Factory\Options\ModuleOptionsFactory::class,
    ],
    'aliases' => [
        "zf-metal-datagrid" => \ZfMetal\Datagrid\Grid::class,
        "zf-metal-datagrid-doctrine" => \ZfMetal\Datagrid\Grid::class
    ]
];


return $services;





