<?php

namespace ZfMetal\Datagrid;

class Module {

    const VERSION = '3.0.2dev';

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }
    
     public function getServiceConfig() {
           return include __DIR__ . '/config/services.config.php';
    }

}
