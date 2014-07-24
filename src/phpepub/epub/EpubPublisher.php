<?php

class EpubPublisher{

    private $_book;

    private $_tempdir = ".temp";

    public function __construct($book){
        $this->_book = $book;
    }


    public function materialize(){
        $this->createTempDir();


        $this->deleteTempDir();
    }


    private function createTempDir(){
        while(true){
            if(!is_dir($this->_tempdir)){
                break;
            }
            $this->_tempdir .= "x";
        }
        mkdir($this->_tempdir);
        touch($this->_tempdir . DS. "hoge.txt");
        touch($this->_tempdir . DS. ".hoge.txt");
    }


    private function deleteTempDir(){
        $this->deleteTempDirImpl($this->_tempdir);
        rmdir($this->_tempdir);
    }

    private function deleteTempDirImpl($dirname){
        $d=dir($dirname);
        while($entry = $d->read()){
            if(is_file($entry))
                unlink($entry);
            else
                $this->deleteTempDirImpl($entry);
        }
        $d->close();
    }

}


