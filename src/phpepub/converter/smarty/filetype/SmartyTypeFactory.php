<?php


class SmartyTypeFactory {

    public static function createSmartyType($filename){

        if(preg_match("/\.php$/", $filename))
            return new SmartyTypePhp();

        return new SmartyTypeBase();
    }

}

