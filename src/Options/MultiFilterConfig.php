<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class MultiFilterConfig extends AbstractOptions {

    /**
     * Enable | Disable multisearch
     * 
     * @var boolean
     */
    protected $enable = false;

    /**
     * Properties to search
     * 
     * @var array
     */
    protected $propertiesDisabled = array();

    function getEnable() {
        return $this->enable;
    }

    function getPropertiesDisabled() {
        return $this->propertiesDisabled;
    }

    function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

    function setPropertiesDisabled($propertiesDisabled) {
        $this->propertiesDisabled = $propertiesDisabled;
        return $this;
    }




}
