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
    public function __invoke($customKey, $relatedEntityField = null, $relatedEntity = null) {


        /* @var $grid \ZfMetal\Datagrid\Grid */
        $grid = $this->container->build("zf-metal-datagrid", ["customKey" => $customKey]);

        //Filter by Parent
        if ($relatedEntityField && $relatedEntity) {

            //Get Source Config
            $sourceConfig = $grid->getOptions()->getSourceConfig();

            //Get EntityManager
            if (key_exists("doctrineOptions", $sourceConfig) AND key_exists("entityManager", $sourceConfig["doctrineOptions"])) {
                $entityManager = $sourceConfig["doctrineOptions"]["entityManager"];
            } else {
                $entityManager = "doctrine.entitymanager.orm_default";
            }

            //Get EntityName
            if (key_exists("doctrineOptions", $sourceConfig) AND key_exists("entityName", $sourceConfig["doctrineOptions"])) {
                $entityName = $sourceConfig["doctrineOptions"]["entityName"];
            }else{
                throw new \Exception("EntityName is not defined. Check CustomKey");
            }


            $em = $this->container->get($entityManager);

            //Generate Query
            $query = $em->createQueryBuilder()
                    ->select('u')
                    ->from($entityName, 'u')
                    ->where("u." . $relatedEntityField . " = :relatedEntity")
                    ->setParameter("relatedEntity", $relatedEntity);

            //Set Source to Grid
            $source = new \ZfMetal\Datagrid\Source\DoctrineSource($em, $entityName, $query);
            $grid->setSource($source);


            // Elimina el cliente del Formulario
            $grid->getCrudForm()->remove($relatedEntityField);

            // Elimina el cliente del Filtro
            $grid->getForm()->remove($relatedEntityField);

            // Elimina la columna cliente del datagrid
            $grid->setColumnsConfig(array_merge_recursive($grid->getColumnsConfig(), [$relatedEntityField => ['hidden' => true]]));

            //Attach event to form
            $grid->getSource()->getEventManager()->attach('saveRecord_before', function($e) use ($relatedEntityField, $relatedEntity) {
                $record = $e->getParam('record');
                $setter = $this->getSetterByName($relatedEntityField);
                $record->$setter($relatedEntity);
            });
        }

        //Return Grid
        return $grid;
    }

    protected function getSetterByName($name) {
        return "set" . ucfirst($name);
    }

}
