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

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_DELETE . $gridId . '(objectId){
            if(confirm("¿Esta seguro que desea eliminar el registro?")){'
                . \ZfMetal\Datagrid\C::F_POST . $gridId . '({' . \ZfMetal\Datagrid\Crud::inputAction . ': "delete", ' . \ZfMetal\Datagrid\Crud::inputId . ': objectId});
            }
        }';


        $view .= 'function ' . \ZfMetal\Datagrid\C::F_EDIT . $gridId . '(objectId){'
                . \ZfMetal\Datagrid\C::F_POST . $gridId . '({' . \ZfMetal\Datagrid\Crud::inputAction . ': "edit", ' . \ZfMetal\Datagrid\Crud::inputId . ': objectId});}';

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_VIEW . $gridId . '(objectId){'
                . \ZfMetal\Datagrid\C::F_POST . $gridId . '({' . \ZfMetal\Datagrid\Crud::inputAction . ': "view", ' . \ZfMetal\Datagrid\Crud::inputId . ': objectId});}';


        $view .= 'function ' . \ZfMetal\Datagrid\C::F_ADD . $gridId . '(){'
                . \ZfMetal\Datagrid\C::F_POST . $gridId . '({' . \ZfMetal\Datagrid\Crud::inputAction . ': "add"});}';


        $view .= 'function ' . \ZfMetal\Datagrid\C::F_POST . $gridId . '(params) {
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
