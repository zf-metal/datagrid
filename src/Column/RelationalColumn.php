<?php

namespace ZfMetal\Datagrid\Column;

/**
 * Description of Column
 *
 * @author cincarnato
 */
class RelationalColumn extends AbstractColumn {

    const type = "relational";
    
    
    protected $orderProperty = 'id';
    
    protected $relationalId;
    protected $relationalEntity;
    
    
    function getRelationalId() {
        return $this->relationalId;
    }

    function getRelationalEntity() {
        return $this->relationalEntity;
    }

    function setRelationalId($relationalId) {
        $this->relationalId = $relationalId;
    }

    function setRelationalEntity($relationalEntity) {
        $this->relationalEntity = $relationalEntity;
    }


    function getOrderProperty() {
        return $this->orderProperty;
    }

    function setOrderProperty($orderProperty) {
        $this->orderProperty = $orderProperty;
    }





}

?>
