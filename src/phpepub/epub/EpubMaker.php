<?php


class EpubMaker{

    private $_contents;

    //TODO create packageOPF content & navigation, that's all
    //
    public function __construct($_contents){
        $this->_contents = $_contents;

    }

    public function assemble(){

        $book = new DirectoryEntry($this->getTitle($this->_contents)); 
        $book->add($this->makeMimetype());

        $book->add($this->makeMetainf());
        $book->add($this->makeEpub());

        $navi = $this->makeNavigation();

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

    private function makeEpub(){
        $epub = new DirectoryEntry('EPUB');
        $epub->add($this->makePakageOpf());
        $epub->add($this->makeXhtml($this->_contents));
        return $epub;
    }

    private function makePakageOpf(){
        $entry = new FileEntry('package.opf');
        $entry->setContent(EpubContents::packageOPF());


        return $entry;
    }

    private function makeXhtml($contents, $container = null){
        if(is_null($container))
            $container = new DirectoryEntry('xhtml');
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

    private function makeNavigation(){
        return $this->scan($this->_contents); 
    }


    private function scan($contents){
        $navi = array();

        $children = $contents->getChildren();
        if($children === false){
        }else{
            foreach($children as $child){
                if($child->getChildren() !==false)
                    $navi[] = array($child->getName() => $this->scan($child));
                else
                    $navi[] = $child->getName();
            }
        }
        return $navi;

    }

}
