<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Description of RenderGrid
 *
 * @author cincarnato
 */
class JsCrud extends AbstractHelper  {



    public function __invoke() {


        $view = '  <script>';

        $view .= 'function deleteRecord(objectId){
        if(confirm("¿Esta seguro que desea eliminar el registro?")){
            post({crudAction: "delete", crudId: objectId});
      
        }
    }';

        $view .= 'function editRecord(objectId){
            post({crudAction: "edit", crudId: objectId});
    }';
        
                $view .= 'function viewRecord(objectId){
            post({crudAction: "view", crudId: objectId});
    }';
        
        
           $view .= 'function addRecord(){
            post({crudAction: "add"});
    }';




        $view .= 'function post(params) {
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
