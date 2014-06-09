<?php
spl_autoload_register("loadLibrary");


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
$epubContents = EpubCollector::assemble();

//EPUB Contents Publish (without zip archive if specified)
if($filename = EpubMaker::publish($epubContents)){
    print("epub creation completed => $filename\n");
    exit(0);
}
print("epub creation failed");
exit(1);



/*
 * autoload function for phpepub 
 */
function loadLibrary($className) {
    $namespaces = array('entity', 'helper', 'epub', 'epub/xhtml');
    foreach($namespaces as $namespace){
        $file=sprintf("../src/%s/".$className . ".php", $namespace);
        if (is_readable($file)) require $file;
    }
}

