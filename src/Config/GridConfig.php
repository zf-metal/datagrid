<?php

namespace ZfMetal\Datagrid\Config;

use Zend\Stdlib\AbstractOptions;

/**
 * Description of GridConfig
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class GridConfig extends AbstractOptions {

    /**
     * Description
     * 
     * @var \ZfMetal\Datagrid\Grid
     */
    protected $grid;

    /**
     * Columns config
     *
     * @var Array
     */
    protected $columnsConfig = array();

    /**
     * Source config
     *
     * @var Array
     */
    protected $sourceConfig = array();

    /**
     * Crud config
     *
     * @var Array
     */
    protected $crudConfig = array();

    public function crudConfigure() {
        if (isset($this->crudConfig["enable"]) && $this->crudConfig["enable"] == true) {
            $this->grid->addCrudColumn("", "left", $this->crudConfig);
        }
    }

    public function mergeColumnsConfig($columnsConfig) {
        $this->columnsConfig = array_merge($this->columnsConfig, $columnsConfig);
    }

    public function mergeCrudConfig($crudConfig) {
        $this->crudConfig = array_merge($this->crudConfig, $crudConfig);
    }

    public function mergeSourceConfig($sourceConfig) {
        $this->sourceConfig = array_merge($this->sourceConfig, $sourceConfig);
    }

    function getColumnsConfig() {
        return $this->columnsConfig;
    }

    function setColumnsConfig(Array $columnsConfig) {
        $this->columnsConfig = $columnsConfig;
    }

    function getSourceConfig() {
        return $this->sourceConfig;
    }

    function setSourceConfig(Array $sourceConfig) {
        $this->sourceConfig = $sourceConfig;
    }

    function getCrudConfig() {
        return $this->crudConfig;
    }

    function setCrudConfig(Array $crudConfig) {
        $this->crudConfig = $crudConfig;
    }

    function getGrid() {
        return $this->grid;
    }

    function setGrid(\ZfMetal\Datagrid\Grid $grid) {
        $this->grid = $grid;
    }

}
