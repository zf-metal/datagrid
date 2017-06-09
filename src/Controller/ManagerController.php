<?php

namespace ZfMetal\Datagrid\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ManagerController extends AbstractActionController {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Description
     * 
     * @var \ZfMetal\Datagrid\Grid
     */
    protected $grid;

    function __construct(\Doctrine\ORM\EntityManager $em, \ZfMetal\Datagrid\Grid $grid = null) {
        $this->em = $em;
        $this->grid = $grid;
    }

    function getEm() {
        return $this->em;
    }

    function setEm(Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    public function mainAction() {
        
    }
    
    //To do
    public function listFilterAction() {
        
    }

}
