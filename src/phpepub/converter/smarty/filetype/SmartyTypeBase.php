<?php


class SmartyTypeBase {

    private $_template = 'file.tpl';

    public function getTemplate(){
        return $this->_template;
    }

    public function parseContents($contents){
        return array('contents' => $contents);
    }

}
