<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZfMetal\Datagrid\Column\ColumnInterface;

/**
 * @author cincarnato
 */
class GridFieldRelational extends AbstractHelper {

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
        $record = $data[$column->getName()];

        if(!$record){
            return "";
        }

        if ($column->getField()) {
            $method = $this->buildGedMethod($column->getField());
        } else {
            $method = "__toString";
        }

        try {
            if (method_exists($record, $method)) {
                $record = $record->$method();
            } else if (method_exists($record, "__toString")) {
                $record = $record->__toString();
            }
        } catch (\Exception $e) {
            $record = "";
        }


        if ($column->getLength() && strlen($record) > $column->getLength()) {
            $return = substr(nl2br($record), 0, $column->getLength()) . "...";
        } else {
            $return = nl2br($record);
        }

        if ($column->getTooltip()){
            $return = '<span data-toggle="tooltip" data-placement="bottom" title="'.$record.'" >'.$return.'</span>';
        }

        return $return;

        //return nl2br($data[$column->getName()]);
    }

    private function buildGedMethod($name) {
        return 'get' . ucfirst($name);
    }

}

?>
