<?php

require_once dirname(__FILE__)."/../../testHelper.php";

class EpubContentsTest extends PHPUnit_Framework_TestCase{


    public function testPakageOPF(){
        $xhtmls = array('page1', 'hoge/page2', 'page3');
        $packageOPF = EpubContents::packageOPF('titletest', $xhtmls);

        $this->assertEquals(1, preg_match('|<dc:title>titletest</dc:title>|u', $packageOPF));
        $this->assertEquals(1, preg_match('|<item href="xhtml/phpepub-page1.xhtml" id="page1"|', $packageOPF));
        $this->assertEquals(1, preg_match('|<item href="xhtml/phpepub-hoge_page2.xhtml" id="hoge_page2"|', $packageOPF));
    }

}

