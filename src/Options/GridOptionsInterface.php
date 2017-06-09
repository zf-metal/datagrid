<?php

namespace ZfMetal\Datagrid\Options;

/**
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
interface GridOptionsInterface {

    function getTemplateDefault();

    function setTemplateDefault($template);

    function getRecordsPerPage();

    function setRecordsPerPage($recordPerPage);
}
