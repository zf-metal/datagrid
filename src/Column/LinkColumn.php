<?php

namespace ZfMetal\Datagrid\Column;

/**
 * Description of Column
 *
 * @author cincarnato
 */
class LinkColumn extends AbstractColumn {

    const type = "link";

    /**
     * css class of tag <a>
     * 
     * @var string
     */
    protected $classA = null;

    /**
     * DisplayValue
     * 
     * @var string
     */
    protected $displayValue = null;
    
    function getClassA() {
        return $this->classA;
    }

    function getDisplayValue() {
        return $this->displayValue;
    }

    function setClassA($classA) {
        $this->classA = $classA;
        return $this;
    }

    function setDisplayValue($displayValue) {
        $this->displayValue = $displayValue;
        return $this;
    }



}

?>
