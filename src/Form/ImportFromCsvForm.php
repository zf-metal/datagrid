<?php
/**
 * Created by PhpStorm.
 * User: alejo
 * Date: 5/5/18
 * Time: 21:26
 */

namespace ZfMetal\Datagrid\Form;


class ImportFromCsvForm extends \Zend\Form\Form
{

    public function __construct()
    {
        parent::__construct('import');

        $this->add([
            'type' => \Zend\Form\Element\Hidden::class,
            'name' => \ZfMetal\Datagrid\Crud::inputAction,
            'attributes' => [
                'value' => 'importFromCsv',
            ],
        ]);

        $this->add(array(
            'name' => 'file',
            'type' => 'Zend\Form\Element\File',
            'attributes' => array(
                'class' => 'btn btn-default',
                'accept' => "text/csv",
                'id'=>'fileUpload'
            ),
            'options' => array(
                'label' => 'Archivo',
            )
        ));
        $this->add(array(
            'name' => 'import',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => "Importar",
                'class' => 'pull-right btn btn-primary',
            ),
            'options' => array(
                'label' => 'Importar',
            )
        ));
        $this->add(array(
            'name' => 'cancel',
            'type' => 'Zend\Form\Element\Button',
            'attributes' => array(
                'value' => "Cancelar",
                'class' => 'pull-right btn btn-default',
                'id'=>"btnCancel"
            ),
            'options' => array(
                'label' => 'Cancelar',
            )
        ));
    }
}
