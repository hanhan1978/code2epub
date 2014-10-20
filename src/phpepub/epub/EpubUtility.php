<?php

class EpubUtility{


    public static function makeXhtml($contents, $container = null){
        $children = $contents->getChildren();
        if($children === false){
            $contents->setName(self::createFileName($contents->getPath()));
            $container->add($contents);
        }else{
            foreach($children as $child){
                self::makeXhtml($child, $container);
            }
        }
        return $container;
    }

    public static function createfilename($str){
        return "phpepub_".self::replaceSlash($str).".xhtml";
    }

    private static function replaceSlash($str){
        return preg_replace('|[/\.]|', '_', $str);
    }

}
