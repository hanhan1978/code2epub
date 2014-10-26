<?php
require_once dirname(__FILE__)."/../../testHelper.php";

class CrawlerFactoryTest extends PHPUnit_Framework_TestCase{

    public function testCreateCrawler(){
        $obj1 = CrawlerFactory::createCrawler(TEST_ROOT."/res/sampleWithNestedContents");
        $this->assertEquals("FileCrawler", get_class($obj1));
        $obj2 = CrawlerFactory::createCrawler("http://www.php.net/manual/en/index.php");
        $this->assertEquals("WebCrawler", get_class($obj2));
    }

}
