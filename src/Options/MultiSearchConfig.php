<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class MultiSearchConfig extends AbstractOptions {

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
    protected $propertiesEnabled = array();

    function getEnable() {
        return $this->enable;
    }

    function getPropertiesEnabled() {
        return $this->propertiesEnabled;
    }

    function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }

    function setPropertiesEnabled($propertiesEnabled) {
        $this->propertiesEnabled = $propertiesEnabled;
        return $this;
    }


}
