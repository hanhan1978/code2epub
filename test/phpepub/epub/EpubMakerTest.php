
<?php

require_once dirname(__FILE__)."/../../testHelper.php";

class EpubMakerTest extends PHPUnit_Framework_TestCase{

    private $nestFileObj;
    private $singleFileObj;
    private $_nestFilePath;
    private $_singleFilePath;
    private $_epub;

    function setup(){
        $this->_nestFilePath = TEST_ROOT."/res/sampleWithNestedContents".DS;
        $this->nestFileObj   = CrawlerFactory::createCrawler($this->_nestFilePath);
        $this->_singleFilePath = TEST_ROOT."/res/sampleOnlyOneFile/fuga.txt";
        $this->singleFileObj = CrawlerFactory::createCrawler($this->_singleFilePath);
        $this->_epub = new EpubContents();
    }

    public function testAssemble(){
        $sample1 = $this->nestFileObj->crawl();
        $makerObj1 = new EpubMaker($sample1);
        $book1 = $makerObj1->assemble();
        $this->assertEquals("sampleWithNestedContents", $book1->getName());

        $this->assertEquals("mimetype", $book1->getChildren()[0]->getName());
        $this->assertEquals("META-INF", $book1->getChildren()[1]->getName());
        $this->assertEquals("EPUB",     $book1->getChildren()[2]->getName());

        $epub1 = $book1->getChildren()[2];
        $this->assertEquals("package.opf", $epub1->getChildren()[0]->getName());
        $this->assertEquals("xhtml", $epub1->getChildren()[1]->getName());
        $this->assertEquals("css", $epub1->getChildren()[2]->getName());

        $xhtml1 = $epub1->getChildren()[1];
        $this->assertEquals("phpepub-navi.xhtml", $xhtml1->getChildren()[0]->getName());
        $this->assertEquals(EpubUtility::createFileName($this->_nestFilePath."fuga2-1.txt"), $xhtml1->getChildren()[1]->getName());
        $this->assertEquals(EpubUtility::createFileName($this->_nestFilePath."fuga2-2.php"), $xhtml1->getChildren()[2]->getName());
        $this->assertEquals(EpubUtility::createFileName($this->_nestFilePath."hoge2-1/fuga3-1.txt"), $xhtml1->getChildren()[3]->getName());
        $this->assertEquals(EpubUtility::createFileName($this->_nestFilePath."hoge2-1/fuga3-2.txt"), $xhtml1->getChildren()[4]->getName());
        $this->assertEquals(EpubUtility::createFileName($this->_nestFilePath."hoge2-1/hoge3-1/fuga4-1.txt"), $xhtml1->getChildren()[5]->getName());
        $this->assertEquals(EpubUtility::createFileName($this->_nestFilePath."hoge2-1/hoge3-1/fuga4-2.txt"), $xhtml1->getChildren()[6]->getName());
        $this->assertFalse(isset($xhtml1->getChildren()[7]));

        $css1 = $epub1->getChildren()[2];
        $this->assertEquals("style.css", $css1->getChildren()[0]->getName());

        $sample2 = $this->singleFileObj->crawl();
        $makerObj2 = new EpubMaker($sample2);
        $book2 = $makerObj2->assemble();
        $epub2 = $book2->getChildren()[2];
        $xhtml2 = $epub2->getChildren()[1];
        $this->assertEquals("phpepub-navi.xhtml", $xhtml2->getChildren()[0]->getName());
        $this->assertEquals(EpubUtility::createFileName($this->_singleFilePath), $xhtml2->getChildren()[1]->getName());
    }

}

