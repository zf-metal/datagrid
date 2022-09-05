<?php

namespace ZfMetal\Datagrid;

/**
 * Description of Filter
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class Filter {

    const LIKE = '~ *%s*';
    const LIKE_LEFT = '~ *%s';
    const LIKE_RIGHT = '~ %s*';
    const NOT_LIKE = '!~ *%s*';
    const NOT_LIKE_LEFT = '!~ *%s';
    const NOT_LIKE_RIGHT = '!~ %s*';
    const EQUAL = '= %s';
    const NOT_EQUAL = '!= %s';
    const GREATER_EQUAL = '>= %s';
    const GREATER = '> %s';
    const LESS_EQUAL = '<= %s';
    const LESS = '< %s';
    const IN = '=(%s)';
    const NOT_IN = '!=(%s)';
    const BETWEEN = '%s <> %s';

    /**
     * column
     * 
     * @var \ZfMetal\Datagrid\Column\ColumnInterface
     */
    protected $column;

    /**
     * original value from input
     * 
     * @var string
     */
    protected $inputFilterValue;

    /**
     * Operator for filter
     * 
     * @var string
     */
    protected $operator = self::LIKE;

    /**
     * value to filter
     * 
     * @var string|array
     */
    protected $value;
    
    
     /**
     * define if a relational column
     * 
     * @var boolean
     */
    protected $relational = false;

    function __construct(\ZfMetal\Datagrid\Column\ColumnInterface $column, $inputFilterValue) {
        $this->column = $column;
        $this->inputFilterValue = trim((string) $inputFilterValue);
        $this->prepare();
    }

    /**
     * Prepare FILTER
     *
     * Partly idea taken from ZfDatagrid
     * 
     * @param type $var description
     * @return type
     */
    private function prepare() {

        if ($this->getColumn() instanceof \ZfMetal\Datagrid\Column\RelationalColumn) {
            $operator = self::EQUAL;
            $value = $this->inputFilterValue;
            $this->setRelational(true);
        } else if (substr($this->inputFilterValue, 0, 2) == '=(') {
            $operator = self::IN;
            $value = substr($this->inputFilterValue, 2);
            if (substr($value, -1) == ')') {
                $value = substr($value, 0, -1);
            }
        } elseif (substr($this->inputFilterValue, 0, 3) == '!=(') {
            $operator = self::NOT_IN;
            $value = substr($this->inputFilterValue, 3);
            if (substr($value, -1) == ')') {
                $value = substr($value, 0, -1);
            }
        } elseif (substr($this->inputFilterValue, 0, 2) == '!=' || substr($this->inputFilterValue, 0, 2) == '<>') {
            $operator = self::NOT_EQUAL;
            $value = substr($this->inputFilterValue, 2);
        } elseif (substr($this->inputFilterValue, 0, 2) == '!~' || substr($this->inputFilterValue, 0, 1) == '!') {
            // NOT LIKE or NOT EQUAL
            if (substr($this->inputFilterValue, 0, 2) == '!~') {
                $value = trim(substr($this->inputFilterValue, 2));
            } else {
                $value = trim(substr($this->inputFilterValue, 1));
            }
            if (substr($this->inputFilterValue, 0, 2) == '!~' || (substr($value, 0, 1) == '%' || substr($value, -1) == '%' || substr($value, 0, 1) == '*' || substr($value, -1) == '*')) {
                // NOT LIKE
                if ((substr($value, 0, 1) == '*' && substr($value, -1) == '*') || (substr($value, 0, 1) == '%' && substr($value, -1) == '%')) {
                    $operator = self::NOT_LIKE;
                    $value = substr($value, 1);
                    $value = substr($value, 0, -1);
                } elseif (substr($value, 0, 1) == '*' || substr($value, 0, 1) == '%') {
                    $operator = self::NOT_LIKE_LEFT;
                    $value = substr($value, 1);
                } elseif (substr($value, -1) == '*' || substr($value, -1) == '%') {
                    $operator = self::NOT_LIKE_RIGHT;
                    $value = substr($value, 0, -1);
                } else {
                    $operator = self::NOT_LIKE;
                }
            } else {
                // NOT EQUAL
                $operator = self::NOT_EQUAL;
            }
        } elseif (substr($this->inputFilterValue, 0, 1) == '~' || substr($this->inputFilterValue, 0, 1) == '%' || substr($this->inputFilterValue, -1) == '%' || substr($this->inputFilterValue, 0, 1) == '*' || substr($this->inputFilterValue, -1) == '*') {
            // LIKE
            $value = $this->inputFilterValue;
            if (substr($this->inputFilterValue, 0, 1) == '~') {
                $value = substr($this->inputFilterValue, 1);
            }
            $value = trim($value);
            if ((substr($value, 0, 1) == '*' && substr($value, -1) == '*') || (substr($value, 0, 1) == '%' && substr($value, -1) == '%')) {
                $operator = self::LIKE;
                $value = substr($value, 1);
                $value = substr($value, 0, -1);
            } elseif (substr($value, 0, 1) == '*' || substr($value, 0, 1) == '%') {
                $operator = self::LIKE_LEFT;
                $value = substr($value, 1);
            } elseif (substr($value, -1) == '*' || substr($value, -1) == '%') {
                $operator = self::LIKE_RIGHT;
                $value = substr($value, 0, -1);
            } else {
                $operator = self::LIKE;
            }
        } elseif (substr($this->inputFilterValue, 0, 2) == '==') {
            $operator = self::EQUAL;
            $value = substr($this->inputFilterValue, 2);
        } elseif (substr($this->inputFilterValue, 0, 1) == '=') {
            $operator = self::EQUAL;
            $value = substr($this->inputFilterValue, 1);
        } elseif (substr($this->inputFilterValue, 0, 2) == '>=') {
            $operator = self::GREATER_EQUAL;
            $value = substr($this->inputFilterValue, 2);
        } elseif (substr($this->inputFilterValue, 0, 1) == '>') {
            $operator = self::GREATER;
            $value = substr($this->inputFilterValue, 1);
        } elseif (substr($this->inputFilterValue, 0, 2) == '<=') {
            $operator = self::LESS_EQUAL;
            $value = substr($this->inputFilterValue, 2);
        } elseif (substr($this->inputFilterValue, 0, 1) == '<') {
            $operator = self::LESS;
            $value = substr($this->inputFilterValue, 1);
        } elseif (strpos($this->inputFilterValue, '<>') !== false) {
            $operator = self::BETWEEN;
            $value = explode('<>', $this->inputFilterValue);
        } else {
            $value = $this->inputFilterValue;
            $operator = self::LIKE;
        }

        if (isset($operator)) {
            $this->operator = $operator;
        }

        if (false === $value) {
            $value = '';
        }
        $this->value = $value;
    }

    function getColumn() {
        return $this->column;
    }

    function getInputFilterValue() {
        return $this->inputFilterValue;
    }

    function getOperator() {
        return $this->operator;
    }

    function getValue() {
        return $this->value;
    }

    function getRelational() {
        return $this->relational;
    }

    function setRelational($relational) {
        $this->relational = $relational;
        return $this;
    }


    


}
