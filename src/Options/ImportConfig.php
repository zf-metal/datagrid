<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class ImportConfig extends AbstractOptions {

    /**
     * @var array
     */
    protected $importFromCsv = array();

    /**
     * @return array
     */
    public function getImportFromCsv()
    {
        return $this->importFromCsv;
    }

    function setImportFromCsv($importFromCsv) {
        $this->importFromCsv= new \ZfMetal\Datagrid\Options\ImportItemConfig($importFromCsv);
        return $this;
    }
}
