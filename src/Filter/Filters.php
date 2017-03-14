<?php


namespace ZfMetal\Datagrid\Filter;

use Iterator;

/**
 * Description of 
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class Filters implements Iterator {

    /**
     * Description
     * 
     * @var array
     */
    protected $filters = array();
    
    
    private $position = 0;

    public function addFilter(\ZfMetal\Datagrid\Filter\Filter $filter) {
        $this->filters[]=$filter;
    }

    public function __construct() {
        $this->position = 0;
    }

    function rewind() {
        $this->position = 0;
    }

    function current() {
        return $this->filters[$this->position];
    }

    function key() {
        return $this->position;
    }

    function next() {
        ++$this->position;
    }

    function valid() {
        return isset($this->filters[$this->position]);
    }

}
