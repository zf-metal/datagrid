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

            //Edit Source QB
            $grid->getSource()->getQb()->where("u." . $mainEntityField . " = :mainEntity")
                    ->setParameter("mainEntity", $mainEntity);


            // Elimina el mainfield del Formulario cuando se dispara el evento buildCrudForm
            $this->grid->getSource()->getEventManager()->attach('buildCrudForm', function($e) use($mainEntityField) {
                $form = $e->getParam('form');
                $form->remove($mainEntityField);
            });


            // Elimina el mainfield del Filtro
            $grid->getForm()->remove($mainEntityField);

            // Elimina la maincolumn del datagrid
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
