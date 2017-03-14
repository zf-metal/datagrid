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
     * @var ZfMetal\Datagrid\Filter\Filters
     */
    protected $filters;

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


    function getSort() {
        return $this->sort;
    }

    function setSort(\ZfMetal\Datagrid\Sort $sort) {
        $this->sort = $sort;
    }

        
    public function addFilter(\ZfMetal\Datagrid\Filter\Filter $filter) {
        $this->getFilters()->addFilter($filter);
    }

    /**
     * Get Filters
     *
     * @return \ZfMetal\Datagrid\Filters
     */
    function getFilters() {
        if (isset($this->filters)) {
            $this->setFilters(new \ZfMetal\Datagrid\Filter\Filters());
        }
        return $this->filters;
    }

    function setFilters(\ZfMetal\Datagrid\Filters $filters) {
        $this->filters = $filters;
    }
    
    function getLog() {
        return $this->log;
    }

    function setLog(\Zend\Log\Logger $log) {
        $this->log = $log;
    }



}

?>
