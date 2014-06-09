<?php

class DirectoryEntry extends Base{

    public function getChild(){
        return $this->_childs;
    }
    public function add($file){
        $this->_childs[] = $file;
    }

}
