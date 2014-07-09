
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
        $sample1->dump();
        $epubContents1 = EpubMaker::assemble($sample1);
        $book1 = $epubContents1->getBook();
        $this->assertEquals("sampleWithNestedContents", $book1->getName());

        $this->assertEquals("mimetype", $book1->getChildren()[0]->getName());
        $this->assertEquals("META-INF", $book1->getChildren()[1]->getName());
        $this->assertEquals("EPUB",     $book1->getChildren()[2]->getName());

        $epub1 = $book1->getChildren()[2];
        $this->assertEquals("package.opf", $epub1->getChildren()[0]->getName());
        $this->assertEquals("xhtml", $epub1->getChildren()[1]->getName());

        $xhtml1 = $epub1->getChildren()[1];
        $this->assertEquals("fuga2-1.txt", $xhtml1->getChildren()[0]->getName());
        $this->assertEquals("fuga2-2.php", $xhtml1->getChildren()[1]->getName());
        $this->assertEquals("fuga3-1.txt", $xhtml1->getChildren()[2]->getName());
        $this->assertEquals("fuga3-2.txt", $xhtml1->getChildren()[3]->getName());
        $this->assertEquals("fuga4-1.txt", $xhtml1->getChildren()[4]->getName());
        $this->assertEquals("fuga4-2.txt", $xhtml1->getChildren()[5]->getName());

//        $book1->dump();

    }

}

