<?php

class FileEntry extends AbstractEntry {
    public function add($file){
        return false;
    }

    public function getChildren(){
        return false;
    }

    private function getTemplate(){
        $templateName = strtolower(preg_replace('/Entry$/', '', get_class($this)));
        return 'file'.DS.$templateName.".tpl";
    }

    public function toHtml(){
        $this->_smarty->assign('contents', file_get_contents($this->getName()));
        return $this->_smarty->fetch($this->getTemplate());
    }
}
