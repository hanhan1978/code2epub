<?php
require_once dirname(__FILE__)."/../../../testHelper.php";

class FileFactoryTest extends PHPUnit_Framework_TestCase{

    public function testCreateFileEntry(){
        $entry1 = FileFactory::createFileEntry("abcdefg.txt");
        $this->assertEquals("FileEntry", get_class($entry1));
        $entry2 = FileFactory::createFileEntry("abcdefg.php");
        $this->assertEquals("PhpEntry", get_class($entry2));
    }

}
