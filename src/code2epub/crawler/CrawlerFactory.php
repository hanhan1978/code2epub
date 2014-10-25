<?php



class CrawlerFactory {


    public static function createCrawler($resourceString){
        if(self::isUrl($resourceString)){
            return new WebCrawler($resourceString);
        }
        return new FileCrawler($resourceString);
    }


    private static function isUrl($str){
        return preg_match("|^https?://.+$|u", $str);
    }

}
