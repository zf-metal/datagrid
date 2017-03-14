<?php

//move to root "config/autoload/"
return array(
    'zf-metal-datagrid.options' => array(
        'recordsPerPage' => 10,
        'templates' => array(
            'default' => array(
                'form_view' => 'ZfMetal\Datagrid/form/form-default',
                'grid_view' => 'ZfMetal\Datagrid/grid/grid-default',
                'detail_view' => 'ZfMetal\Datagrid/detail/detail-default',
                'pagination_view' => 'ZfMetal\Datagrid/pagination/pagination-default'
            ),
            'ajax' => array(
                'form_view' => 'ZfMetal\Datagrid/form/form-ajax',
                'grid_view' => 'ZfMetal\Datagrid/grid/grid-ajax',
                'detail_view' => 'ZfMetal\Datagrid/detail/detail-ajax',
                'pagination_view' => 'ZfMetal\Datagrid/pagination/pagination-ajax'
            )
        ),
        "crudConfig" => [
            "enable" => true,
            "add" => [
                "enable" => true,
                "class" => " fa fa-plus cursor-pointer",
                "value" => " Agregar"
            ],
            "edit" => [
                "enable" => true,
                "class" => "fa fa-edit fa-xs cursor-pointer",
                "value" => ""
            ],
            "del" => [
                "enable" => true,
                "class" => "fa fa-trash cursor-pointer",
                "value" => ""
            ],
            "view" => [
                "enable" => true,
                "class" => " fa fa-list cursor-pointer",
                "value" => ""
            ]
        ],
    )
);
