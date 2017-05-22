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

        $delete = '<div id="zf-metal-grid-delete-confirm-' . $gridId . '" class="alert alert-block alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>Se require confirmación</h4>
                    <p>¿Esta seguro de eliminar el registro?</p>
                    <p>
                            <button type="button" onclick="' . \ZfMetal\Datagrid\C::F_DELETE_CONFIRM . $gridId . '(objectId)" class="btn btn-danger" >Ok</button> 
                            <button type="button" class="btn btn-default" data-dismiss="alert" aria-hidden="true">Cancelar</button>
                    </p>
            </div>';


        $view = '  <script>'.PHP_EOL;;

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_DELETE . $gridId . '(objectId){'
                . ' var asddelete = \'<p><button type="button" onclick="' . \ZfMetal\Datagrid\C::F_DELETE_CONFIRM . $gridId . '(\'+objectId+\')" class="btn btn-danger" >Ok</button> </p>\';'
                . '$("#zf-metal-grid-modal-content-' . $gridId . '").html(asddelete);'
                . '$("#zf-metal-grid-modal-' . $gridId . '").modal("show");'
                . '}'.PHP_EOL;;

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_DELETE_CONFIRM . $gridId . '(objectId){'
                . \ZfMetal\Datagrid\C::F_POST . $gridId . '({' . \ZfMetal\Datagrid\Crud::inputAction . ': "delete", ' . \ZfMetal\Datagrid\Crud::inputId . ': objectId});'
        .'}'.PHP_EOL;;

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_EDIT . $gridId . '(objectId){'
                . \ZfMetal\Datagrid\C::F_POST . $gridId . '({' . \ZfMetal\Datagrid\Crud::inputAction . ': "edit", ' . \ZfMetal\Datagrid\Crud::inputId . ': objectId});}'.PHP_EOL;;

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_VIEW . $gridId . '(objectId){'
                . \ZfMetal\Datagrid\C::F_POST . $gridId . '({' . \ZfMetal\Datagrid\Crud::inputAction . ': "view", ' . \ZfMetal\Datagrid\Crud::inputId . ': objectId});}'.PHP_EOL;;


        $view .= 'function ' . \ZfMetal\Datagrid\C::F_ADD . $gridId . '(){'
                . \ZfMetal\Datagrid\C::F_POST . $gridId . '({' . \ZfMetal\Datagrid\Crud::inputAction . ': "add"});}'.PHP_EOL;;


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
        }'.PHP_EOL;;

        $view .= '</script>'.PHP_EOL;;


        return $view;
    }

}

?>
