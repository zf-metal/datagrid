<?php

/**
 * User: Cristian Incarnato
 */
use Zend\ServiceManager\ServiceLocatorInterface;

$services = [
    'factories' => [
        \ZfMetal\Datagrid\Grid::class => \ZfMetal\Datagrid\Factory\GridFactory::class,
        'zf-metal-datagrid.options' => \ZfMetal\Datagrid\Factory\Options\ModuleOptionsFactory::class,
        \ZfMetal\Datagrid\Service\ExportToExcel::class => \ZfMetal\Datagrid\Factory\Service\ExportToExcelFactory::class,
        \ZfMetal\Datagrid\Service\ExportToCsv::class => \ZfMetal\Datagrid\Factory\Service\ExportToCsvFactory::class,
        \ZfMetal\Datagrid\Service\ImportFromCsv::class => \ZfMetal\Datagrid\Factory\Service\ImportFromCsvFactory::class,
        \ZfMetal\Datagrid\Builder\GridBuilder::class => \ZfMetal\Datagrid\Factory\Builder\GridBuilderFactory::class,
        \ZfMetal\Datagrid\Builder\ColumnBuilder::class => \ZfMetal\Datagrid\Factory\Builder\ColumnBuilderFactory::class,
    ],
    'aliases' => [
        "zf-metal-datagrid" => \ZfMetal\Datagrid\Grid::class,
        "zf-metal-datagrid-doctrine" => \ZfMetal\Datagrid\Grid::class,
        "zf-metal-datagrid-grid-builder" => \ZfMetal\Datagrid\Builder\GridBuilder::class,
        "zf-metal-datagrid-column-builder" => \ZfMetal\Datagrid\Builder\ColumnBuilder::class,
        "zf-metal-datagrid.export_to_excel" => \ZfMetal\Datagrid\Service\ExportToExcel::class,
        "zf-metal-datagrid.export_to_csv" => \ZfMetal\Datagrid\Service\ExportToCsv::class,
        "zf-metal-datagrid.import_from_csv" => \ZfMetal\Datagrid\Service\ImportFromCsv::class,
    ]
];


return $services;





