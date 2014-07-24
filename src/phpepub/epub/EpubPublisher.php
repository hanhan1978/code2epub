<?php

class EpubPublisher{

    private $_book;

    private $_tempdir = ".temp";

    public function __construct($book){
        $this->_book = $book;
    }


    public function materialize(){
        $this->createTempDir();

        $this->publish(); 

    }

    public function publish(){
        $basedir = $this->_tempdir.DS.$this->_book->getName();
        mkdir($basedir);

        $children=$this->_book->getChildren();

        foreach($children as $child){
            if($child->getChildren() === false){
                $fp = fopen($basedir . DS . $child->getName(), 'w');
                fwrite($fp, $child->getContent());
                fclose($fp);
            }
        }

    }


    private function createTempDir(){
        while(true){
            if(!is_dir($this->_tempdir)){
                break;
            }
            $this->_tempdir .= "x";
        }
        mkdir($this->_tempdir);
    }


    private function deleteTempDir(){
        $this->deleteTempDirImpl($this->_tempdir);
    }

    private function deleteTempDirImpl($dirname){
        $d=dir($dirname);
        while($entry = $d->read()){
            if(preg_match("/^\.+$/", $entry)) continue;
            if(is_dir($dirname.DS.$entry))
                $this->deleteTempDirImpl($dirname.DS.$entry);
            else
                unlink($dirname.DS.$entry);
        }
        $d->close();
        rmdir($dirname);
    }

}


