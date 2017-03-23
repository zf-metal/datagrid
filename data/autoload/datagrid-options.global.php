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
                "class" => " glyphicon glyphicon-plus cursor-pointer",
                "value" => " Agregar"
            ],
            "edit" => [
                "enable" => true,
                "class" => " glyphicon glyphicon-edit fa-xs cursor-pointer",
                "value" => ""
            ],
            "del" => [
                "enable" => true,
                "class" => " glyphicon glyphicon-trash cursor-pointer",
                "value" => ""
            ],
            "view" => [
                "enable" => true,
                "class" => " glyphicon glyphicon-list-alt cursor-pointer",
                "value" => ""
            ]
        ],
    )
);
