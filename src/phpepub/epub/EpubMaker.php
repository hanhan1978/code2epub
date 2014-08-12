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
        $file = new FileEntry('mimetype');
        $file->setContent($this->_epub->mimetype());
        return $file;
    }

    private function makeMetainf(){
        $metainf = new DirectoryEntry('META-INF');
        $file = new FileEntry('container.xml');
        $file->setContent($this->_epub->containerXML());
        $metainf->add($file);
        return $metainf;
    }
    private function makeNavi(){
        $file = new FileEntry('phpepub-navi.xhtml');
        $file->setContent($this->_epub->navigation($this->_contents));
        return $file;
    }

    private function makeEpub(){
        $epub = new DirectoryEntry('EPUB');
        $xhtml = new DirectoryEntry('xhtml');
        $xhtml->add( $this->makeNavi()); 
        $xhtml = $this->makeXhtml($this->_contents, $xhtml );
        $epub->add($this->makePakageOpf($this->entry2array($xhtml)));
        $epub->add($xhtml);
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

    private function makeXhtml($contents, $container = null){
        $children = $contents->getChildren();
        if($children === false){
            $contents->setName($this->_epub->createFileName($contents->getPath()));
            $container->add($contents);
        }else{
            foreach($children as $child){
                $this->makeXhtml($child, $container);
            }
        }
        return $container;
    }


    private function getTitle(){
        return $this->_contents->getName();
    }


}
