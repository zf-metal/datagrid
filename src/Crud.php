<?php

namespace ZfMetal\Datagrid;

/**
 * Description of Crud
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class Crud {

    const MSJ_SUCCESS = 1;
    const MSJ_ERROR = 2;
    const MSJ_WARNING = 3;
    const MSJ_INFO = 4;
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

    /**
     *
     * @var \Zend\Mvc\Plugin\FlashMessenger\FlashMessenger
     */
    protected $flashMessenger;

    /**
     *
     * @var \ZfMetal\Datagrid\Options\GridOptions
     */
    protected $gridOptions;

    function __construct($source, $data = null, \Zend\Mvc\Plugin\FlashMessenger\FlashMessenger $flashMessenger, \ZfMetal\Datagrid\Options\GridOptions $gridOptions) {
        $this->source = $source;
        $this->data = $data;

        if (key_exists(self::inputId, $this->data)) {
            $this->id = $this->data[self::inputId];
        }
        if (key_exists(self::inputAction, $this->data)) {
            $this->action = $this->data[self::inputAction];
        }

        $this->flashMessenger = $flashMessenger;
        $this->gridOptions = $gridOptions;
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
             case 'exportToExcel':
                $this->exportToExcel();
                break;
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

    
      protected function exportToExcel() {
        $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_EXPORT_TO_EXCEL;
        $this->getSource()->exportToExcel($this->getGridOptions()->getExportConfig()->getExportToExcelKey());
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

        $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_FORM;
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

    protected function pushMsj($type, $msj) {
        if ($this->getFlashMessengesConfig()->getEnable()) {
            if ($type == self::MSJ_SUCCESS) {
                $this->getFlashMessenger()->addSuccessMessage($msj);
                $this->msj["success"] = $msj;
            }
            if ($type == self::MSJ_ERROR) {
                $this->getFlashMessenger()->addErrorMessage($msj);
                $this->msj["error"] = $msj;
            }
            if ($type == self::MSJ_WARNING) {
                $this->getFlashMessenger()->addWarningMessage($msj);
                $this->msj["warning"] = $msj;
            }
            if ($type == self::MSJ_INFO) {
                $this->getFlashMessenger()->addInfoMessage($msj);
                $this->msj["info"] = $msj;
            }
        }
    }

    protected function delete() {
        $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_GRID;

        if ($this->getSource()->delRecord($this->id)) {
            $this->pushMsj(self::MSJ_INFO, $this->getFlashMessengesConfig()->getDeleteOk());
        } else {
            $this->pushMsj(self::MSJ_ERROR, $this->getFlashMessengesConfig()->getDeleteFail());
        }
    }

    protected function addSubmit() {
        $this->add();
        if ($this->getSource()->saveRecord($this->data)) {
            $this->pushMsj(self::MSJ_SUCCESS, $this->getFlashMessengesConfig()->getAddOk());
            $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_GRID;
        } else {
            $this->pushMsj(self::MSJ_ERROR, $this->getFlashMessengesConfig()->getAddFail());
            $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_FORM;
        }
    }

    protected function editSubmit() {
        $this->edit();

        if ($this->getSource()->updateRecord($this->id, $this->data)) {
            $this->pushMsj(self::MSJ_SUCCESS, $this->getFlashMessengesConfig()->getEditOk());
            $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_GRID;
        } else {
            $this->pushMsj(self::MSJ_ERROR, $this->getFlashMessengesConfig()->getEditFail());
            $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_FORM;
        }
    }

    function getFlashMessenger() {
        return $this->flashMessenger;
    }

    function getFlashMessengesConfig() {
        return $this->getGridOptions()->getFlashMessagesConfig();
    }
    
    function getGridOptions() {
        return $this->gridOptions;
    }



}
