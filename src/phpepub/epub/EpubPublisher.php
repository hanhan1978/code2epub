<?php

class EpubPublisher{

    private $_book;
    private $_epub;


    private $_zip = null;

    public function __construct($book, $source){
        $this->_book = $book;
        $this->_zip = new ZipArchive();
        $this->_epub = new EpubContents($source);
    }


    public function archive(){
        $this->_zip->open($this->_book->getName().".epub", ZipArchive::OVERWRITE);
        $this->publish("", $this->_book); 
        $this->_zip->close();
    }

    public function publish($basedir, $entry){
        $children=$entry->getChildren();

        if($children === false){
            $this->createFile($basedir, $entry);
        }else{

            $path = $basedir === "" ? $entry->getName() : $basedir . DS . $entry->getName();
            $this->_zip->addEmptyDir($path);

            foreach($children as $child){
                $this->publish($path, $child);
            }
        }
    }

    /**
     *  Create epub content from twig template
     * */
    private function getTempalteContent($child){
        $filename = str_replace(' ', '', lcfirst(ucwords(preg_replace('/[\.\-]/', ' ', $child->getName()))));
        return $this->_epub->$filename();
    }

    /**
     *  Create XHTML epub content from a real file
     */
    private function getRealFileContent($child){
        $content = trim($this->_epub->singleFile(basename($child->getPath()),file_get_contents($child->getPath()) ));
        if(empty($content))
            $content = '(empty file)';
        return $content;
    }


    private function createFile($dir, $child){
        if($child->hasTemplate()){
            $content = $this->getTempalteContent($child);
        }else if($child->getContent()){
            $content = $child->getContent();
        }else{
            $content = $this->getRealFileContent($child);
        }
        $path = $dir === "" ? $child->getName() : $dir . DS. $child->getName();
        $this->_zip->addFromString($path, $content);
    }

}


