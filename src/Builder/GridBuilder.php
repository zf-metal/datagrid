<?php

namespace ZfMetal\Datagrid\Builder;

class GridBuilder {

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
     * @return \ZfMetal\Datagrid\Grid
     */
    public function build($customKey, $mainEntityField = null, $mainEntity = null) {


        /* @var $grid \ZfMetal\Datagrid\Grid */
        $grid = $this->container->build("zf-metal-datagrid", ["customKey" => $customKey]);

        //Filter by Parent
        if ($mainEntityField && $mainEntity) {

            //Get Source Config
            $sourceConfig = $grid->getOptions()->getSourceConfig();

            //Get EntityManager
            $em = $this->container->get($sourceConfig["doctrineOptions"]["entityManager"]);

            //Get EntityName
            $entityName = $sourceConfig["doctrineOptions"]["entityName"];
            if (!$entityName) {
                throw new \Exception("EntityName is not defined. Check CustomKey");
            }

            //Generate Query
            $query = $em->createQueryBuilder()
                    ->select('u')
                    ->from($entityName, 'u')
                    ->where("u." . $mainEntityField . " = :mainEntity")
                    ->setParameter("mainEntity", $mainEntity);

            //Set Source to Grid
            $source = new \ZfMetal\Datagrid\Source\DoctrineSource($em, $entityName, $query);
            $grid->setSource($source);


            // Elimina el cliente del Formulario
            $grid->getCrudForm()->remove($mainEntityField);

            // Elimina el cliente del Filtro
            $grid->getForm()->remove($mainEntityField);

            // Elimina la columna cliente del datagrid
            $grid->setColumnsConfig(array_merge_recursive($grid->getColumnsConfig(), [$mainEntityField => ['hidden' => true]]));

            //Attach event to form
            $grid->getSource()->getEventManager()->attach('saveRecord_before', function($e) use ($mainEntityField, $mainEntity) {
                $record = $e->getParam('record');
                $setter = $this->getSetterByName($mainEntityField);
                $record->$setter($mainEntity);
            });
        }

        //Return Grid
        return $grid;
    }

    protected function getSetterByName($name) {
        return "set" . ucfirst($name);
    }

}
