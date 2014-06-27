<?php


class SmartyTypePhp extends SmartyTypeBase{

    private $_template = 'php.tpl';

    public function parseContents($contents){
        return parent::parseContents($contents);
    }

}
