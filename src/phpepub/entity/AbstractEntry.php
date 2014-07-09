<?php

abstract class AbstractEntry {
    private $_path;
    private $_parentName;
    protected $_children = array();
    

    public function __construct($path, $parentName = null){
        $this->_path = $path;
        $this->_parentName = $parentName;
    }

    public function getPath(){
        return $this->_path;
    }

    public function getName(){
        return basename($this->_path);
    }

    public function hasParent(){
        return !is_null($this->_parentName);
    }

    public function getParentName(){
        return $this->_parentName;
    }

    abstract public function add($file);
    abstract public function getChildren();


    




    public function dump($indent=0){
        if($indent==0) $this->padPrint($indent, $this->getName(), $this->getParentName());
        foreach($this->_children as $child){
            $this->padPrint($indent+1, $child->getName(), $child->getParentName());
            if($child->getChildren() !== false ) $child->dump($indent+1);
        }
    }
    private function padPrint($indent, $str, $hasParent){
        echo(str_pad("", $indent*3).basename($str)."[$hasParent]\n");
    }
}
