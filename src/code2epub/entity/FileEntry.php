<?php

class FileEntry extends AbstractEntry {

    private $_content = null;
    private $_template = false;

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

    /**
     *  if FileEntry is templatable.
     *  it means the file has a corresponding twig template. 
     **/
    public function templatable(){
        $this->_template = true; 
        return $this;
    }

    public function hasTemplate(){
        return $this->_template;
    }
}
