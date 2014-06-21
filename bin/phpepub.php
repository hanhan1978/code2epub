<?php
require_once("../src/autoload.php");


//command line argument compile  && argument validation 
$argObj = new Argument($argv);
if(!$argObj->validate() || $argObj->needHelp()){
    $argObj->showMessage();
    exit(1);
    /** memo
    argument
       --no-archive    => do not archive epub
       -v              => show verbose log (notice)
       -vv             => show verbose log (info)
       -vvv            => show verbose log (debug)
       default => source directory or filename to view

       TODO:Think about use of Symfony console library that sounds good
    **/
}

//EPUB Contents Collection
$epubContents = CrawlerFactory::createCrawler()->crawl();

//EPUB Contents Publish (without zip archive if specified)
//
$contents = EpubMaker::assemble($eputContents);

if(true)  //depends on command line argument
    $contents->archive();

print("epub creation completed => " . $contents->getFilename() . "\n");
exit(0);



