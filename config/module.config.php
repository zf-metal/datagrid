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
        'recordsPerPage' => 10,
        'template_default' => 'default',
        "formConfig" => [
            'columns' => \ZfMetal\Commons\Consts::COLUMNS_ONE,
            'style' => \ZfMetal\Commons\Consts::STYLE_MENU_VERTICAL,
        ],
        "crudConfig" => [
            "enable" => false,
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
            ]
        ],
    ),
    'controller_plugins' => [
        'factories' => [
            \ZfMetal\Datagrid\Controller\Plugin\GridBuilder::class => \ZfMetal\Datagrid\Factory\Controller\Plugin\GridBuilderFactory::class,
            \ZfMetal\Datagrid\Controller\Plugin\ManagerBuilder::class => \ZfMetal\Datagrid\Factory\Controller\Plugin\ManagerBuilderFactory::class,
        ],
        'aliases' => [
            'gridBuilder' => \ZfMetal\Datagrid\Controller\Plugin\GridBuilder::class,
            'managerBuilder' => \ZfMetal\Datagrid\Controller\Plugin\ManagerBuilder::class,
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
