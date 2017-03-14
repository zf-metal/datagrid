<?php

namespace ZfMetal\Datagrid\Column;

/**
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
interface ColumnInterface {

    public function getName();

    public function setName($name);

    public function getType();

    public function getHidden();

    public function setHidden($hidden);

    public function getDisplayName();

    public function setDisplayName($name);

    public function getTdClass();

    public function getHtmlBegin();

    public function getHtmlEnd();

    //TODO...
}
