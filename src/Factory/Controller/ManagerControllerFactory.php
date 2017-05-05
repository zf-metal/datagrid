<?php

namespace ZfMetal\Datagrid\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ManagerControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {


        //1. RouteMatch
        $routeMatch = $container->get('application')->getMvcEvent()->getRouteMatch();

        //2.get params 
        $customKey = $routeMatch->getParam('customKey');
        $mainCustomKey = $routeMatch->getParam('mainCustomKey');
        $mainEntityField = $routeMatch->getParam('mainEntityField');
        $mainEntityId = $routeMatch->getParam('mainEntityId');

        //3.MainGridOptions
        $mainGridOptions = $container->build('zf-metal-datagrid.options', ["customKey" => $mainCustomKey]);
       
        //4. EntityManager
        $mainEntityName = $mainGridOptions->getSourceConfig()["doctrineOptions"]["entityName"];
        $emKey = $mainGridOptions->getSourceConfig()["doctrineOptions"]["entityManager"];
        $em = $container->get($emKey);
        
        //5. Main Entity
        $mainEntity = $em->getRepository($mainEntityName)->find($mainEntityId);

        if (!$mainEntity) {
            throw new \Exception("Main Entitiy not found");
        }

        //6. Build Grid
        $gridBuilder = new \ZfMetal\Datagrid\Builder\GridBuilder($container);
        $grid = $gridBuilder->build($customKey, $mainEntityField, $mainEntity);
        $grid->setTemplate("ajax");

        return new \ZfMetal\Datagrid\Controller\ManagerController($em,$grid);
    }

}
