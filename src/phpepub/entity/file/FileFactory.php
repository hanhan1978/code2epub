<?php



class FileFactory{

    public static function createFileEntry($entryName){
        if(self::isPhp($entryName))
            return new PhpEntry($entryName);
        return new FileEntry($entryName);
    }

    private static function isPhp($entryName){
        return preg_match('/\.php$/', $entryName);
    }
}
