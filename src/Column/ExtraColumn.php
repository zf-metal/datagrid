<?php

namespace ZfMetal\Datagrid\Column;

/**
 * Description of Column
 *
 * @author cincarnato
 */
class ExtraColumn extends AbstractColumn {
    
     const type = "extra";
    const expRegData = "/\{\{\w*\}\}/";
    const expRegReplace = "/\{|\}/";
    protected $side;
    protected $originalValue;
    protected $filterActive = true;
    protected $filter;

    function __construct($name) {
        $this->name = $name;
        $this->displayName = $name;
    }

    public function processData($row) {
        if (preg_match_all(self::expRegData, $this->getOriginalValue(), $matches)) {
            $result = $this->getOriginalValue();
            foreach ($matches[0] as $match) {
                $fieldName = preg_replace(self::expRegReplace, "", $match);
                $replace = $row[$fieldName];
                $result = str_replace($match, $replace, $result);
            }
            return $result;
        }else{
            return $this->getOriginalValue();
        }
    }

    public function __toString() {
        return $this->displayName;
    }

    public function getSide() {
        return $this->side;
    }

    public function setSide($side) {
        if ($side == "left" || $side == "right") {
            $this->side = $side;
        } else {
            throw new \Exception("The side must be 'left' or 'right'");
        }
    }

    public function getFilterActive() {
        return $this->filterActive;
    }

    public function setFilterActive($filterActive) {
        $this->filterActive = $filterActive;
    }

    public function getFilter() {
        return $this->filter;
    }

    public function setFilter($filter) {
        $this->filter = $filter;
    }

    public function getOriginalValue() {
        return $this->originalValue;
    }

    public function setOriginalValue($originalValue) {
        $this->originalValue = $originalValue;
    }

}

?>
