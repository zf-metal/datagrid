<?php

namespace ZfMetal\Datagrid\Column;

/**
 * Description of Column
 *
 * @author cincarnato
 */
class RelationalColumn extends AbstractColumn {

    const type = "relational";

    protected $orderProperty = 'id';  
    protected $relationalId;
    protected $relationalEntity;
    protected $multiSearchProperty;
    protected $field = null;
    protected $oneToMany = false;

    /**
     * Max lenght text
     *
     * @var integer
     */
    protected $length = null;

    /**
     * Enable Tooltip
     *
     * @var boolean
     */
    protected $tooltip = false;
    
    function getRelationalId() {
        return $this->relationalId;
    }

    function getRelationalEntity() {
        return $this->relationalEntity;
    }

    function setRelationalId($relationalId) {
        $this->relationalId = $relationalId;
    }

    function setRelationalEntity($relationalEntity) {
        $this->relationalEntity = $relationalEntity;
    }


    function getOrderProperty() {
        return $this->orderProperty;
    }

    function setOrderProperty($orderProperty) {
        $this->orderProperty = $orderProperty;
    }

    function getMultiSearchProperty() {
        return $this->multiSearchProperty;
    }

    function setMultiSearchProperty($multiSearchProperty) {
        $this->multiSearchProperty = $multiSearchProperty;
        return $this;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return bool
     */
    function getTooltip() {
        return $this->tooltip;
    }

    /**
     * @param $tooltip
     * @return $this
     */
    function setTooltip($tooltip) {
        $this->tooltip = $tooltip;
        return $this;
    }

    /**
     * @return null
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param null $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return bool
     */
    public function getOneToMany()
    {
        return $this->oneToMany;
    }

    /**
     * @param bool $oneToMany
     */
    public function setOneToMany($oneToMany)
    {
        $this->oneToMany = $oneToMany;
    }




}

?>
