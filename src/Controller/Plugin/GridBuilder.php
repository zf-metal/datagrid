<?php

namespace ZfMetal\Datagrid\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class GridBuilder extends AbstractPlugin {

    /**
     * @var \ZfMetal\Datagrid\Builder\GridBuilder
     */
    protected $gridBuilder;

    function __construct(\ZfMetal\Datagrid\Builder\GridBuilder $gridBuilder) {
        $this->gridBuilder = $gridBuilder;
    }

    /**
     * Generate a Form from Entity
     * 
     * @param string $entityFullClassName
     * @param string $parentEntityName
     * @param integer $parentEntityId
     * @return \ZfMetal\Datagrid\Grid
     */
    public function __invoke($customKey, $mainEntityField = null, $mainEntity = null) {

        return $this->getGridBuilder()->build($customKey, $mainEntityField, $mainEntity);
    }
    
    function getGridBuilder() {
        return $this->gridBuilder;
    }





}
