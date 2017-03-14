<?php

namespace ZfMetal\Datagrid\Column;

/**
 * Description of Column
 *
 * @author cincarnato
 */
class BooleanColumn extends AbstractColumn {

    const type = "boolean";


    /**
     * Value when the value of the column is true
     * 
     * @var string
     */
    protected $valueWhenTrue = "true";

    /**
     * Value when the value of the column is false
     * 
     * @var string
     */
    protected $valueWhenFalse = "false";
    
    
    function getValueWhenTrue() {
        return $this->valueWhenTrue;
    }

    function getValueWhenFalse() {
        return $this->valueWhenFalse;
    }

    function setValueWhenTrue($valueWhenTrue) {
        $this->valueWhenTrue = $valueWhenTrue;
    }

    function setValueWhenFalse($valueWhenFalse) {
        $this->valueWhenFalse = $valueWhenFalse;
    }



}

?>
