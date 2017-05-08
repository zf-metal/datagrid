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
     * left | right
     * 
     * @var boolean
     */
    protected $side = "left";

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
    
      /**
     * 
     * @var \ZfMetal\Datagrid\Option\CrudItemConfig
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
        if($side != "left" && $side != "right"){
            throw new \Exception("Crud Columns Side must be left or right.");
        }
        $this->side = $side;
        return $this;
    }



}
