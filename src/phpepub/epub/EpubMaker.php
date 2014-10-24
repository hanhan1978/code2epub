<?php

class EpubMaker{

    private $_contents;
    private $_epub;

    public function __construct($_contents){
        $this->_contents = $_contents;
        $this->_epub = new EpubContents();
    }

    public function assemble(){
        $book = new DirectoryEntry($this->_contents->getName()); 
        $book->add($this->makeMimetype());
        $book->add($this->makeMetainf());
        $book->add($this->makeEpub());
        return $book;
    }

    private function makeMimetype(){
        $file = (new FileEntry('mimetype'))->templatable();
        return $file;
    }

    private function makeMetainf(){
        $metainf = new DirectoryEntry('META-INF');
        $file = (new FileEntry('container.xml'))->templatable();
        $metainf->add($file);
        return $metainf;
    }

    private function makeNavi(){
        $file = (new FileEntry('phpepub-navi.xhtml'))->templatable();
        return $file;
    }

    private function makeCss(){
        $file = (new FileEntry('style.css'))->templatable();
        return $file;
    }

    private function makeEpub(){
        $epub = new DirectoryEntry('EPUB');
        $xhtml = new DirectoryEntry('xhtml');
        $xhtml->add( $this->makeNavi()); 
        $files = EpubUtility::contents2array($this->_contents);
        foreach($files as $file){
            $xhtml->add($file);
        }
        $epub->add((new FileEntry('package.opf'))->templatable());
        $epub->add($xhtml);
        $css = new DirectoryEntry('css');
        $css->add($this->makeCss());
        $epub->add($css);
        return $epub;
    }



}
