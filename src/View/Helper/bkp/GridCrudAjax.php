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

        $view = '  <script type="text/javascript">' . PHP_EOL;

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_EXPORT_TO_EXCEL . $gridId . '(){'
                . \ZfMetal\Datagrid\C::F_POST . $gridId . '({' . \ZfMetal\Datagrid\Crud::inputAction . ': "exportToExcel"});

        }'. PHP_EOL;

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_DELETE . $gridId . '(objectId){
        if(confirm("¿Esta seguro que desea eliminar el registro?")){'
                . \ZfMetal\Datagrid\C::F_POST_AJAX . $gridId . '({' . \ZfMetal\Datagrid\Crud::inputAction . ': "delete", ' . \ZfMetal\Datagrid\Crud::inputId . ': objectId});
      
        }
    }' . PHP_EOL;

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_EDIT . $gridId . '(objectId){'
                . \ZfMetal\Datagrid\C::F_POST_AJAX . $gridId . '({' . \ZfMetal\Datagrid\Crud::inputAction . ': "edit", ' . \ZfMetal\Datagrid\Crud::inputId . ': objectId});
                }' . PHP_EOL;

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_LIST . $gridId . '(){'
                . \ZfMetal\Datagrid\C::F_POST_AJAX . $gridId . '();
                }' . PHP_EOL;

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_VIEW . $gridId . '(objectId){'
                . \ZfMetal\Datagrid\C::F_POST_AJAX . $gridId . '({' . \ZfMetal\Datagrid\Crud::inputAction . ': "view", ' . \ZfMetal\Datagrid\Crud::inputId . ': objectId});
                }' . PHP_EOL;


        $view .= 'function ' . \ZfMetal\Datagrid\C::F_ADD . $gridId . '(){'
                . \ZfMetal\Datagrid\C::F_POST_AJAX . $gridId . '({' . \ZfMetal\Datagrid\Crud::inputAction . ': "add"});
                }' . PHP_EOL;


        $view .= 'function ' . \ZfMetal\Datagrid\C::F_PAGINATION . $gridId . '(url) {
                    $.get(url).done(function (data) {
                    $("#' . $gridId . '").html(data);
                    });
                }' . PHP_EOL;

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_FILTER . $gridId . '() {
                      $.get("' . $url . '", $("#' . \ZfMetal\Datagrid\Factory\FormFilterFactory::FORM_FILTER_NAME . $gridId . '").serialize()).done(function (data) {
                          $("#' . $gridId . '").html(data);
                      });
                  }' . PHP_EOL;

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_SEARCH . $gridId . '() {
                      $.get("' . $url . '", $("#' . \ZfMetal\Datagrid\Form\MultiSearch::FORM_SEARCH_NAME . $gridId . '").serialize()).done(function (data) {
                          $("#' . $gridId . '").html(data);
                      });
                  }' . PHP_EOL;

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_FORM . $gridId . '(fname) {
                      $.post("' . $url . '", $("#"+fname).serialize()).done(function (data) {
                          $("#' . $gridId . '").html(data);
                      });
                  }' . PHP_EOL;

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_SORT . $gridId . '(url) {
                      $.get(url).done(function (data) {
                      $("#' . $gridId . '").html(data);
                      });
                  }' . PHP_EOL;


        $view .= 'function ' . \ZfMetal\Datagrid\C::F_POST_AJAX . $gridId . '(params) {
                    var url = "' . $url . '";  
                    $.post(url,params).done(function (data) {
                    $("#' . $gridId . '").html(data);
                    });
                 }' . PHP_EOL;

        $view .= 'function ' . \ZfMetal\Datagrid\C::F_POST . $gridId . '(params) {
            var goto = "' . $url . '";  
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

        $view .= '</script>' . PHP_EOL;


        return $view;
    }

}

?>
