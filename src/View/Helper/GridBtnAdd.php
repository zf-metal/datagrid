<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfMetal\Datagrid\DataGrid\Column\InterfaceColumn;

/**
 * @author cincarnato
 */
class GridBtnAdd extends AbstractHelper {

    /**
     * Invoke helper
     *
     * Proxies to {@link render()}.
     *
     * @param  InterfaceColumn $column
     * @param  array $data
     * @return string
     */
    public function __invoke($name, $class, $value,$onclick) {
        return $this->render($name, $class, $value,$onclick);
    }

    /**
     * Render a Btn
     *
     * @param  string $name
     * @param  string $class
     * @param  string $value
     * * @param  string onclick
     * @return string
     */
    public function render($name, $class, $value,$onclick) {

        $output = "<a id='.$name.' name='.$name.' class='" . $class . "' onclick='".$onclick."'>" . $value . "</a>";

        return $output;
    }

}

?>
