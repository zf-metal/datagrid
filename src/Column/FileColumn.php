<?php

namespace ZfMetal\Datagrid\Column;

/**
 * Description of Column
 *
 * @author cincarnato
 */
class FileColumn extends AbstractColumn {

    const type = "file";
    
    protected $webpath;
    protected $width;
    protected $height;
    
    protected $showFile = false;
    
    function getWebpath() {
        return $this->webpath;
    }

    function getWidth() {
        return $this->width;
    }

    function getHeight() {
        return $this->height;
    }

    function setWebpath($webpath) {
        $this->webpath = $webpath;
    }

    function setWidth($width) {
        $this->width = $width;
    }

    function setHeight($height) {
        $this->height = $height;
    }

    function getShowFile() {
        return $this->showFile;
    }

    function setShowFile($showFile) {
        $this->showFile = $showFile;
    }



}

?>
