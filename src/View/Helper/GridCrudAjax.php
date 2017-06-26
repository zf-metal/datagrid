<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RenderGrid
 *
 * @author cincarnato
 */
class GridCrudAjax extends AbstractHelper {

    public function __invoke($gridId, $url) {

        return $this->getView()->partial('zf-metal/datagrid/js/grid-crud-ajax', ["gridId" => $gridId, "url" => $url]);
    }

}

?>
