<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Description of RenderGrid
 *
 * @author cincarnato
 */
class GridCrudAjaxModal extends AbstractHelper {

    
    public function __invoke($gridId, $url) {

        return $this->getView()->partial('zf-metal/datagrid/js/grid-crud-ajax-modal',["gridId" => $gridId, "url" => $url]);
    }

}

?>
