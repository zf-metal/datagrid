<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Manager extends AbstractHelper  {
    
    CONST TEMPLATE_PATH = 'zf-metal/datagrid/manager/';
    
    
    public function __invoke(\ZfMetal\Datagrid\Manager $manager, $template = "default") {

        $partial = self::TEMPLATE_PATH.$template;
        
        return $this->view->partial($partial, [ "manager" => $manager]);
    }

}
