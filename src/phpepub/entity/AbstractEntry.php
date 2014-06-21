<?php

abstract class AbstractEntry {
    private $_name;
    protected $_smarty;
    protected $_children = array();

    public function __construct($name){
        $this->_name = $name;
        $this->setSmarty();
    }

    abstract public function add($file);
    abstract public function getChildren();
    abstract public function toHtml();

    public function getName(){
        return $this->_name;
    }

    private function setSmarty(){
        $this->_smarty = new Smarty();
        $this->_smarty->template_dir = SMARTY_TEMPLATE_ROOT."templates";
        $this->_smarty->compile_dir  = SMARTY_TEMPLATE_ROOT."templates_c";
        $this->_smarty->config_dir   = SMARTY_TEMPLATE_ROOT."configs";
        $this->_smarty->cache_dir    = SMARTY_TEMPLATE_ROOT."cache";
    }


    



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
