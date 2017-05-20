<?php

namespace ZfMetal\Datagrid\Source;

use ZfMetal\Datagrid\EventManager\EventProvider;

abstract class AbstractSource extends EventProvider implements SourceInterface {

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var mixed
     */
    protected $data;

    /**
     * Order
     * 
     * @var \ZfMetal\Datagrid\Sort
     */
    protected $sort;

    /**
     * 
     * @var \ZfMetal\Datagrid\Filters
     */
    protected $filters;

    /**
     * 
     * @var \ZfMetal\Datagrid\Search
     */
    protected $search;

    /**
     * The data result.
     *
     * @var \Zend\Paginator\Adapter\AdapterInterface
     */
    protected $paginatorAdapter;

    /**
     * Description
     * 
     * @var \Zend\Log\Logger
     */
    protected $log;

    function getData() {
        return $this->data;
    }

    function setData($data) {
        $this->data = $data;
    }

    public function getPaginatorAdapter() {
        return $this->paginatorAdapter;
    }

    public function setPaginatorAdapter($paginatorAdapter) {
        $this->paginatorAdapter = $paginatorAdapter;
    }

    function getColumns() {
        return $this->columns;
    }

    function setColumns($columns) {
        $this->columns = $columns;
    }

    function getSearch() {
        return $this->search;
    }

    function setSearch(\ZfMetal\Datagrid\Search $search) {
        $this->search = $search;
    }

    function getFilters() {
        return $this->filters;
    }

    public function setFilters(\ZfMetal\Datagrid\Filters $filters) {
        $this->filters = $filters;
    }

    function getSort() {
        return $this->sort;
    }

    function setSort(\ZfMetal\Datagrid\Sort $sort) {
        $this->sort = $sort;
    }

    function getLog() {
        return $this->log;
    }

    function setLog(\Zend\Log\Logger $log) {
        $this->log = $log;
    }

}

?>
