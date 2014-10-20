<?php


class EpubMaker{

    private $_contents;
    private $_epub;

    //TODO create packageOPF content & navigation, that's all
    //
    public function __construct($_contents){
        $this->_contents = $_contents;
        $this->_epub = new EpubContents();
    }

    public function assemble(){

        $book = new DirectoryEntry($this->getTitle()); 
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
        $xhtml = EpubUtility::makeXhtml($this->_contents, $xhtml );
//        $xhtml->dump();
        $epub->add($this->makePakageOpf($this->entry2array($xhtml)));
        $epub->add($xhtml);
        $css = new DirectoryEntry('css');
        $css->add($this->makeCss());
        $epub->add($css);

        return $epub;
    }

    private function entry2array($xhtml){
        $arr = array();
        foreach($xhtml->getChildren() as $child){
            $arr[] = $child->getPath();
        }
        return $arr;
    }

    private function makePakageOpf($xhtml){
        $entry = new FileEntry('package.opf');
        array_shift($xhtml);
        $entry->setContent($this->_epub->packageOPF($this->getTitle(), $xhtml));
        return $entry;
    }

    private function getTitle(){
        return $this->_contents->getName();
    }


}
