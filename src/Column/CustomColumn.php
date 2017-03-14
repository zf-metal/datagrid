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


    
}

?>
