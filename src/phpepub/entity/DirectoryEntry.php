<?php

class DirectoryEntry extends Base{

    public function getChildren(){
        return $this->_children;
    }
    public function add($file){
        $this->_children[] = $file;
    }

}
