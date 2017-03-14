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
     * - with sort statements
     * - with filters statements.
     */
    public function execute();


    /**
     * @param Filter $filters
     */
    public function addFilter(\ZfMetal\Datagrid\Filter\Filter $filter);
}

?>
