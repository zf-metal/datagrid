<?php

namespace ZfMetal\Datagrid\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class RelatedEntityController extends AbstractActionController {


    /**
     * Description
     * 
     * @var \ZfMetal\Datagrid\Grid
     */
    protected $grid;

    function __construct(\ZfMetal\Datagrid\Grid $grid) {
        $this->grid = $grid;
    }


    public function gridAction() {
        $this->grid->prepare();
        $viewModel = new \Zend\View\Model\ViewModel(['grid' => $this->grid]);
        $viewModel->setTerminal(true); 
        return $viewModel;
    }

}
