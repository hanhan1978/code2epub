<?php

require_once dirname(__FILE__)."/../../testHelper.php";

class EpubContentsTest extends PHPUnit_Framework_TestCase{

    private $nestFileObj;
    private $singleFileObj;
    private $xhtmlCheckObj;
    private $_epub;

    function setup(){
        $this->xhtmlCheckObj   = CrawlerFactory::createCrawler(TEST_ROOT."/res/sampleForXhtmlCheck");
        $this->nestFileObj     = CrawlerFactory::createCrawler(TEST_ROOT."/res/sampleWithNestedContents");
        $this->singleFileObj   = CrawlerFactory::createCrawler(TEST_ROOT."/res/sampleOnlyOneFile/fuga.txt");
        $this->_epub = new EpubContents();
    }

    public function testPakageOPF(){

        $xhtmls = array('page1', 'hoge/page2', 'page3');
        $packageOPF = $this->_epub->packageOPF('titletest', $xhtmls);

        $this->assertEquals(1, preg_match('|<dc:title>titletest</dc:title>|u', $packageOPF));
        $this->assertEquals(1, preg_match('|<item href="xhtml/phpepub_page1.xhtml" id="page1"|', $packageOPF));
        $this->assertEquals(1, preg_match('|<item href="xhtml/phpepub_hoge_page2.xhtml" id="hoge_page2"|', $packageOPF));
    }

    public function testNavigation(){
        $sample1 = $this->nestFileObj->crawl();
        $this->_epub = new EpubContents($sample1);
        $navigation = $this->_epub->phpepubNaviXhtml();
        $this->assertEquals(1, preg_match('|<li>hoge2-1|u', $navigation));
        $this->assertEquals(1, preg_match('|fuga2-2.php</a></li>|u', $navigation));
        $this->assertEquals(1, preg_match('|<li>hoge2-2\n    </li>|us', $navigation));

        $sample2 = $this->singleFileObj->crawl();
        $this->_epub = new EpubContents($sample2);
        $navigation = $this->_epub->phpepubNaviXhtml();
        $this->assertEquals(1, preg_match('|fuga.txt</a>|u', $navigation));
    }

    public function testSingleFileXhtmlConversion(){
        $sample1 = $this->xhtmlCheckObj->crawl();
        $makerObj1 = new EpubMaker($sample1);
        $book1 = $makerObj1->assemble();


        $mimetype = $book1->getChildren()[0];
        //$content = trim($this->_epub->singleFile(basename($sampleXhtml1->getPath()),file_get_contents($sampleXhtml1->getPath()) ));


        $sampleXhtml3 = $book1->getChildren()[2]->getChildren()[1]->getChildren()[1];
        $sampleXhtml2 = $book1->getChildren()[2]->getChildren()[1]->getChildren()[2];
        $sampleXhtml1 = $book1->getChildren()[2]->getChildren()[1]->getChildren()[3];
        $content = trim($this->_epub->singleFile(basename($sampleXhtml1->getPath()),file_get_contents($sampleXhtml1->getPath()) ));
        $this->assertEquals(1, preg_match("|<div class='line-number'>1</div>&lt;\?php<br/>|", $content));
    }
}

