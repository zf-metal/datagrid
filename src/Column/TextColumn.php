<?php

namespace ZfMetal\Datagrid\Column;

/**
 * Description of Column
 *
 * @author cincarnato
 */
class TextColumn extends AbstractColumn {

    const type = "text";
    
    /**
     * Max lenght text
     * 
     * @var integer
     */
    protected $length = null;
    
    /**
     * Enable Tooltip
     * 
     * @var boolean
     */
    protected $tooltip = false;
    
    function getLength() {
        return $this->length;
    }

    function setLength($length) {
        $this->length = $length;
        return $this;
    }

    function getTooltip() {
        return $this->tooltip;
    }

    function setTooltip($tooltip) {
        $this->tooltip = $tooltip;
        return $this;
    }



}

?>
