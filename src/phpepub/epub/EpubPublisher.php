<?php

class EpubPublisher{

    private $_book;

    private $_tempdir = ".temp";

    public function __construct($book){
        $this->_book = $book;
    }


    public function materialize(){
        $this->createTempDir();

        $this->publish($this->_tempdir, $this->_book); 

    }

    public function publish($basedir, $entry){
        $children=$entry->getChildren();

        if($children === false){
            $this->createFile($basedir, $entry);
        }else{
            foreach($children as $child){
                $this->publish($basedir . DS . $entry->getName(), $child);
            }
        }
    }


    public function archive(){

    }



    private function createFile($dir, $child){
        if(!is_dir($dir)){
            mkdir($dir);
        }
        if(!$content = $child->getContent()){
            $content = EpubContents::singleFile(basename($child->getPath()),file_get_contents($child->getPath()) );
            if(empty(trim($content)))
                $content = '(empty file)';
            $content = nl2br($content);
        }

        $fp = fopen($dir . DS . $child->getName(), 'w');
        fwrite($fp, $content);
        fclose($fp);
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


