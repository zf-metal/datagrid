<?php

namespace ZfMetal\Datagrid;

/**
 * Description of Crud
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class Crud {

    //MSJS
    const msjDeleteOk = "Record deleted OK";
    const msjDeleteFail = "Record deleted FAIL";
    const msjSaveOk = "Record save OK";
    const msjSaveFail = "Record save FAIL";
    const msjEditOk = "Record edit OK";
    const msjEditFail = "Record edit FAIL";
    //Inputs
    const inputId = "zfmetal_crud_id";
    const inputAction = "zfmetal_crud_action";

    protected $crudForm;
    protected $source;
    protected $data;
    protected $id;
    protected $action;
    protected $instance;
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
    
    function getAction() {
        return $this->action;
    }

        function getRecord() {
        return $this->record;
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
                return \ZfMetal\Datagrid\Grid::INSTANCE_GRID;
        }
        return $this->instance;
    }

    protected function delete() {
        $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_GRID;

        if ($this->getSource()->delRecord($this->id)) {
            $this->msj = self::msjDeleteOk;
        } else {
            $this->msj = self::msjDeleteFail;
        }
    }

    protected function view() {
        $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_VIEW;
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

        $this->instance= \ZfMetal\Datagrid\Grid::INSTANCE_FORM;
    }

    protected function addSubmit() {
        $this->add();
        if ($this->getSource()->saveRecord($this->data)) {
            $this->msj = self::msjSaveOk;
            $this->instance= \ZfMetal\Datagrid\Grid::INSTANCE_GRID;
        } else {
            $this->msj = self::msjSaveFail;
            $this->instance= \ZfMetal\Datagrid\Grid::INSTANCE_FORM;
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

        $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_FORM;
    }

    protected function editSubmit() {
        $this->edit();

        if ($this->getSource()->updateRecord($this->id, $this->data)) {
            $this->msj = self::msjEditOk;
            $this->instance= \ZfMetal\Datagrid\Grid::INSTANCE_GRID;
        } else {
            $this->msj = self::msjEditFail;
            $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_FORM;
        }
    }

}
