<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class GridOptions extends AbstractOptions implements GridOptionsInterface {

    /**
     * @var array
     */
    protected $templateDefault = "default";

    /**
     * @var integer
     */
    protected $recordsPerPage = 10;

    /**
     * Activate Columns Filter
     * 
     * @var boolean
     */
    protected $columnFilter = true;

    /**
     * Activate Columns Sort
     * 
     * @var boolean
     */
    protected $columnOrder = true;

    /**
     * ID of the GRID
     * 
     * @var string
     */
    protected $gridId = "zfmdg";

    /**
     * Title of the GRID
     * 
     * @var string
     */
    protected $title = "";

    /**
     * Columns config
     *
     * @var Array
     */
    protected $columnsConfig = array();

    /**
     * Crud config
     *
     * @var Array
     */
    protected $crudConfig = array();

    /**
     * Form config
     *
     * @var Array
     */
    protected $formConfig = array();

    /**
     * Source config
     *
     * @var Array
     */
    protected $sourceConfig = array();

    /**
     *
     * key => flap name 
     * value => relatedKeyOption
     * 
     * @var array 
     */
    protected $managerConfig;

    function getManagerConfig() {
        return $this->managerConfig;
    }

    function setManagerConfig($managerConfig) {
        foreach ($managerConfig as $key => $values) {
            $this->managerConfig[$key] = new \ZfMetal\Datagrid\Options\ManagerConfig($values);
        }

        return $this;
    }

    function hasManagerConfigKey($key) {
        return key_exists($key, $this->managerConfig);
    }

    function getManagerConfigKey($key) {
        if ($this->hasManagerConfig($key)) {
            return $this->managerConfig[$key];
        } else {
            return false;
        }
    }

    public function setCustomOptions(array $customOptions) {
        $this->customOptions = $customOptions;
    }

    function getCustomOptions() {
        return $this->customOptions;
    }

    function getTemplateDefault() {
        return $this->templateDefault;
    }

    function setTemplateDefault($templateDefault) {
        $this->templateDefault = $templateDefault;
    }

    function getRecordsPerPage() {
        return $this->recordsPerPage;
    }

    function setRecordsPerPage($recordsPerPage) {
        $this->recordsPerPage = $recordsPerPage;
    }

    function getColumnFilter() {
        return $this->columnFilter;
    }

    function getColumnOrder() {
        return $this->columnOrder;
    }

    function setColumnFilter($columnFilter) {
        $this->columnFilter = $columnFilter;
    }

    function setColumnOrder($columnOrder) {
        $this->columnOrder = $columnOrder;
    }

    function getColumnsConfig() {
        return $this->columnsConfig;
    }

    function getSourceConfig() {
        return $this->sourceConfig;
    }

    function getCrudConfig() {
        return $this->crudConfig;
    }

    function setColumnsConfig(Array $columnsConfig) {
        $this->columnsConfig = $columnsConfig;
    }

    function mergeColumnsConfig(Array $columnsConfig) {
        $this->columnsConfig = array_merge_recursive($this->columnsConfig, $columnsConfig);
    }

    function setSourceConfig(Array $sourceConfig) {
        $this->sourceConfig = $sourceConfig;
    }

    function setCrudConfig($crudConfig) {
        if (is_a($crudConfig, \ZfMetal\Datagrid\Options\CrudConfig::class)) {
            $this->crudConfig = $crudConfig;
            return;
        }
        $this->crudConfig = new \ZfMetal\Datagrid\Options\CrudConfig($crudConfig);
    }

    function getFormConfig() {
        return $this->formConfig;
    }

    function setFormConfig($formConfig) {
        $this->formConfig = new \ZfMetal\Datagrid\Options\FormConfig($formConfig);
    }

    function getGridId() {
        return $this->gridId;
    }

    function setGridId($gridId) {
        $this->gridId = $gridId;
        return $this;
    }
    
    function getTitle() {
        return $this->title;
    }

    function setTitle($title) {
        $this->title = $title;
        return $this;
    }



}
