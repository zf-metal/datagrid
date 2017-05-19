<?php

namespace ZfMetal\Datagrid\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class ManagerBuilder extends AbstractPlugin {

    /**
     * @var \Interop\Container\ContainerInterface
     */
    protected $container;

    function __construct(\Interop\Container\ContainerInterface $container) {
        $this->container = $container;
    }

    public function __invoke($customKey, $entity = null) {

        //Get GridOptions
        $gridOptions = $this->container->build('zf-metal-datagrid.options', ["customKey" => $customKey]);

        //Get EntityManager and EntityName
        $entityName = $gridOptions->getSourceConfig()["doctrineOptions"]["entityName"];
        $emKey = $gridOptions->getSourceConfig()["doctrineOptions"]["entityManager"];
        $em = $this->container->get($emKey);

        //Generate Form
        $addSubmit = true;
        $addId = true;
        $form = $this->getController()->formBuilder($em, $entityName, $addSubmit, $addId);

        //If entitiy is set, then bind form
        if ($entity) {
            $form->bind($entity);
        }

        //Process Form
        $formResult = $this->getController()->formProcess($em, $form, true);

        //return manager
        return new \ZfMetal\Datagrid\Manager($em, $customKey, $gridOptions, $entity, $form, $formResult);
    }

}
