<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class CrudConfig extends AbstractOptions {

    const ON_ADD_EDIT = 'edit';
    const ON_ADD_GRID = 'grid';
    const ON_ADD_VIEW = 'view';
    
    const ON_EDIT_EDIT = 'edit';
    const ON_EDIT_GRID = 'grid';
    const ON_EDIT_VIEW = 'view';

    /**
     * Enable/Disable Crud
     * 
     * @var boolean
     */
    protected $enable = false;

    /**
     * 
     * @var string
     */
    protected $onAdd = self::ON_ADD_GRID;

    /**
     * 
     * @var string
     */
    protected $onEdit = self::ON_EDIT_GRID;

    /**
     * name of crud column
     * 
     * @var string
     */
    protected $name = "ZfMetalCrudColumn";

    /**
     * 
     * @var string
     */
    protected $tdClass;

    /**
     * 
     * @var string
     */
    protected $thClass;

    /**
     * left | right
     * 
     * @var boolean
     */
    protected $side = "left";

    /**
     * displayName
     * 
     * @var string
     */
    protected $displayName = null;

    /**
     * 
     * @var \ZfMetal\Datagrid\Options\CrudItemConfig
     */
    protected $add;

    /**
     * 
     * @var \ZfMetal\Datagrid\Options\CrudItemConfig
     */
    protected $edit;

    /**
     * 
     * @var \ZfMetal\Datagrid\Options\CrudItemConfig
     */
    protected $del;

    /**
     * 
     * @var \ZfMetal\Datagrid\Options\CrudItemConfig
     */
    protected $view;

    /**
     * 
     * @var \ZfMetal\Datagrid\Options\CrudItemConfig
     */
    protected $manager;

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

    function getManager() {
        return $this->manager;
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

    function setManager($manager) {
        if (is_a($manager, \ZfMetal\Datagrid\Options\CrudItemConfig::class)) {
            $this->manager = $manager;
            return $this;
        }
        $this->manager = new \ZfMetal\Datagrid\Options\CrudItemConfig($manager);
        return $this;
    }

    function getSide() {
        return $this->side;
    }

    function setSide($side) {
        if ($side != "left" && $side != "right") {
            throw new \Exception("Crud Columns Side must be left or right.");
        }
        $this->side = $side;
        return $this;
    }

    function getDisplayName() {
        return $this->displayName;
    }

    function setDisplayName($displayName) {
        $this->displayName = $displayName;
        return $this;
    }

    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
        return $this;
    }

    function getTdClass() {
        return $this->tdClass;
    }

    function getThClass() {
        return $this->thClass;
    }

    function setTdClass($tdClass) {
        $this->tdClass = $tdClass;
        return $this;
    }

    function setThClass($thClass) {
        $this->thClass = $thClass;
        return $this;
    }
    
    function getOnAdd() {
        return $this->onAdd;
    }

    function getOnEdit() {
        return $this->onEdit;
    }

    function setOnAdd($onAdd) {
        $this->onAdd = $onAdd;
        return $this;
    }

    function setOnEdit($onEdit) {
        $this->onEdit = $onEdit;
        return $this;
    }



}
