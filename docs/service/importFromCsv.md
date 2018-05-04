### Service ImportCsv

    ImportCsv Service is a feature integrated to ZfMetal Datagrid.
    
    To use it, just you have to add its settings in the datagrid configuration file, inside the module-entity-name key , of the entity that you wish to use
        
    Example:
    
    return [
        'zf-metal-datagrid.custom' => [
            'import_config' => [
                'import_from_csv' => [
                    'enable' => true,
                    'key' => '',
                    'btn_class' => 'btn btn-primary pull-right',
                    'btn_value' => 'import',
                    'btn_tag' => 'button',
                ],
            ],
    ...
    
    You can also customize the fields of the entity.    
    
    Example:
    
    return [
        'zf-metal-datagrid.imports'=>[
            'application-entity-consultas'=>[
                'messageOk' => "%d records were imported",
                'messageFail' => "There was an error importing records.",
                'columnsConfig' => [
                    'id' => [
                        'default' => null,
                    ],
                    'contact' => [
                        'displayName' => 'Contact',
                        'type' => 'relational',
                        'field' => 'id',
                        'entity' => Contact::class,
                    ],
                    'date' => [
                        'displayName' => 'Date',
                        'type' => 'datetime',
                        'format' => 'Y-m-d H:i:s',
                        'default' => null,
                    ],
                    'status' => [
                        'displayName' => 'Status',
                        'type' => 'boolean',
                        'valueOfTrue' => 1,
                        'default' => 0,
                    ],
                    'name' => [
                        'displayName' => 'Ask',
                        'default' => null,
                    ],
                ]
            ]
        ],
        'zf-metal-datagrid.custom' => [
            'import_config' => [
                'import_from_csv' => [
                    'enable' => true,
                    'key' => '',
                    'btn_class' => 'btn btn-primary pull-right',
                    'btn_value' => 'import',
                    'btn_tag' => 'button',
                ],
            ],
    ...