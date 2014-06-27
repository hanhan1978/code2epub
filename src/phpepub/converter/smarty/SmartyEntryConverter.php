<?php

class SmartyEntryConverter extends EntryConverter {


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


    /*
     * Convert EntryObject into a smarty defined text file
     */
    public function convert($entryObj){
        return "";

    }



}
