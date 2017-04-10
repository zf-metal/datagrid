<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class FormConfig extends AbstractOptions {

    /**
     * Form Columns [COLUMNS_ONE, COLUMNS_TWO,COLUMNS_THREE,COLUMNS_FOUR]
     * 
     * @var string
     */
    protected $columns = \ZfMetal\Commons\Consts::COLUMNS_ONE;

    /**
     * Form Style [STYLE_VERTICAL, STYLE_HORIZONTAL, STYLE_INLINE]
     * 
     * @var string
     */
    protected $style = \ZfMetal\Commons\Consts::STYLE_VERTICAL;

    /**
     * Render Form in Groups
     * 
     * @var array
     */
    protected $groups = array();

    /**
     * Render Form in Groups
     * 
     * @var array
     */
    protected $columnGroups = array();

    function getColumns() {
        return $this->columns;
    }

    function getStyle() {
        return $this->style;
    }

    function getGroups() {
        return $this->groups;
    }

    function setColumns($columns) {
        $this->columns = $columns;
    }

    function setStyle($style) {
        $this->style = $style;
    }

    function setGroups($groups) {
        $this->groups = $groups;
    }
    
    function getColumnGroups() {
        return $this->columnGroups;
    }

    function setColumnGroups($columnGroups) {
        $this->columnGroups = $columnGroups;
        return $this;
    }



}
