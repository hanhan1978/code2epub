<?php

class EpubUtility{

    public static function contents2array($contents){
        $contents_dup = $contents;
        return self::contents2array_imple($contents_dup); 
    }
    private static function contents2array_imple($contents){
        $ret_array = array();
        $children = $contents->getChildren();
        if($children === false){
            //$contents->setName(self::createFileName($contents->getPath()));
            $ret_array[] = $contents; 
        }else{
            foreach($children as $child){
                $ret_array = array_merge($ret_array, self::contents2array_imple($child));
            }
        }
        return $ret_array;
    }


    public static function createfilename($str){
        return "phpepub_".self::replaceSlash($str).".xhtml";
    }

    public static function replaceSlash($str){
        return preg_replace('|[/\.]|', '_', $str);
    }

    public static function createId($str){
        return self::replaceSlash($str);
    }
}
