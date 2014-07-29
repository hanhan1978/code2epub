<?php

require_once dirname(__FILE__)."/../../testHelper.php";

class EpubContentsTest extends PHPUnit_Framework_TestCase{

    private $nestFileObj;
    private $singleFileObj;

    function setup(){
        $this->nestFileObj   = CrawlerFactory::createCrawler(TEST_ROOT."/res/sampleWithNestedContents");
        $this->singleFileObj = CrawlerFactory::createCrawler(TEST_ROOT."/res/sampleOnlyOneFile/fuga.txt");
    }

    public function testPakageOPF(){
        $xhtmls = array('page1', 'hoge/page2', 'page3');
        $packageOPF = EpubContents::packageOPF('titletest', $xhtmls);

        $this->assertEquals(1, preg_match('|<dc:title>titletest</dc:title>|u', $packageOPF));
        $this->assertEquals(1, preg_match('|<item href="xhtml/phpepub_page1.xhtml" id="page1"|', $packageOPF));
        $this->assertEquals(1, preg_match('|<item href="xhtml/phpepub_hoge_page2.xhtml" id="hoge_page2"|', $packageOPF));
    }

    public function testNavigation(){
        $sample1 = $this->nestFileObj->crawl();
        $navigation = EpubContents::navigation($sample1);
        $this->assertEquals(1, preg_match('|<li>hoge2-1|u', $navigation));
        $this->assertEquals(1, preg_match('|fuga2-2.php</a></li>|u', $navigation));
        $this->assertEquals(1, preg_match('|<li>hoge2-2\n    </li>|us', $navigation));

        $sample2 = $this->singleFileObj->crawl();
        $navigation = EpubContents::navigation($sample2);
        $this->assertEquals(1, preg_match('|fuga.txt</a>|u', $navigation));
    }
}

