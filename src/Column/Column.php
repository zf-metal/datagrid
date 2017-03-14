<?php

namespace ZfMetal\Datagrid\Column;

/**
 * Description of Column
 *
 * @author cincarnato
 */
class Column extends AbstractColumn {

    /**
     * Class to apply in td on column
     * 
     * @var string
     */
    protected $tdClass;

    /**
     * Value when the value of the column is true
     * 
     * @var string
     */
    protected $valueWhenTrue = "true";

    /**
     * Value when the value of the column is false
     * 
     * @var string
     */
    protected $valueWhenFalse = "false";
    
    
    protected $tooltip;
    protected $htmlBegin;
    protected $htmlEnd;
    protected $replaceTrueBy;
    protected $filePath;
    protected $fileWidth = "100%";
    protected $fileHeight = "100%";
    protected $replaceFalseBy;
    protected $formatDatetime;
    protected $length = 15;
    protected $helper;
    protected $customData = array();
    protected $filterActive = true;
    protected $filter;

    public function getTooltip() {
        return $this->tooltip;
    }

    public function setTooltip($tooltip) {
        $this->tooltip = $tooltip;
    }

    public function getHtmlBegin() {
        return $this->htmlBegin;
    }

    public function setHtmlBegin($htmlBegin) {
        $this->htmlBegin = $htmlBegin;
    }

    public function getHtmlEnd() {
        return $this->htmlEnd;
    }

    public function setHtmlEnd($htmlEnd) {
        $this->htmlEnd = $htmlEnd;
    }

    public function getReplaceTrueBy() {
        return $this->replaceTrueBy;
    }

    public function setReplaceTrueBy($replaceTrueBy) {
        $this->replaceTrueBy = $replaceTrueBy;
    }

    public function getReplaceFalseBy() {
        return $this->replaceFalseBy;
    }

    public function setReplaceFalseBy($replaceFalseBy) {
        $this->replaceFalseBy = $replaceFalseBy;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getFormatDatetime() {
        return $this->formatDatetime;
    }

    public function setFormatDatetime($formatDatetime) {
        $this->formatDatetime = $formatDatetime;
    }

    public function getLength() {
        return $this->length;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    function getFilePath() {
        return $this->filePath;
    }

    function setFilePath($filePath) {
        $this->filePath = $filePath;
    }

    function getFileWidth() {
        return $this->fileWidth;
    }

    function getFileHeight() {
        return $this->fileHeight;
    }

    function setFileWidth($fileWidth) {
        $this->fileWidth = $fileWidth;
    }

    function setFileHeight($fileHeight) {
        $this->fileHeight = $fileHeight;
    }

    function getHelper() {
        return $this->helper;
    }

    function setHelper($helper) {
        $this->helper = $helper;
    }

    function getCustomData() {
        return $this->customData;
    }

    function setCustomData($customData) {
        $this->customData = $customData;
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

}

?>
