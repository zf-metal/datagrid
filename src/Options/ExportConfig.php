<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class ExportConfig extends AbstractOptions {

    /**
     * Enable | Disable multisearch
     * 
     * @var boolean
     */
    protected $exportToExcelEnable = false;

    /**
     * 
     * @var boolean
     */
    protected $exportToExcelKey;

    function getExportToExcelEnable() {
        return $this->exportToExcelEnable;
    }

    function setExportToExcelEnable($exportToExcelEnable) {
        $this->exportToExcelEnable = $exportToExcelEnable;
        return $this;
    }
    
    function getExportToExcelKey() {
        return $this->exportToExcelKey;
    }

    function setExportToExcelKey($exportToExcelKey) {
        $this->exportToExcelKey = $exportToExcelKey;
        return $this;
    }



}
