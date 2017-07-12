<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class CrudItemConfig extends AbstractOptions {
       

    /**
     * Enable/Disable Item Crud
     * 
     * @var boolean
     */
    protected $enable = false;

    /**
     * 
     * @var string
     */
    protected $class;

    /**
     * 
     * @var string
     */
    protected $value;
    
     /**
     * 
     * @var string
     */
    protected $action = null;
    
     
     /**
     * 
     * @var string
     */
    protected $permission = null;
    
     /**
     * 
     * @var string
     */
    protected $htmltag = 'a';

    function getEnable() {
        return $this->enable;
    }

    function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

        
    
    function getClass() {
        return $this->class;
    }

    function getValue() {
        return $this->value;
    }

    function setClass($class) {
        $this->class = $class;
    }

    function setValue($value) {
        $this->value = $value;
    }
    
    function getAction() {
        return $this->action;
    }

    function getHtmltag() {
        return $this->htmltag;
    }

    function setAction($action) {
        $this->action = $action;
        return $this;
    }

    function setHtmltag($htmltag) {
        $this->htmltag = $htmltag;
        return $this;
    }

    function getPermission() {
        return $this->permission;
    }

    function setPermission($permission) {
        $this->permission = $permission;
        return $this;
    }



    
  

}
