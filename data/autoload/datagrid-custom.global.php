<?php

//AN EXAMPLE COLUMNS CONFIG

$config = [
    "cdigridConfigOne" => [
        "sourceConfig" => [
            "type" => "doctrine",
            "doctrineOptions" => [
                "entityName" => "\Application\Entity\Test",
                "entityManager" => "Doctrine\ORM\EntityManager"
            ]
        ],
        "crudConfig" => [
            "enable" => true,
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
];

return $config;

