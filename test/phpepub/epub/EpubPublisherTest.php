<?php

require_once dirname(__FILE__)."/../../testHelper.php";

class EpubPublisherTest extends PHPUnit_Framework_TestCase{

    private $nestFileObj;
    private $singleFileObj;

    function setup(){
        $this->nestFileObj   = CrawlerFactory::createCrawler(TEST_ROOT."/res/sampleWithNestedContents");
        $this->singleFileObj = CrawlerFactory::createCrawler(TEST_ROOT."/res/sampleOnlyOneFile/fuga.txt");
    }

    public function testMaterialize(){
        $sample1 = $this->nestFileObj->crawl();
        $makerObj1 = new EpubMaker($sample1);
        $book1 = $makerObj1->assemble();

        $obj = new EpubPublisher($book1);
        $obj->materialize();
        $book1->dump();
        
    }
}

