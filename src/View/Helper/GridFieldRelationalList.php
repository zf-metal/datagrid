<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZfMetal\Datagrid\Column\ColumnInterface;
use ZfMetal\Datagrid\Column\RelationalColumn;

/**
 * @author cincarnato
 */
class GridFieldRelationalList extends AbstractHelper
{

    /**
     * Invoke helper
     *
     * Proxies to {@link render()}.
     *
     * @param  ColumnInterface $column
     * @param  array $data
     * @return string
     */
    public function __invoke(ColumnInterface $column, array $data)
    {
        return $this->render($column, $data);
    }

    /**
     * Render a Field from the provided $column and $data
     *
     * @param  ColumnInterface $column
     * @param  array $data
     * @return string
     */
    public function render(RelationalColumn $column, array $data)
    {
        $list = $data[$column->getName()];

        if (!$list) {
            return "";
        }

        if ($column->getField()) {
            $method = $this->buildGetMethod($column->getField());
        } else {
            $method = "__toString";
        }

        $return = '<ul>';

        foreach ($list as $item) {
            $return .= '<li>' . $this->printItem($item, $method) . '</li>';

        }
        $return .= '</ul>';


        if ($column->getTooltip()) {
            $return = '<span data-toggle="tooltip" data-placement="bottom" title="' . $record . '" >' . $return . '</span>';
        }

        return $return;

        //return nl2br($data[$column->getName()]);
    }

    private function buildGetMethod($name)
    {
        return 'get' . ucfirst($name);
    }

    private function printItem($item, $method)
    {
        $record = "";
        try {
            if (method_exists($item, $method)) {
                $record = $item->$method();
            } else if (method_exists($item, "__toString")) {
                $record = $item->__toString();
            }
        } catch (\Exception $e) {
            $record = "";
        }
        return $record;
    }

}

?>
