<?php

namespace ZfMetal\Datagrid\Column;

/**
 * Description of Column
 *
 * @author cincarnato
 */
class DateTimeColumn extends AbstractColumn {

    const type = "datetime";

    /**
     * Format of datetime
     * 
     * @var string
     */
    protected $format = "Y-m-d H:i:s";

    function getFormat() {
        return $this->format;
    }

    function setFormat($format) {
        $this->format = $format;
    }

}

?>
