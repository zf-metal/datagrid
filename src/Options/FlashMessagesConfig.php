<?php

namespace ZfMetal\Datagrid\Options;

use Zend\Stdlib\AbstractOptions;

class FlashMessagesConfig extends AbstractOptions {

    /**
     * @var boolean
     */
    protected $enable = true;
    
    
    /**
     * @var string
     */
    protected $deleteOk;

    /**
     * @var string
     */
    protected $deleteFail;

    /**
     * @var string
     */
    protected $addOk;

    /**
     * @var string
     */
    protected $addFail;
    
     /**
     * @var string
     */
    protected $editOk;

    /**
     * @var string
     */
    protected $editFail;
    
    function getDeleteOk() {
        return $this->deleteOk;
    }

    function getDeleteFail() {
        return $this->deleteFail;
    }

    function getAddOk() {
        return $this->addOk;
    }

    function getAddFail() {
        return $this->addFail;
    }

    function getEditOk() {
        return $this->editOk;
    }

    function getEditFail() {
        return $this->editFail;
    }

    function setDeleteOk($deleteOk) {
        $this->deleteOk = $deleteOk;
        return $this;
    }

    function setDeleteFail($deleteFail) {
        $this->deleteFail = $deleteFail;
        return $this;
    }

    function setAddOk($addOk) {
        $this->addOk = $addOk;
        return $this;
    }

    function setAddFail($addFail) {
        $this->addFail = $addFail;
        return $this;
    }

    function setEditOk($editOk) {
        $this->editOk = $editOk;
        return $this;
    }

    function setEditFail($editFail) {
        $this->editFail = $editFail;
        return $this;
    }

    function getEnable() {
        return $this->enable;
    }

    function setEnable($enable) {
        $this->enable = $enable;
        return $this;
    }





}
