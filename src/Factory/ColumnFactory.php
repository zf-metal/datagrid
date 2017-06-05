<?php

namespace ZfMetal\Datagrid\Factory;

use ZfMetal\Datagrid\Column;

/**
 * Description of ColumnFactory
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ColumnFactory {

    /**
     * Column to create
     * 
     * @var \ZfMetal\Datagrid\Column\BaseColumn
     */
    protected $column = null;

    /**
     * Config
     * 
     * @var array
     */
    protected $config = array();

    /**
     * 
     * @var \ZfMetal\Datagrid\Grid
     */
    protected $grid = null;

    public function create($name, Array $config) {
        $this->column = null;
        $this->config = $config;
        $type = (isset($config['type'])) ? $config['type'] : "string";


        switch ($type) {
            case "string":
                $this->createStringColumn($name);
                break;
            case "text":
                $this->createTextColumn($name);
                break;
            case "link":
                $this->createLinkColumn($name);
                break;
            case "boolean":
                $this->createBooleanColumn($name);
                break;
            case "datetime":
                $this->createDateTimeColumn($name);
                break;
            case "date":
                $this->createDateTimeColumn($name);
                break;
            case "time":
                $this->createDateTimeColumn($name);
                break;
            case "extra":
                $this->createExtraColumn($name);
                break;
            case "custom":
                $this->createCustomColumn($name);
                break;
            case "file":
                $this->createFileColumn($name);
                break;
            case "relational":
                $this->createRelationalColumn($name);
                break;
            default:
                $this->createStringColumn($name);
                break;
        }

        return $this->column;
    }

    /**
     * Configure basic properties
     *
     * @param string $name name of the column
     * @return \ZfMetal\Datagrid\Column\InterfaceColumn
     */
    protected function baseConfig() {

        if (isset($this->config["displayName"])) {
            $this->column->setDisplayName($this->config["displayName"]);
        }

        if (isset($this->config["hidden"])) {
            $this->column->setHidden($this->config["hidden"]);
        }

        if (isset($this->config["tdClass"])) {
            $this->column->setTdClass($this->config["tdClass"]);
        }

        if (isset($this->config["thClass"])) {
            $this->column->setThClass($this->config["thClass"]);
        }

        if (isset($this->config["priority"])) {
            $this->column->setPriority($this->config["priority"]);
        }
    }

    /**
     * Create a String Column
     *
     * @param string $name name of the column
     * @return \ZfMetal\Datagrid\Column\StringColumn
     */
    protected function createStringColumn($name) {
        $this->column = new Column\StringColumn($name);
        $this->baseConfig();
        return $this->column;
    }

    /**
     * Create a Text Column
     *
     * @param string $name name of the column
     * @return \ZfMetal\Datagrid\Column\TextColumn
     */
    protected function createTextColumn($name) {
        $this->column = new Column\TextColumn($name);
        $this->baseConfig();

        if (isset($this->config["length"])) {
            $this->column->setLength($this->config["length"]);
        }
        
          if (isset($this->config["tooltip"])) {
  
            $this->column->setTooltip($this->config["tooltip"]);
        }

        return $this->column;
    }

    /**
     * Create a Link Column
     *
     * @param string $name name of the column
     * @return \ZfMetal\Datagrid\Column\LinkColumn
     */
    protected function createLinkColumn($name) {
        $this->column = new Column\LinkColumn($name);
        $this->baseConfig();

        if (isset($this->config["displayValue"])) {
            $this->column->setDisplayValue($this->config["displayValue"]);
        }
        if (isset($this->config["classA"])) {
            $this->column->setClassA($this->config["classA"]);
        }

        return $this->column;
    }

    /**
     * Create a Relational Column
     *
     * @param string $name name of the column
     * @return \ZfMetal\Datagrid\Column\RelationalColumn
     */
    protected function createRelationalColumn($name) {
        $this->column = new Column\RelationalColumn($name);
        $this->baseConfig();


        if (isset($this->config["orderProperty"])) {
            $this->column->setOrderProperty($this->config["orderProperty"]);
        }

        if (isset($this->config["multiSearchProperty"])) {
            $this->column->setMultiSearchProperty($this->config["multiSearchProperty"]);
        }


        return $this->column;
    }

    /**
     * Create a Boolean Column
     *
     * @param string $name name of the column
     * @return \ZfMetal\Datagrid\Column\BooleanColumn
     */
    protected function createBooleanColumn($name) {
        $this->column = new Column\BooleanColumn($name);
        $this->baseConfig();

        if (isset($this->config["valueWhenTrue"])) {
            $this->column->setValueWhenTrue($this->config["valueWhenTrue"]);
        }
        if (isset($this->config["valueWhenFalse"])) {
            $this->column->setValueWhenFalse($this->config["valueWhenFalse"]);
        }

        return $this->column;
    }

    /**
     * Create a File Column
     *
     * @param string $name name of the column
     * @return \ZfMetal\Datagrid\Column\FileColumn
     */
    protected function createFileColumn($name) {
        $this->column = new Column\FileColumn($name);
        $this->baseConfig();

        if (isset($this->config["webpath"])) {
            $this->column->setWebpath($this->config["webpath"]);
        }
        if (isset($this->config["width"])) {
            $this->column->setWidth($this->config["width"]);
        }
        if (isset($this->config["height"])) {
            $this->column->setHeight($this->config["height"]);
        }

        if (isset($this->config["showFile"])) {
            $this->column->setShowFile($this->config["showFile"]);
        }

        return $this->column;
    }

    /**
     * Create a DateTime Column
     *
     * @param string $name name of the column
     * @return \ZfMetal\Datagrid\Column\DateTiemColumn
     */
    protected function createDateTimeColumn($name) {
        $this->column = new Column\DateTimeColumn($name);
        $this->baseConfig();

        if (isset($this->config["format"])) {
            $this->column->setFormat($this->config["format"]);
        }

        return $this->column;
    }

    /**
     * Create a Extra Column
     *
     * @param string $name name of the column
     * @return \ZfMetal\Datagrid\Column\ExtraColumn
     */
    protected function createExtraColumn($name) {
        $this->column = new Column\ExtraColumn($name);
        $this->baseConfig();
        return $this->column;
    }

    /**
     * Create a Custom Column
     *
     * @param string $name name of the column
     * @return \ZfMetal\Datagrid\Column\CustomColumn
     */
    protected function createCustomColumn($name) {
        $this->column = new Column\CustomColumn($name);
        $this->baseConfig();

        if (isset($this->config["helper"])) {
            $this->column->setValueWhenTrue($this->config["helper"]);
        }
        if (isset($this->config["data"])) {
            $this->column->setValueWhenFalse($this->config["data"]);
        }

        return $this->column;
    }

}
