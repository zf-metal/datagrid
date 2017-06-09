<?php

namespace ZfMetal\Datagrid\Column;

/**
 * Description of Column
 *
 * @author cincarnato
 */
class CustomColumn extends AbstractColumn {

    const type = "custom";
    protected $helper;
    protected $data;
    protected $side;
    
    function getHelper() {
        return $this->helper;
    }

    function getData() {
        return $this->data;
    }

    function setHelper($helper) {
        $this->helper = $helper;
    }

    function setData($data) {
        $this->data = $data;
    }

    public function getSide() {
        return $this->side;
    }

    public function setSide($side) {
        if ($side == "left" || $side == "right") {
            $this->side = $side;
        } else {
            throw new \Exception("The side must be 'left' or 'right'");
        }
    }
}

?>
