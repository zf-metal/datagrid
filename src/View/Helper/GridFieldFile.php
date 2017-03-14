<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZfMetal\Datagrid\Column\ColumnInterface;

/**
 * @author cincarnato
 */
class GridFieldFile extends AbstractHelper {

    /**
     * Invoke helper
     *
     * Proxies to {@link render()}.
     *
     * @param  ColumnInterface $column
     * @param  array $data
     * @return string
     */
    public function __invoke(ColumnInterface $column, array $data) {



        return $this->render($column, $data);
    }

    /**
     * Render a Field from the provided $column and $data
     *
     * @param  ColumnInterface $column
     * @param  array $data
     * @return string
     */
    public function render(ColumnInterface $column, array $data) {
        if ($column->getShowFile()) {
            $fp = $column->getWebpath()."/".$data[$column->getName()];
            if (preg_match("/jpg|png|gif/i", $data[$column->getName()])) {
                
                
                $return = "<img src='" . $fp. "'";
                $return .= " style='width:" . $column->getWidth() . "; height:" . $column->getHeight() . "' ";
                $return .= "/>";
            } else if (preg_match("/pdf/i", $data[$column->getName()])) {
                $return = "<div class='center text-center'>";
                $return .= "<object data='".$fp."' type='application/pdf' width='" . $column->getWidth() . "' height='" . $column->getHeight() . "'>";
                $return .= " alt : <a href='".$fp."'>".$fp."</a>";
                $return .= " </object>";
                $return .= "</div>";
            } else {
                $return = nl2br($data[$column->getName()]);
            }
        } else {
            $return = nl2br($data[$column->getName()]);
        }

        return $return;
    }

}

?>
