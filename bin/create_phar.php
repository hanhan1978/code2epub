#!/usr/bin/env php
<?php 


$phar_name='code2epub';
define('ROOT', dirname(__FILE__)."/../");

$phar = new Phar("$phar_name.phar", 0);

$phar->addFile("code2epub", "code2epub");

addFile($phar, "src");
addFile($phar, "vendor");
addFile($phar, "res");


//adding shebang to create executable phar
$phar->startBuffering();
$defaultStub = $phar->createDefaultStub("code2epub");
$stub = "#!/usr/bin/env php \n".$defaultStub;
$phar->setStub($stub);
$phar->stopBuffering();




function addFile($phar, $dir){
    $filelist = getFilelist(ROOT ,"/$dir");
    foreach($filelist as $file){
        $phar->addFile("../".$file, $file);
    }
}

function getFilelist($root, $subpath){
    $filelist=array();
    foreach (new DirectoryIterator($root.$subpath) as $fileInfo) {
        if($fileInfo->isDot()) continue;
        if($fileInfo->isDir() && $fileInfo->getFilename() !== 'phpunit'){
            $filelist = array_merge($filelist, getFilelist($root, $subpath."/".$fileInfo->getFilename()));
        }else{
            $filelist[] =  $subpath."/".$fileInfo->getFilename();
        }
    }
    return $filelist;
}
