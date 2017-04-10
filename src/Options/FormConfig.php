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
    protected $horizontalGroups = array();

    /**
     * Render Form in Groups
     * 
     * @var array
     */
    protected $verticalGroups = array();

    function getColumns() {
        return $this->columns;
    }

    function getStyle() {
        return $this->style;
    }

  
    function setColumns($columns) {
        $this->columns = $columns;
    }

    function setStyle($style) {
        $this->style = $style;
    }

    function getHorizontalGroups() {
        return $this->horizontalGroups;
    }

    function getVerticalGroups() {
        return $this->verticalGroups;
    }

    function setHorizontalGroups($horizontalGroups) {
        $this->horizontalGroups = $horizontalGroups;
        return $this;
    }

    function setVerticalGroups($verticalGroups) {
        $this->verticalGroups = $verticalGroups;
        return $this;
    }





}
