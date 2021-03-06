<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZfMetal\Datagrid\Column\ColumnInterface;

/**
 * @author cincarnato
 */
class GridFieldLink extends AbstractHelper {

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
        if ($column->getDisplayValue()) {
            return '<a class="' . $column->getClassA() . '" target="_blank" href="' . $data[$column->getName()] . '">' . $column->getDisplayValue() . '</a>';
        } else {
            return '<a class="' . $column->getClassA() . '" target="_blank" href="' . $data[$column->getName()] . '">' . $data[$column->getName()] . '</a>';
        }
    }

}

?>
