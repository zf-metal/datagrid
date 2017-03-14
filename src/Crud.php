<?php

namespace ZfMetal\Datagrid;

/**
 * Description of Crud
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class Crud {

    //Instance
    const instanceGrid = "grid";
    const instanceView = "detail";
    const instanceCrud = "formEntity";
    //MSJS
    const msjDeleteOk = "Record deleted OK";
    const msjDeleteFail = "Record deleted FAIL";
    const msjSaveOk = "Record save OK";
    const msjSaveFail = "Record save FAIL";
    const msjEditOk = "Record edit OK";
    const msjEditFail = "Record edit FAIL";
    //Inputs
    const inputId = "crudId";
    const inputAction = "crudAction";

    protected $crudForm;
    protected $source;
    protected $data;
    protected $id;
    protected $action;
    protected $instanceToRender;
    protected $msj;
    protected $record;

    function __construct($source, $data = null) {
        $this->source = $source;
        $this->data = $data;

        if (key_exists(self::inputId, $this->data)) {
            $this->id = $this->data[self::inputId];
        }
        if (key_exists(self::inputAction, $this->data)) {
            $this->action = $this->data[self::inputAction];
        }
    }
    function getRecord() {
        return $this->record;
    }

    
    function getInstanceToRender() {
        return $this->instanceToRender;
    }

    function getForm() {
        return $this->form;
    }

    function getSource() {
        return $this->source;
    }

    function getRequest() {
        return $this->request;
    }
    
    function getMsj() {
        return $this->msj;
    }

    
    public function getCrudForm() {
        if (!isset($this->crudForm)) {
            $this->crudForm = $this->getSource()->getCrudForm($this->id);
        }
        return $this->crudForm;
    }

    public function crudActions() {
    
        switch ($this->action) {
            case 'delete':
                $this->delete();
                break;
            case 'view':
                $this->view();
                break;
            case 'add':
                $this->add();
                break;
            case 'addSubmit':
                $this->addSubmit();
                break;
            case 'edit':
                $this->edit();
                break;
            case 'editSubmit':
                $this->editSubmit();
                break;
            default:
                return false;
        }
        return true;
    }

    protected function delete() {
        $this->instanceToRender = self::instanceGrid;

        if ($this->getSource()->delRecord($this->id)) {
            $this->msj = self::msjDeleteOk;
        } else {
            $this->msj = self::msjDeleteFail;
        }
    }

    protected function view() {
        $this->instanceToRender = self::instanceView;
        $this->record = $this->getSource()->viewRecord($this->id);
    }

    protected function add() {

        $this->getCrudForm()->add(array(
            'name' => self::inputAction,
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'value' => 'addSubmit'
            )
        ));

        $this->instanceToRender = self::instanceCrud;
    }

    protected function addSubmit() {
        $this->add();
        if ($this->getSource()->saveRecord($this->data)) {
            $this->msj = self::msjSaveOk;
            $this->instanceToRender = self::instanceGrid;
        } else {
            $this->msj = self::msjSaveFail;
            $this->instanceToRender = self::instanceCrud;
        }
    }

    protected function edit() {

        $this->getCrudForm()->add(array(
            'name' => self::inputAction,
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'value' => 'editSubmit'
            )
        ));
        $this->getCrudForm()->add(array(
            'name' => self::inputId,
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'value' => $this->id
            )
        ));

        $this->instanceToRender = self::instanceCrud;
    }

    protected function editSubmit() {
        $this->edit();

        if ($this->getSource()->updateRecord($this->id, $this->data)) {
            $this->msj = self::msjEditOk;
            $this->instanceToRender = self::instanceGrid;
        } else {
            $this->msj = self::msjEditFail;
            $this->instanceToRender = self::instanceCrud;
        }
    }

}
