<?php
/**
 * Created by IntelliJ IDEA.
 * User: afurgeri
 * Date: 10/05/19
 * Time: 13:05
 */

namespace ZfMetal\Datagrid\Column;


class ExportMethodColumn extends AbstractColumn
{
    const type = "exportMethod";

    private $method;

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }


}