<?php


class EpubMaker{


    public static function assemble($contents){

        $epub = new DirectoryEntry($this->getTitle($contents)); 



        return $epub;

    }

    private static getTitle(){

    }

}
