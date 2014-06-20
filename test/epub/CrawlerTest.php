<?php
require_once dirname(__FILE__)."/../testHelper.php";

class CrawlerTest extends PHPUnit_Framework_TestCase{

    public function testAssemble(){
        $sample1 = Crawler::crawl(TEST_ROOT."/res/sampleWithNestedContents");
        $this->assertEquals($sample1->getChildren()[2]->getChildren()[2]->getChildren()[1]->getName(), 'fuga4-2.txt');
        $this->assertEquals(count($sample1->getChildren()), 4);
        $sample2 = Crawler::crawl(TEST_ROOT."/res/sampleOnlyOneFile/fuga.txt");
        $this->assertEquals(count($sample2), 1);

    }
}
