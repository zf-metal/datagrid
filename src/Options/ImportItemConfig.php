<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class ImportItemConfig extends AbstractOptions {

    /**
     * Enable | Disable multisearch
     * 
     * @var boolean
     */
    protected $enable = false;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $btnValue;

    /**
     * @var string
     */
    protected $btnClass;

    /**
     * @var string
     */
    protected $btnTag;
    
    function getEnable() {
        return $this->enable;
    }

    function getKey() {
        return $this->key;
    }

    function getBtnValue() {
        return $this->btnValue;
    }

    function getBtnClass() {
        return $this->btnClass;
    }

    function getBtnTag() {
        return $this->btnTag;
    }

    function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

    function setKey($key) {
        $this->key = $key;
        return $this;
    }

    function setBtnValue($btnValue) {
        $this->btnValue = $btnValue;
        return $this;
    }

    function setBtnClass($btnClass) {
        $this->btnClass = $btnClass;
        return $this;
    }

    function setBtnTag($btnTag) {
        $this->btnTag = $btnTag;
        return $this;
    }



}
