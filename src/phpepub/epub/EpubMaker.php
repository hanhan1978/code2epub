<?php


class EpubMaker{


    public static function assemble($contents){

        $book = new DirectoryEntry(self::getTitle($contents)); 
        $book->add(self::makeMimetype());

        //add metainf => static contents
        $book->add(self::makeMetainf());
        //add Epub Xhtml very important.
        $book->add(self::makeEpub($contents));

        $navi = self::makeNavigation($contents);
//        var_dump($navi);

        return $book;

    }

    private static function makeMimetype(){
        $file = new FileEntry('mimetype');
        $file->setContent(EpubContents::mimetype());
        return $file;
    }

    private static function makeMetainf(){
        $metainf = new DirectoryEntry('META-INF');
        $file = new FileEntry('container.xml');
        $file->setContent(EpubContents::containerXML());
        $metainf->add($file);
        return $metainf;
    }

    private static function makeEpub($contents){
        $epub = new DirectoryEntry('EPUB');
        $epub->add(new FileEntry('package.opf'));
        $epub->add(self::makeXhtml($contents));
        return $epub;
    }

    private static function makeXhtml($contents, $container = null){
        if(is_null($container))
            $container = new DirectoryEntry('xhtml');
        $children = $contents->getChildren();
        if($children === false){
            $container->add($contents);
        }else{
            foreach($children as $child){
                self::makeXhtml($child, $container);
            }
        }
        return $container;
    }


    private static function getTitle($contents){
        return $contents->getName();
    }

    private static function makeNavigation($contents){
        return self::scan($contents); 
    }


    private static function scan($contents){
        $navi = array();

        $children = $contents->getChildren();
        if($children === false){
        }else{
            foreach($children as $child){
                if($child->getChildren() !==false)
                    $navi[] = array($child->getName() => self::scan($child));
                else
                    $navi[] = $child->getName();

            }
        }
        return $navi;

    }

}
