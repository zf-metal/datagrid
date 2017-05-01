<?php

namespace ZfMetal\Datagrid\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class GridBuilder extends AbstractPlugin {

    /**
     * @var \Interop\Container\ContainerInterface
     */
    protected $container;
    
    
    function __construct(\Interop\Container\ContainerInterface $container) {
        $this->container = $container;
    }

        /**
     * Generate a Form from Entity
     * 
     * @param string $entityName
     * @param string $entityParentFilter
     * @param integer $entityParentId
     * @return \ZfMetal\Datagrid\Grid
     */
    public function __invoke($entityName, $entityParentFilter = null, $entityParentId = null ) {

    }

}
