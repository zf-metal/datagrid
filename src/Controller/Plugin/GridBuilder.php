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
     * @param string $entityFullClassName
     * @param string $parentEntityName
     * @param integer $parentEntityId
     * @return \ZfMetal\Datagrid\Grid
     */
    public function __invoke($entityFullClassName, $customKey, $parentEntityName = null, $parentEntityId = null) {
        
        
        /* @var $grid \ZfMetal\Datagrid\Grid */
        $grid = $this->container->build("zf-metal-datagrid", ["customKey" => $customKey]);

        //Filter by Parent
        if ($parentEntityName && $parentEntityId) {
            $sourceConfig = $grid->getOptions()->getSourceConfig();
            
            if (key_exists("doctrineOptions", $sourceConfig) AND key_exists("entityManager", $sourceConfig["doctrineOptions"])) {
                $entityManager = $sourceConfig["doctrineOptions"]["entityManager"];
            } else {
                $entityManager = "doctrine.entitymanager.orm_default";
            }
            $em = $this->container->get($entityManager);
            
            $query = $em->createQueryBuilder()
                    ->select('u')
                    ->from($entityFullClassName, 'u')
                    ->where("u." . $parentEntityName . " = :parentId")
                    ->setParameter("parentId", $parentEntityId);

            $source = new \ZfMetal\Datagrid\Source\DoctrineSource($em, $entityFullClassName, $query);
            $grid->setSource($source);
        }

        //Return Grid
        return $grid;
    }

}
