<?php


class FileCrawler extends Crawler{

    public function crawl(){
        return $this->crawlImple($this->resourceString);
    }

    /*
     *
     */
    private function crawlImple($dirname){
        if(!is_dir($dirname))
            return new FileEntry($dirname);
        else
            $d=dir($dirname);

        $box = new DirectoryEntry($dirname); 
        while($entry = $d->read()){
            if(preg_match("/^\.+$/", $entry)) continue;
            if(is_dir($dirname.DS.$entry))
                $box->add(self::crawlImple($dirname.DS.$entry)); 
            else
                $box->add(new FileEntry($entry));
        }
        $d->close();
        return $box;
    }
}
