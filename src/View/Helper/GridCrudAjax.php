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
class GridCrudAjax extends AbstractHelper{


    public function __invoke($gridId,$url) {


        $view = '  <script type="text/javascript">';

        $view .= 'function cdiDeleteRecord_'.$gridId.'(objectId){
        if(confirm("¿Esta seguro que desea eliminar el registro?")){
            cdiPost_'.$gridId.'({crudAction: "delete", crudId: objectId});
      
        }
    }';

        $view .= 'function cdiEditRecord_'.$gridId.'(objectId){
                    cdiPost_'.$gridId.'({crudAction: "edit", crudId: objectId});
                }';

        $view .= 'function cdiListRecords_'.$gridId.'(){
                    cdiPost_'.$gridId.'();
                }'; 

        $view .= 'function cdiViewRecord_'.$gridId.'(objectId){
                    cdiPost_'.$gridId.'({crudAction: "view", crudId: objectId});
                }';


        $view .= 'function cdiAddRecord_'.$gridId.'(){
                    cdiPost_'.$gridId.'({crudAction: "add"});
                }';


        $view .= 'function cdiPagination_'.$gridId.'(url) {
                    $.get(url).done(function (data) {
                    $("#'.$gridId.'").html(data);
                    });
                }';

        $view .= 'function cdiFilter_'.$gridId.'() {
                      $.get("' . $url . '", $("#cdiGridFormFilters_'.$gridId.'").serialize()).done(function (data) {
                          $("#'.$gridId.'").html(data);
                      });
                  }';
        
          $view .= 'function cdiForm_'.$gridId.'(fname) {
                      $.post("' . $url . '", $("#"+fname).serialize()).done(function (data) {
                          $("#'.$gridId.'").html(data);
                      });
                  }';
        
        $view .= 'function cdiOrder_'.$gridId.'(url) {
                      $.get(url).done(function (data) {
                      $("#'.$gridId.'").html(data);
                      });
                  }';
        
        
        $view .= 'function cdiPost_'.$gridId.'(params) {
                    var url = "' . $url . '";  
                    $.post(url,params).done(function (data) {
                    $("#'.$gridId.'").html(data);
                    });
                 }';

        $view .= '</script>';


        return $view;
    }

}

?>
