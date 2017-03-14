<?php

/**
 * User: Cristian Incarnato
 */
use Zend\ServiceManager\ServiceLocatorInterface;

$services = [
    'factories' => [
        "ZfMetal\Datagrid" => ZfMetal\Datagrid\Factory\GridFactory::class,
        "ZfMetal\DatagridDoctrine" => ZfMetal\Datagrid\Factory\GridFactory::class,
        'zf-metal-datagrid.options' => function (ServiceLocatorInterface $sm) {
            $config = $sm->get('Config');
            return new \ZfMetal\Datagrid\Options\GridOptions(isset($config['zf-metal-datagrid.options']) ? $config['zf-metal-datagrid.options'] : array());
        },
            ],
            'aliases' => [
                \ZfMetal\Datagrid\Grid::class => "ZfMetal\Datagrid"
            ]
        ];


        return $services;




        
