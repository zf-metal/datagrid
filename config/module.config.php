<?php

/*
 * This file is part of the Cdi package.
 *
 * (c) Cristian Incarnato
 *
 * @author Cristian Incarnato
 * @license http://opensource.org/licenses/BSD-3-Clause
 * 
 */
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
            'submit' => [
                'enable' => true,
                'value' => 'Submit',
                'class' => 'btn btn-primary',
                'priority' => 10,
            ],
            'cancel' => [
                'enable' => true,
                'value' => 'Cancel',
                'class' => 'btn btn-default',
                'priority' => 20,
            ],
            'clean' => [
                'enable' => false,
                'value' => 'Clean',
                'class' => 'btn btn-warning',
                'priority' => 30,
            ],
        ],
        "flashMessagesConfig" => [
            'enable' => true,
            'add_ok' => "Registro creado con exito",
            'add_fail' => "Formulario invalido, por favor verificar",
            'edit_ok' => "Registro actualizado con exito",
            'edit_fail' => "Formulario invalido, por favor verificar",
            'delete_ok' => "Registro eliminado",
            'delete_fail' => "Falla al intentar eliminar el registro",
        ],
        "crudConfig" => [
            "enable" => false,
            'side' => "left",
            'displayName' => null,
            'onAdd' => \ZfMetal\Datagrid\Options\CrudConfig::ON_ADD_GRID,
            'onEdit' => \ZfMetal\Datagrid\Options\CrudConfig::ON_EDIT_GRID,
            'name' => 'ZfMetalCrudColumn',
            "add" => [
                "enable" => true,
                "class" => " glyphicon glyphicon-plus cursor-pointer",
                "value" => ""
            ],
            "edit" => [
                "enable" => true,
                "class" => " glyphicon glyphicon-edit cursor-pointer",
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
    ),
    'controller_plugins' => [
        'factories' => [
            \ZfMetal\Datagrid\Controller\Plugin\GridBuilder::class => \ZfMetal\Datagrid\Factory\Controller\Plugin\GridBuilderFactory::class,
            \ZfMetal\Datagrid\Controller\Plugin\ManagerBuilder::class => \ZfMetal\Datagrid\Factory\Controller\Plugin\ManagerBuilderFactory::class,
            \ZfMetal\Datagrid\Controller\Plugin\ExportToExcel::class => \ZfMetal\Datagrid\Factory\Controller\Plugin\ExportToExcelFactory::class,
        ],
        'aliases' => [
            'gridBuilder' => \ZfMetal\Datagrid\Controller\Plugin\GridBuilder::class,
            'managerBuilder' => \ZfMetal\Datagrid\Controller\Plugin\ManagerBuilder::class,
            'exportToExcel' => \ZfMetal\Datagrid\Controller\Plugin\ExportToExcel::class,
        ]
    ],
    'controllers' => [
        'factories' => [
            \ZfMetal\Datagrid\Controller\ManagerController::class => \ZfMetal\Datagrid\Factory\Controller\ManagerControllerFactory::class,
            \ZfMetal\Datagrid\Controller\RelatedEntityController::class => \ZfMetal\Datagrid\Factory\Controller\RelatedEntityControllerFactory::class,
        ]
    ],
    'router' => [
        'routes' => [
            'ZfMetal_Datagrid' => [
                'type' => 'Literal',
                'may_terminate' => false,
                'options' => [
                    'route' => '/zfmetal/datagrid',
                ],
                'child_routes' => [
                    'Manager' => [
                        'type' => 'Literal',
                        'may_terminate' => false,
                        'options' => [
                            'route' => '/manager',
                        ],
                        'child_routes' => [
                            'Main' => [
                                'type' => 'Segment',
                                'may_terminate' => true,
                                'options' => [
                                    'route' => '/main/:customKey',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Datagrid\Controller\ManagerController::class,
                                        'action' => 'main',
                                    ],
                                ],
                            ],
                            'RelatedEntity' => [
                                'type' => 'Segment',
                                'may_terminate' => true,
                                'options' => [
                                    'route' => '/related-entity/:customKey/:mainCustomKey/:mainEntityField/:mainEntityId',
                                    'defaults' => [
                                        'controller' => \ZfMetal\Datagrid\Controller\RelatedEntityController::class,
                                        'action' => 'grid',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_helpers' => array(
        'invokables' => array(
            'JsCrud' => 'ZfMetal\Datagrid\View\Helper\JsCrud',
            'JsAbmAjaxModal' => 'ZfMetal\Datagrid\View\Helper\JsAbmAjaxModal',
            //News
            'Grid' => 'ZfMetal\Datagrid\View\Helper\Grid',
            'GridCrud' => 'ZfMetal\Datagrid\View\Helper\GridCrud',
            'GridCrudAjax' => 'ZfMetal\Datagrid\View\Helper\GridCrudAjax',
            'GridField' => 'ZfMetal\Datagrid\View\Helper\GridField',
            'GridFieldString' => 'ZfMetal\Datagrid\View\Helper\GridFieldString',
            'GridFieldText' => 'ZfMetal\Datagrid\View\Helper\GridFieldText',
            'GridFieldBoolean' => 'ZfMetal\Datagrid\View\Helper\GridFieldBoolean',
            'GridFieldDateTime' => 'ZfMetal\Datagrid\View\Helper\GridFieldDateTime',
            'GridFieldExtra' => 'ZfMetal\Datagrid\View\Helper\GridFieldExtra',
            'GridFieldCrud' => 'ZfMetal\Datagrid\View\Helper\GridFieldCrud',
            'GridFieldLink' => 'ZfMetal\Datagrid\View\Helper\GridFieldLink',
            'GridFieldLongText' => 'ZfMetal\Datagrid\View\Helper\GridFieldLongText',
            'GridFieldCustom' => 'ZfMetal\Datagrid\View\Helper\GridFieldCustom',
            'GridFieldFile' => 'ZfMetal\Datagrid\View\Helper\GridFieldFile',
            'GridFieldRelational' => 'ZfMetal\Datagrid\View\Helper\GridFieldRelational',
            'GridBtnAdd' => 'ZfMetal\Datagrid\View\Helper\GridBtnAdd',
            //Manager
            'ManagerRender' => 'ZfMetal\Datagrid\View\Helper\Manager',
            //MODAL
            'GridCrudModal' => 'ZfMetal\Datagrid\View\Helper\GridCrudModal',
            'GridCrudAjaxModal' => 'ZfMetal\Datagrid\View\Helper\GridCrudAjaxModal',
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'ZfMetal\Datagrid' => __DIR__ . '/../view',
        ),
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'template_map' => array(
            'widget/csvForm' => __DIR__ . '/../view/widget/csv-form.phtml',
        ),
    ),
);
