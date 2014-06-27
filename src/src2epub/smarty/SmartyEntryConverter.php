<?php

public class SmartyEntryConverter {


    public function __construct(){
        $this->setSmarty();
    }

    private function setSmarty(){
        $this->_smarty = new Smarty();
        $this->_smarty->template_dir = SMARTY_TEMPLATE_ROOT."templates";
        $this->_smarty->compile_dir  = SMARTY_TEMPLATE_ROOT."templates_c";
        $this->_smarty->config_dir   = SMARTY_TEMPLATE_ROOT."configs";
        $this->_smarty->cache_dir    = SMARTY_TEMPLATE_ROOT."cache";
    }


    public function publish($entryObj){

    }

}
