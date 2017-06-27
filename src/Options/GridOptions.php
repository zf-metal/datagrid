<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class GridOptions extends AbstractOptions implements GridOptionsInterface {

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
     * Title when add
     * 
     * @var string
     */
    protected $titleAdd = "";

    /**
     * Title when edit
     * 
     * @var string
     */
    protected $titleEdit = "";

    /**
     * @var array
     */
    protected $templateDefault = "default";

    /**
     * @var integer
     */
    protected $recordsPerPage = 10;

    /**
     * Columns config
     *
     * @var array
     */
    protected $columnsConfig = array();

    /**
     * Crud config
     *
     * @var array
     */
    protected $crudConfig = array();

    /**
     * 
     * @var array
     */
    protected $flashMessagesConfig = array();

    /**
     * Form config
     *
     * @var array
     */
    protected $formConfig = array();

    /**
     * Source config
     *
     * @var array
     */
    protected $sourceConfig = array();

    /**
     * 
     * @var array 
     */
    protected $multiSearchConfig;

    /**
     * 
     * @var array 
     */
    protected $multiFilterConfig;
    
    
     /**
     * 
     * @var array 
     */
    protected $exportConfig;

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

    /**
     * 
     * @return \ZfMetal\Datagrid\Options\FormConfig
     */
    function getFormConfig() {
        return $this->formConfig;
    }

    function setFormConfig($formConfig) {
        $this->formConfig = new \ZfMetal\Datagrid\Options\FormConfig($formConfig);
    }

    function getMultiSearchConfig() {
        return $this->multiSearchConfig;
    }

    function setMultiSearchConfig($multiSearchConfig) {
        $this->multiSearchConfig = new \ZfMetal\Datagrid\Options\MultiSearchConfig($multiSearchConfig);
    }

    function getMultiFilterConfig() {
        return $this->multiFilterConfig;
    }

    function setMultiFilterConfig($multiFilterConfig) {
        $this->multiFilterConfig = new \ZfMetal\Datagrid\Options\MultiFilterConfig($multiFilterConfig);
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

    function getTitleAdd() {
        return $this->titleAdd;
    }

    function getTitleEdit() {
        return $this->titleEdit;
    }

    function setTitleAdd($titleAdd) {
        $this->titleAdd = $titleAdd;
        return $this;
    }

    function setTitleEdit($titleEdit) {
        $this->titleEdit = $titleEdit;
        return $this;
    }

    function getFlashMessagesConfig() {
        return $this->flashMessagesConfig;
    }

    function setFlashMessagesConfig($flashMessagesConfig) {
        if (is_a($flashMessagesConfig, \ZfMetal\Datagrid\Options\FlashMessagesConfig::class)) {
            $this->flashMessagesConfig = $flashMessagesConfig;
            return;
        }
        $this->flashMessagesConfig = new \ZfMetal\Datagrid\Options\FlashMessagesConfig($flashMessagesConfig);
    }
    
    /**
     * 
     * @return \ZfMetal\Datagrid\Options\ExportConfig
     */
    function getExportConfig() {
        return $this->exportConfig;
    }

    function setExportConfig($exportConfig) {
        $this->exportConfig = new \ZfMetal\Datagrid\Options\ExportConfig($exportConfig);
        return $this;
    }




}
