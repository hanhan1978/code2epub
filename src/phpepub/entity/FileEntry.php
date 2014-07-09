<?php

class FileEntry extends AbstractEntry {

    private $_content = null;

    public function getContent(){
        return $this->_content;
    }
    public function setContent($content){
        $this->_content = $content;
    }

    public function add($file){
        return false;
    }

    public function getChildren(){
        return false;
    }
}
