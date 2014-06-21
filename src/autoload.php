<?php

spl_autoload_register("loadLibrary");


define("DS", "/");
define("ROOT", dirname(__FILE__)."/../");
define("SMARTY_ROOT", ROOT."res/smarty");



/*
 * Autoloader for phpepub
 * @param $className  Name of class to be loaded
 */
function loadLibrary($className) {
    $it = new RecursiveDirectoryIterator(dirname(__FILE__));
    $it = new RecursiveIteratorIterator($it);
 
    foreach ($it as $fileinfo) { 
        if ($fileinfo->isFile() && $className.".php" === basename($fileinfo->getPathname()))
            require_once $fileinfo->getPathname();
    }
}
