<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class ButtonFormConfig extends AbstractOptions {

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
     * @var integer
     */
    protected $priority;

    function getEnable() {
        return $this->enable;
    }

    function getClass() {
        return $this->class;
    }

    function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

    function setClass($class) {
        $this->class = $class;
        return $this;
    }

    function getValue() {
        return $this->value;
    }

    function setValue($value) {
        $this->value = $value;
        return $this;
    }
    
    function getPriority() {
        return $this->priority;
    }

    function setPriority($priority) {
        $this->priority = $priority;
        return $this;
    }



}
