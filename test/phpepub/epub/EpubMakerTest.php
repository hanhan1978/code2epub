
<?php

require_once dirname(__FILE__)."/../../testHelper.php";

class EpubMakerTest extends PHPUnit_Framework_TestCase{

    private $nestFileObj;
    private $singleFileObj;

    function setup(){
        $this->nestFileObj   = CrawlerFactory::createCrawler(TEST_ROOT."/res/sampleWithNestedContents");
        $this->singleFileObj = CrawlerFactory::createCrawler(TEST_ROOT."/res/sampleOnlyOneFile/fuga.txt");
    }

    public function testAssemble(){
        $sample1 = $this->nestFileObj->crawl();
        $epub1 = EpubMaker::assemble($sample1);
        $this->assertEquals("sampleWithNestedContents", $epub1->getName());

    }

}

