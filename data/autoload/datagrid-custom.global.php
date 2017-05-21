<?php

//AN EXAMPLE CUSTOM CONFIG

$config = [
    'zf-metal-datagrid.custom' => [
        "application-entity-test" => [
            'grid_id' => 'test',
            'title' => '',
            'title_add' => '',
            'title_edit' => '',
            'records_per_page' => 10,
            'template_default' => 'default',
            'multi_filter_config' => [
                "enable" => true,
                "properties_disabled" => []
            ],
            "multi_search_config" => [
                "enable" => false,
                "properties_enabled" => []
            ],
            "sourceConfig" => [
                "type" => "doctrine",
                "doctrineOptions" => [
                    "entityName" => "\Application\Entity\Test",
                    "entityManager" => "Doctrine\ORM\EntityManager"
                ]
            ],
            "formConfig" => [
                'columns' => \ZfMetal\Commons\Consts::COLUMNS_ONE,
                'style' => \ZfMetal\Commons\Consts::STYLE_MENU_VERTICAL,
            ],
            "crudConfig" => [
                "enable" => true,
                'side' => "right",
                'displayName' => null,
                'name' => 'ZfMetalCrudColumn',
                "add" => [
                    "enable" => true,
                    "class" => "btn btn-primary fa fa-plus",
                    "value" => " Agregar"
                ],
                "edit" => [
                    "enable" => true,
                    "class" => "btn btn-primary fa fa-edit",
                    "value" => ""
                ],
                "del" => [
                    "enable" => true,
                    "class" => "btn btn-danger fa fa-trash",
                    "value" => ""
                ],
                "view" => [
                    "enable" => true,
                    "class" => "btn btn-success fa fa-list",
                    "value" => ""
                ]
            ],
            "columnsConfig" => array(
                "refe" => [
                    "type" => "string",
                    "displayName" => "Otro",
                    "hidden" => false
                ],
                "fecha" => [
                    "type" => "date",
                    "displayName" => "Fecha",
                    "format" => "Y-m-d"
                ],
                "active" => [
                    "type" => "boolean",
                    "displayName" => "Estado",
                    "valueWhenTrue" => "Activo",
                    "valueWhenFalse" => "Inactivo"
                ],
            )
        ]
    ]
];

return $config;

