<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class ExportConfig extends AbstractOptions {

    /**
     * @var array
     */
    protected $exportToExcel = array();

    /**
     * @var boolean
     */
    protected $exportToCsv = array();

    function getExportToExcel() {
        return $this->exportToExcel;
    }

    function getExportToCsv() {
        return $this->exportToCsv;
    }

    function setExportToExcel($exportToExcel) {
        $this->exportToExcel = new \ZfMetal\Datagrid\Options\ExportItemConfig($exportToExcel);
        return $this;
    }

    function setExportToCsv($exportToCsv) {
        $this->exportToCsv = new \ZfMetal\Datagrid\Options\ExportItemConfig($exportToCsv);
        return $this;
    }

}
