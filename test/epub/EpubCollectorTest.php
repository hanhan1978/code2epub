<?php
require_once "testHelper.php";

class EpubCollectorTest extends PHPUnit_Framework_TestCase{

    public function testUnko(){
        $baka = EpubCollector::assemble("./res/hoge1");
        $baka->dump();
    }
}
