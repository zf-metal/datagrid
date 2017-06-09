<?php

namespace ZfMetal\Datagrid\Exception;

class SourceException extends \RuntimeException implements
    ExceptionInterface
{
    
     /**
     * @var string
     */
    protected $message = 'No source set';
}
