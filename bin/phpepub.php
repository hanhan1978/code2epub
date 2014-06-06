<?php
spl_autoload_register("loadLibrary");

//check command line argument
if(!isset($argv[1]) || !is_readable($argv[1])){
    showUsage();
}

//read sourcecode hierarchy 
$hierarchy = EntityHelper::readHierarchy($argv[1]);

//EPUBコンテナ呼び出し。EPUB形式でのファイルを出力
EpubContainer::publish($entities);

//zip archive
ArchiveHelper::publishEpub($epubdir);

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

function showUsage(){
    echo("usage");
    exit(1);
}
