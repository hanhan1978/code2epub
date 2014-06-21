<?php
require_once dirname(__FILE__)."/../../../testHelper.php";

class FileEntryTest extends PHPUnit_Framework_TestCase{

    public function testToHtml(){
        $entry1 = FileFactory::createFileEntry(TEST_ROOT."/res/sampleOnlyOneFile/fuga.txt");
        $this->assertEquals("This is fuga file.", rtrim($entry1->toHtml()));
    }

}
