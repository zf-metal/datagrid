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

    protected function comfigForm() {
        //Set Post Method
        $this->crudForm->setAttribute('method', 'post');

        //Set form Name
        $this->crudForm->setName(\ZfMetal\Datagrid\C::FORM_PREFIX . $this->gridOptions->getGridId());

        //Set id 
        $this->crudForm->setAttribute('id', \ZfMetal\Datagrid\C::FORM_PREFIX . $this->gridOptions->getGridId());


        $this->configFormSubmit();
        $this->configFormCancel();
        $this->configFormClean();
    }

    protected function configFormSubmit() {
        //Config Submit
        if ($this->gridOptions->getFormConfig()->getSubmit()->getEnable()) {
            $this->crudForm->add(array(
                'name' => 'submit',
                'type' => 'Zend\Form\Element\Submit',
                'attributes' => array(
                    'value' => $this->gridOptions->getFormConfig()->getSubmit()->getValue(),
                    'class' => $this->gridOptions->getFormConfig()->getSubmit()->getClass(),
                )
                    ), array(
                'priority' => $this->gridOptions->getFormConfig()->getSubmit()->getPriority(),
            ));
        }
    }

    protected function configFormCancel() {
        //Config Clean
        if ($this->gridOptions->getFormConfig()->getCancel()->getEnable()) {
            $this->crudForm->add(array(
                'name' => 'cancel',
                'type' => 'Zend\Form\Element\Button',
                'attributes' => array(
                    'value' => $this->gridOptions->getFormConfig()->getCancel()->getValue(),
                    'class' => $this->gridOptions->getFormConfig()->getCancel()->getClass(),
                    'onclick' => \ZfMetal\Datagrid\C::F_LIST . $this->gridOptions->getGridId() . '()',
                )
                    ), array(
                'priority' => $this->gridOptions->getFormConfig()->getCancel()->getPriority(),
            ));
        }
    }

    protected function configFormClean() {
        //Config Cancel
        if ($this->gridOptions->getFormConfig()->getClean()->getEnable()) {
            $this->crudForm->add(array(
                'name' => 'clean',
                'type' => 'Zend\Form\Element\Button',
                'attributes' => array(
                    'value' => $this->gridOptions->getFormConfig()->getClean()->getValue(),
                    'class' => $this->gridOptions->getFormConfig()->getClean()->getClass(),
                    'onclick' => \ZfMetal\Datagrid\C::F_CLEAN . $this->gridOptions->getGridId() . '()',
                )
                    ), array(
                'priority' => $this->gridOptions->getFormConfig()->getClean()->getPriority(),
            ));
        }
    }

    public function getCrudForm() {
        if (!isset($this->crudForm)) {
            $this->crudForm = $this->getSource()->getCrudForm($this->id);
            $this->comfigForm();
        }
        return $this->crudForm;
    }

    public function crudActions() {
        switch ($this->action) {
            case 'getImportExample':
                $this->getImportExample();
                break;
            case 'importFromCsv':
                $this->importFromCsv();
                break;
            case 'exportToExcel':
                $this->exportToExcel();
                break;
            case 'exportToCsv':
                $this->exportToCsv();
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

    protected function getImportExample()
    {
        $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_GET_IMPORT_EXAMPLE;
    }

    protected function importFromCsv() {
        $this->record = $this->data['file'];
        $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_IMPORT_FROM_CSV;
    }

    protected function exportToExcel() {
        $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_EXPORT_TO_EXCEL;
    }

    protected function exportToCsv() {
        $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_EXPORT_TO_CSV;
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

        if ($this->getSource()->saveRecord($this->data)) {
            $this->pushMsj(self::MSJ_SUCCESS, $this->getFlashMessengesConfig()->getAddOk());

            //Verifico las opciones para definir la instancia
            switch ($this->gridOptions->getCrudConfig()->getOnAdd()) {
                case \ZfMetal\Datagrid\Options\CrudConfig::ON_ADD_EDIT:
                    $this->id = $this->getSource()->getLastSaveRecord()->getId();
                    $this->edit();
                    $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_FORM;
                    break;
                case \ZfMetal\Datagrid\Options\CrudConfig::ON_ADD_GRID:
                    $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_GRID;
                    break;
                case \ZfMetal\Datagrid\Options\CrudConfig::ON_ADD_VIEW:
                    $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_VIEW;
                    $this->record = $this->getSource()->getLastSaveRecord();
                    break;
                default:
                    $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_GRID;
                    break;
            }
        } else {
            $this->add();
            $this->pushMsj(self::MSJ_ERROR, $this->getFlashMessengesConfig()->getAddFail());
            $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_FORM;
        }
    }

    protected function editSubmit() {

        if ($this->getSource()->updateRecord($this->id, $this->data)) {
            $this->pushMsj(self::MSJ_SUCCESS, $this->getFlashMessengesConfig()->getEditOk());
            //Verifico las opciones para definir la instancia
            switch ($this->gridOptions->getCrudConfig()->getOnEdit()) {
                case \ZfMetal\Datagrid\Options\CrudConfig::ON_EDIT_EDIT:
                    $this->edit();
                    $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_FORM;
                    break;
                case \ZfMetal\Datagrid\Options\CrudConfig::ON_EDIT_GRID:
                    $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_GRID;
                    break;
                case \ZfMetal\Datagrid\Options\CrudConfig::ON_EDIT_VIEW:
                    $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_VIEW;
                    $this->record = $this->getSource()->getLastSaveRecord();
                    break;
                default:
                    $this->instance = \ZfMetal\Datagrid\Grid::INSTANCE_GRID;
                    break;
            }
        } else {
            $this->edit();
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
