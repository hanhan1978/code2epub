<?php


abstract class Crawler{

    protected $resourceString;

    public function __construct($resourceString){
        $this->resourceString = $resourceString;
    }
    /*
     *
     */
    abstract public function crawl();
}
