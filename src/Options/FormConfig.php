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
     * Button submit
     * 
     * @var array
     */
    protected $submit;

    /**
     * Button submit
     * 
     * @var array
     */
    protected $cancel;

    /**
     * Button submit
     * 
     * @var array
     */
    protected $clean;

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

    function getGroups() {
        return $this->groups;
    }

    function setGroups($groups) {
        $this->groups = $groups;
        return $this;
    }

    /**
     * 
     * @return \ZfMetal\Datagrid\Options\ButtonFormConfig
     */
    function getSubmit() {
        return $this->submit;
    }

    /**
     * 
     * @return \ZfMetal\Datagrid\Options\ButtonFormConfig
     */
    function getCancel() {
        return $this->cancel;
    }

    /**
     * 
     * @return \ZfMetal\Datagrid\Options\ButtonFormConfig
     */
    function getClean() {
        return $this->clean;
    }

    function setSubmit(array $submit) {
        $this->submit = new \ZfMetal\Datagrid\Options\ButtonFormConfig($submit);
        return $this;
    }

    function setCancel(array $cancel) {
        $this->cancel = new \ZfMetal\Datagrid\Options\ButtonFormConfig($cancel);
        return $this;
    }

    function setClean(array $clean) {
        $this->clean = new \ZfMetal\Datagrid\Options\ButtonFormConfig($clean);
        return $this;
    }

}
