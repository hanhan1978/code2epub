<?php


spl_autoload_register("__autoload");

//check command line argument
if(!isset($argv[1]) || !is_readable($argv[1])){
    showUsage();
}

//entityを読み込み
$entities = EntityHelper::readEntities($argv[1]);


//EPUBコンテナ呼び出し。EPUB形式でのファイルを出力
EpubContainer::publish();


//zipでアーカイブ化
ArchiveHelper::publishEpub();

function __autoload($className) {
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
