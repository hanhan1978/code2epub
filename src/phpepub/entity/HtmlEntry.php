<?php

class HtmlEntry extends Base{

    public function getChildren(){
        return $this->_children;
    }
    public function add($file){
        $this->_children[] = $file;
    }
    public function toHtml(){

    }
}
