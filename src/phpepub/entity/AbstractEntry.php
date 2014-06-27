<?php

abstract class AbstractEntry {
    private $_name;
    private $_smartyParams; 
    protected $_children = array();

    public function __construct($name){
        $this->_name = $name;
    }

    public function getName(){
        return $this->_name;
    }

    public function getSmartyParams(){
        return $this->_smartyParams;
    }

    abstract public function add($file);
    abstract public function getChildren();
    abstract public function setSmartyParams();




    



    /**
    public function dump($indent=0){
        if($indent==0) $this->padPrint($indent, $this->_name);
        foreach($this->_children as $child){
            $this->padPrint($indent+1, $child->_name);
            if(is_dir($child->_name) && !empty($child->_children)) $child->dump($indent+1);
        }
    }
    private function padPrint($indent, $str){
        echo(str_pad("", $indent*3).basename($str)."\n");
    }
    **/
}
