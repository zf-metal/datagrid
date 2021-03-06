<?php

namespace ZfMetal\Datagrid\Source;

interface SourceInterface {

    /**
     * @return mixed
     */
    public function getData();

    /**
     * $param array $Columns
     */
    public function setColumns($Columns);

    /**
     * @return array $Columns
     */
    public function pullColumns();

    /**
     * Prepare the query (Filters and Order)
     */
    public function prepare();

    /**
     * Execute the query and set the paginator
     */
    public function execute();

    /**
     * @param \ZfMetal\Datagrid\Search
     */
    public function setSearch(\ZfMetal\Datagrid\Search $search);

    /**
     * @param \ZfMetal\Datagrid\Filters
     */
    public function setFilters(\ZfMetal\Datagrid\Filters $filters);

    /**
     * Execute an export to excel
     */
    public function exportToExcel($configKey);

    /**
     * Execute an export to excel
     */
    public function exportToCsv($configKey);

    /**
     * Execute an import from csv
     */
    public function importFromCsv($file,$configKey);

    /**
     * Get Import Example
     */
    public function getImportExample($configKey);
}

?>
