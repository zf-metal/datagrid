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

        $partial = self::TEMPLATE_PATH . $this->template . "/" . $this->instance;
        $partialPagination = self::TEMPLATE_PATH . $this->template . "/pagination";
        $partialFilter = self::TEMPLATE_PATH . $this->template . "/filter";
        $partialSearch = self::TEMPLATE_PATH . $this->template . "/search";

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
                    'routeParams' => $routeParams,
                    'route' => $route));
    }

}
