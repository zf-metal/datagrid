<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class CrudConfig extends AbstractOptions {

    /**
     * Enable/Disable Crud
     * 
     * @var boolean
     */
    protected $enable = false;

    /**
     * 
     * @var \ZfMetal\Datagrid\Option\CrudItemConfig
     */
    protected $add;

    /**
     * 
     * @var \ZfMetal\Datagrid\Option\CrudItemConfig
     */
    protected $edit;

    /**
     * 
     * @var \ZfMetal\Datagrid\Option\CrudItemConfig
     */
    protected $del;

    /**
     * 
     * @var \ZfMetal\Datagrid\Option\CrudItemConfig
     */
    protected $view;

    function getEnable() {
        return $this->enable;
    }

    function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

    function getAdd() {
        return $this->add;
    }

    function getEdit() {
        return $this->edit;
    }

    function getDel() {
        return $this->del;
    }

    function getView() {
        return $this->view;
    }

    function setAdd($add) {
        if (is_a($add, \ZfMetal\Datagrid\Options\CrudItemConfig::class)) {
            $this->add = $add;
            return $this;
        }
        $this->add = new \ZfMetal\Datagrid\Options\CrudItemConfig($add);
        return $this;
    }

    function setEdit($edit) {
        if (is_a($edit, \ZfMetal\Datagrid\Options\CrudItemConfig::class)) {
            $this->edit = $edit;
            return $this;
        }
        $this->edit = new \ZfMetal\Datagrid\Options\CrudItemConfig($edit);
        return $this;
    }

    function setDel($del) {
        if (is_a($del, \ZfMetal\Datagrid\Options\CrudItemConfig::class)) {
            $this->del = $del;
            return $this;
        }
        $this->del = new \ZfMetal\Datagrid\Options\CrudItemConfig($del);
        return $this;
    }

    function setView($view) {
        if (is_a($view, \ZfMetal\Datagrid\Options\CrudItemConfig::class)) {
            $this->view = $view;
            return $this;
        }
        $this->view = new \ZfMetal\Datagrid\Options\CrudItemConfig($view);
        return $this;
    }

}
