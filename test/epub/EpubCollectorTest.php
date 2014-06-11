<?php
require_once "testHelper.php";

class EpubCollectorTest extends PHPUnit_Framework_TestCase{

    public function testAssemble(){
        $sample1 = EpubCollector::assemble("./res/sampleWithNestedContents");
        $this->assertEquals($sample1->getChildren()[2]->getChildren()[2]->getChildren()[1]->getName(), 'fuga4-2.txt');
        $this->assertEquals(count($sample1->getChildren()), 4);
        $sample2 = EpubCollector::assemble("./res/sampleOnlyOneFile/fuga.txt");
        $this->assertEquals(count($sample2), 1);

    }
}
