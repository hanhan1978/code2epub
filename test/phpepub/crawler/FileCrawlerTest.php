<?php
require_once dirname(__FILE__)."/../../testHelper.php";

class FileCrawlerTest extends PHPUnit_Framework_TestCase{

    private $nestFileObj;
    private $singleFileObj;

    function setup(){
        $this->nestFileObj   = CrawlerFactory::createCrawler(TEST_ROOT."/res/sampleWithNestedContents");
        $this->singleFileObj = CrawlerFactory::createCrawler(TEST_ROOT."/res/sampleOnlyOneFile/fuga.txt");
    }


    function testCrawl(){
        $sample1 = $this->nestFileObj->crawl();
        $sample1->dump();
        $this->assertEquals(basename($sample1->getChildren()[2]->getChildren()[2]->getChildren()[1]->getPath()), 'fuga4-2.txt');
        $this->assertEquals(count($sample1->getChildren()), 4);
        $sample2 = $this->singleFileObj->crawl(); 
        $sample2->dump();
        $this->assertEquals(count($sample2), 1);
    }

}
