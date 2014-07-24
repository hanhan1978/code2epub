<?php


class EpubMaker{

    private $_contents;

    //TODO create packageOPF content & navigation, that's all
    //
    public function __construct($_contents){
        $this->_contents = $_contents;

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
        $file->setContent(EpubContents::mimetype());
        return $file;
    }

    private function makeMetainf(){
        $metainf = new DirectoryEntry('META-INF');
        $file = new FileEntry('container.xml');
        $file->setContent(EpubContents::containerXML());
        $metainf->add($file);
        return $metainf;
    }
    private function makeNavi(){
        $file = new FileEntry('phpepub-navi.xhtml');
        $file->setContent(EpubContents::navigation($this->_contents));
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
        $entry->setContent(EpubContents::packageOPF($this->getTitle(), $xhtml));


        return $entry;
    }

    private function makeXhtml($contents, $container = null){
        $children = $contents->getChildren();
        if($children === false){
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
