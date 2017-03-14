<?php

namespace ZfMetal\Datagrid\Column;

/**
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
interface InterfaceColumn {

    public function getName();

    public function setName();

    public function getType();

    public function getHidden();

    public function setHidden();

    public function getDisplayName();

    public function setDisplayName();
    //TODO...
}
