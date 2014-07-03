<?php

require_once dirname(__FILE__)."/../../../testHelper.php";

class SmartyEntryConverterTest extends PHPUnit_Framework_TestCase{

    private $nestFileObj;
    private $singleFileObj;

    function setup(){
        $this->nestFileObj   = CrawlerFactory::createCrawler(TEST_ROOT."/res/sampleWithNestedContents");
        $this->singleFileObj = CrawlerFactory::createCrawler(TEST_ROOT."/res/sampleOnlyOneFile/fuga.txt");
    }


    public function testConvert(){
        $sample1 = $this->nestFileObj->crawl();
        $obj0 = $sample1->getChildren()[0];

        $smarCon = new SmartyEntryConverter();
        $this->assertEquals("this is fuga2-1.txt", trim($smarCon->convert($obj0)));

        $obj1 = $sample1->getChildren()[1];
        $this->assertTrue(preg_match('|^<\?php|',$smarCon->convert($obj1))==1);

    }

}
