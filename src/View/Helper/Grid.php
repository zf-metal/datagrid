<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Grid extends AbstractHelper  {


    public function __invoke(\ZfMetal\Datagrid\Grid $grid) {

        $template = $grid->getTemplate();
        $templates = $grid->getOptions()->getTemplates();

        switch ($grid->getInstanceToRender()) {
            case "formEntity":
                $partial = $templates[$template]["form_view"];
                break;
            case "grid":
                $partial = $templates[$template]["grid_view"];
                break;
            case "detail":
                $partial = $templates[$template]["detail_view"];
                break;
            default:
                $partial = $templates[$template]["grid_view"];
                break;
        }

        $partialPagination = $templates[$template]["pagination_view"];

        $routeParams = $grid->getQueryArray();
        if (!$routeParams) {
            $routeParams = array();
        }
        $route = $grid->getRoute();

        return $this->view->partial($partial, array(
                    "grid" => $grid,
                    "partialPagination" => $partialPagination,
                    'routeParams' => $routeParams,
                    'route' => $route));
    }

}
