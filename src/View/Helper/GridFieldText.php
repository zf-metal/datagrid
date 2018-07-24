<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZfMetal\Datagrid\Column\ColumnInterface;

/**
 * @author cincarnato
 */
class GridFieldText extends AbstractHelper {


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
       
        $value = $data[$column->getName()];



        if(!$value){
        return "";    
        }

        if($column->getMap() && key_exists($value,$column->getMap())){
            $value = $column->getMap()[$value];
        }
        
        if ($column->getLength() && strlen($value) > $column->getLength()) {
            $return = substr(nl2br($value), 0, $column->getLength()) . "...";
        } else {
            $return = nl2br($value);
        }        
        
         if ($column->getTooltip()){
              $return = '<span data-toggle="tooltip" data-placement="bottom" title="'.$value.'" >'.$return.'</span>';
         }



        return $return;
    }



}

?>
