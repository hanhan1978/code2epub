<?php


class EpubMaker{


    public static function assemble($contents){

        $book = new DirectoryEntry(self::getTitle($contents)); 
        $book->add(new FileEntry('mimetype'));

        //add metainf => static contents
        $book->add(self::makeMetainf());
        //add Epub Xhtml very important.
        $book->add(self::makeEpub($contents));

        $epub = new EpubContents($book);

        $kusoga = self::makeNavigation($contents);


        return $epub;

    }

    private static function makeMetainf(){
        $metainf = new DirectoryEntry('META-INF');
        $metainf->add(new FileEntry('container.xml'));
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
        $block = function($kuso, $contents){
            if($contents->hasParent()){
                $kuso[$contents->getParentName()][$contents->getName()] = $contents->getPath();
            }
            return $kuso;
        };
        
        $kuso=array();
        $navi = self::scan($contents, $kuso, $block); 
        print_r($navi);

    }


    private static function scan($contents, $container, $block){

        $children = $contents->getChildren();
        $container = $block($container, $contents);
        if($children === false){
        }else{
            foreach($children as $child){
                $container = self::scan($child, $container, $block);
            }
        }
        return $container;

    }

}
