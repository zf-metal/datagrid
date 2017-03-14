<?php

namespace ZfMetal\Datagrid\Column;

/**
 * Description of Column
 *
 * @author cincarnato
 */
class BaseColumn extends AbstractColumn {

      const type = "base";
    
    /**
     * Class to apply in td on column
     * 
     * @var string
     */
    protected $tdClass;

    
    function getTdClass() {
        return $this->tdClass;
    }

    function setTdClass($tdClass) {
        $this->tdClass = $tdClass;
    }
    
    


}

?>
