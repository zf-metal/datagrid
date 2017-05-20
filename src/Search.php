<?php


namespace ZfMetal\Datagrid;

use Iterator;

/**
 * Description of 
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class Search implements Iterator {

    /**
     * Description
     * 
     * @var array
     */
    protected $search = array();
    
    private $position = 0;

    public function addSearch(\ZfMetal\Datagrid\Filter $filter) {
        $this->search[]=$filter;
    }
 

    public function __construct() {
        $this->position = 0;
    }

    function rewind() {
        $this->position = 0;
    }

    function current() {
        return $this->search[$this->position];
    }

    function key() {
        return $this->position;
    }

    function next() {
        ++$this->position;
    }

    function valid() {
        return isset($this->search[$this->position]);
    }

}
