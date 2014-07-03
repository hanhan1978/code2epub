
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
        $book1 = EpubMaker::assemble($sample1);
        $this->assertEquals("sampleWithNestedContents", $book1->getName());

        $this->assertEquals("mimetype", $book1->getChildren()[0]->getName());
        $this->assertEquals("META-INF", $book1->getChildren()[1]->getName());
        $this->assertEquals("EPUB",     $book1->getChildren()[2]->getName());

        $epub1 = $book1->getChildren()[2];
        $this->assertEquals("package.opf", $epub1->getChildren()[0]->getName());
        $this->assertEquals("xhtml", $epub1->getChildren()[1]->getName());


    }

}

