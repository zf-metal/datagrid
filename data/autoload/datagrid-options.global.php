<?php

//move to root "config/autoload/"
return array(
    'zf-metal-datagrid.options' => array(
        'grid_id' => 'test',
        'title' => '',
        'title_add' => '',
        'title_edit' => '',
        'records_per_page' => 10,
        'template_default' => 'default',
        'export_config' => [
            'export_to_excel' => [
                'enable' => false,
                'key' => '',
                'btn_class' => 'btn btn-default',
                'btn_value' => 'excel',
                'btn_tag' => 'button',
            ],
            'export_to_csv' => [
                'enable' => false,
                'key' => '',
                'btn_class' => 'btn btn-default',
                'btn_value' => 'excel',
                'btn_tag' => 'button',
            ],
        ],
        'multi_filter_config' => [
            "enable" => true,
            "properties_disabled" => []
        ],
        "multi_search_config" => [
            "enable" => false,
            "properties_enabled" => []
        ],
        "formConfig" => [
            'columns' => \ZfMetal\Commons\Consts::COLUMNS_ONE,
            'style' => \ZfMetal\Commons\Consts::STYLE_MENU_VERTICAL,
        ],
        "crudConfig" => [
            "enable" => true,
            "side" => "left",
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
            ],
            "manager" => [
                "enable" => false,
                "class" => " glyphicon glyphicon-asterisk fa-xs cursor-pointer",
                "value" => "",
                "action" => ""
            ],
        ],
    )
);
