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
}

?>
