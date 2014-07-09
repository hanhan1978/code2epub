<?php


class FileCrawler extends Crawler{

    public function crawl(){
        return $this->crawlImple($this->resourceString);
    }

    /*
     *
     */
    private function crawlImple($dirname, $parentName=null){
        if(!is_dir($dirname))
            return new FileEntry($dirname, $parentName);
        else
            $d=dir($dirname);

        $box = new DirectoryEntry($dirname, $parentName); 
        while($entry = $d->read()){
            if(preg_match("/^\.+$/", $entry)) continue;
            if(is_dir($dirname.DS.$entry))
                $box->add(self::crawlImple($dirname.DS.$entry, $box->getName())); 
            else
                $box->add(new FileEntry($dirname.DS.$entry, $box->getName()));
        }
        $d->close();
        return $box;
    }
}
