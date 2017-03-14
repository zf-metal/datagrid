<?php

namespace ZfMetal\Datagrid\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZfMetal\Datagrid\Column\ColumnInterface;

/**
 * @author cincarnato
 */
class GridField extends AbstractHelper {

    const DEFAULT_HELPER = 'GridFieldText';

    /**
     * Instance map to view helper
     *
     * @var array
     */
    protected $typeMap = array(
        'string' => 'GridFieldString',
        'text' => 'GridFieldText',
        'boolean' => 'GridFieldBoolean',
        'datetime' => 'GridFieldDateTime',
        'link' => 'GridFieldLink',
        'extra' => 'GridFieldExtra',
        'crud' => 'GridFieldCrud',
        'longText' => 'GridFieldLongText',
        'custom' => 'GridFieldCustom',
        'file' => 'GridFieldFile',
    );

    /**
     * Default helper name
     *
     * @var string
     */
    protected $defaultHelper = self::DEFAULT_HELPER;

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
     * Render an field
     *
     * Introspects the element type and attributes to determine which
     * helper to utilize when rendering.
     *
     * @param  ColumnInterface $column
     * @param  array $data
     * @return string
     */
    public function render(ColumnInterface $column, array $data) {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }


        $renderedType = $this->renderType($column, $data);

        if ($renderedType !== null) {
            return $renderedType;
        }

        return $this->renderHelper($this->defaultHelper, $column, $data);
    }

    /**
     * Render element by type map
     *
     * @param ElementInterface $element
     * @return string|null
     */
    protected function renderType(ColumnInterface $column, array $data) {
        if (isset($this->typeMap[$column->getType()])) {
            return $this->renderHelper($this->typeMap[$column->getType()], $column, $data);
        }
        return null;
    }

    /**
     * Render element by helper name
     *
     * @param string $name
     * @param ElementInterface $element
     * @return string
     */
    protected function renderHelper($name, ColumnInterface $column, array $data) {
        $helper = $this->getView()->plugin($name);
        return $helper($column, $data);
    }

    /**
     * Set default helper name
     *
     * @param string $name
     * @return self
     */
    public function setDefaultHelper($name) {
        $this->defaultHelper = $name;
        return $this;
    }

    /**
     * Add form element type to plugin map
     *
     * @param string $type
     * @param string $plugin
     * @return self
     */
    public function addType($type, $plugin) {
        $this->typeMap[$type] = $plugin;

        return $this;
    }

}

?>
