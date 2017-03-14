<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Description of RenderGrid
 *
 * @author cincarnato
 */
class GridCrud extends AbstractHelper {

    public function __invoke($gridId) {


        $view = '  <script>';

        $view .= 'function cdiDeleteRecord_' . $gridId . '(objectId){
        if(confirm("¿Esta seguro que desea eliminar el registro?")){
            cdiPost_' . $gridId . '({crudAction: "delete", crudId: objectId});
      
        }
    }';

        $view .= 'function cdiEditRecord_' . $gridId . '(objectId){
            cdiPost_' . $gridId . '({crudAction: "edit", crudId: objectId});
    }';

        $view .= 'function cdiViewRecord_' . $gridId . '(objectId){
            cdiPost_' . $gridId . '({crudAction: "view", crudId: objectId});
    }';


        $view .= 'function cdiAddRecord_' . $gridId . '(){
            cdiPost_' . $gridId . '({crudAction: "add"});
    }';



        $view .= 'function cdiPost_' . $gridId . '(params) {
            var goto = window.location.href;  
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", goto);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}';

        $view .= '</script>';


        return $view;
    }

}

?>
