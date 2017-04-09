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
    
  

}
