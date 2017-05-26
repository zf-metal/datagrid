<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Grid extends AbstractHelper {

    CONST TEMPLATE_PATH = 'zf-metal/datagrid/templates/';

    protected $template = "default";
    protected $instance = \ZfMetal\Datagrid\Grid::INSTANCE_GRID;

    public function __invoke(\ZfMetal\Datagrid\Grid $grid) {

        $this->template = $grid->getTemplate();
        
        $this->instance = $grid->getInstance();
        
        //TO REVIEW
        if($this->instance == \ZfMetal\Datagrid\Grid::INSTANCE_EXPORT_TO_EXCEL ){
            return null;
        }

        $partial = self::TEMPLATE_PATH . $this->template . "/" . $this->instance;
        $partialPagination = self::TEMPLATE_PATH . $this->template . "/pagination";
        $partialFilter = self::TEMPLATE_PATH . $this->template . "/filter";
        $partialSearch = self::TEMPLATE_PATH . $this->template . "/search";
        $partialModal = self::TEMPLATE_PATH . $this->template . "/modal";

        $routeParams = $grid->getQueryArray();
        if (!$routeParams) {
            $routeParams = array();
        }
        $route = $grid->getRoute();

        return $this->view->partial($partial, array(
                    "grid" => $grid,
                    "partialPagination" => $partialPagination,
                    "partialFilter" => $partialFilter,
                    "partialSearch" => $partialSearch,
                    "partialModal" => $partialModal,
                    'routeParams' => $routeParams,
                    'route' => $route));
    }

}
