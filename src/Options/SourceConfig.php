<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class FormConfig extends AbstractOptions {

    /**
     * SourceType
     * 
     * @var string
     */
    protected $type = null;

    /**
     * Source Options
     * 
     * @var array
     */
    protected $sourceOptions = array();

    function getType() {
        return $this->type;
    }

    function getSourceOptions() {
        return $this->sourceOptions;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setSourceOptions($sourceOptions) {
        $this->sourceOptions = $sourceOptions;
    }

    function getSourceOptionByKey($key) {
        if (key_exists($key, $this->sourceOptions)) {
            return $this->sourceOptions[$key];
        }
        return null;
    }

}
