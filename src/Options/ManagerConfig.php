<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Description of ManagerOptions
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ManagerConfig  extends AbstractOptions{

    /**
     * 
     * 
     * @var string
     */
    protected $customKey;  //get entityName

    
    /**
     *
     * 
     * @var string 
     */
    protected $entityField;
    
    
    
    function getCustomKey() {
        return $this->customKey;
    }

    function getEntityField() {
        return $this->entityField;
    }

    function setCustomKey($customKey) {
        $this->customKey = $customKey;
        return $this;
    }

    function setEntityField($entityField) {
        $this->entityField = $entityField;
        return $this;
    }





}
