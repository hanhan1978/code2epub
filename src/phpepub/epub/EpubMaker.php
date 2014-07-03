<?php


class EpubMaker{


    public static function assemble($contents){

        $book = new DirectoryEntry(self::getTitle($contents)); 
        $book->add(new FileEntry('mimetype'));

        //add metainf => static contents
        $book->add(self::makeMetainf());
        $book->add(self::makeEpub());

        return $book;

    }
    private static function makeMetainf(){
        $metainf = new DirectoryEntry('META-INF');
        $metainf->add(new FileEntry('container.xml'));
        return $metainf;
    }

    private static function makeEpub(){
        $epub = new DirectoryEntry('EPUB');
        $epub->add(new FileEntry('package.opf'));
        $epub->add(new DirectoryEntry('xhtml'));
        return $epub;
    }

    private static function getTitle($contents){
        return $contents->getName();
    }

}
