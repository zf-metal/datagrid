<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;


/**
 * Description of RenderGrid
 *
 * @author cincarnato
 */
class JsAbmAjaxModal extends AbstractHelper {

    

    public function __invoke($nameObject, $urlEdit, $urlSubmit, $urlDelete = null, $urlDeleteSubmit = null) {

        $return = "<div class='modal fade' id='cdiModal'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
                <h4 class='modal-title'><div id='cdiTitle'>Edicion</div></h4>
            </div>
            <div class='modal-body'>
                <div id='cdiAjaxContent'></div>
            </div>
        </div>
    </div>
</div>";

        $return .= "<script>

    function cdiGoEdit(id) {
        $.get('$urlEdit', {id: id})
                .done(function(data) {
            $('#cdiTitle').html('Edicion');
            $('#cdiAjaxContent').html(data);
            $('#cdiModal').modal('show');

        });
    }
    
    
        function cdiSubmitEdit() {
        var datastring = $('#$nameObject').serialize();
        $.post('$urlSubmit', datastring)
                .done(function(data) {
            $('#cdiAjaxContent').html(data);

        });
    }
    
    
      function refrescar()
    {
        window.location.reload();
    }
</script>  ";

        if ($urlDelete && $urlDeleteSubmit) {
            
            $return .= "<script>

    function cdiGoDelete(id) {
        $.get('$urlDelete', {id: id})
                .done(function(data) {
            $('#cdiTitle').html('Edicion');
            $('#cdiAjaxContent').html(data);
            $('#cdiModal').modal('show');

        });
    }
    
    
        function cdiSubmitDelete() {
        var datastring = $('#$nameObject').serialize();
        $.post('$urlDeleteSubmit', datastring)
                .done(function(data) {
            $('#cdiAjaxContent').html(data);
        });
    }
    
</script>  ";
        }


        return $return;
    }

}

?>
