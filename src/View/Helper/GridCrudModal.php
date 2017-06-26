<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Description of RenderGrid
 *
 * @author cincarnato
 */
class GridCrudModal extends AbstractHelper {

    
    public function __invoke($gridId) {

        return $this->getView()->partial('zf-metal/datagrid/js/grid-crud-modal',["gridId" =>$gridId]);
    }

}

?>
