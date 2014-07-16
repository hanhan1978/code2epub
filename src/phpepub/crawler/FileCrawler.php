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
            $entries = $this->getEntries($dirname);

        $box = new DirectoryEntry($dirname, $parentName); 
        foreach($entries as $entry){
            if(is_dir($entry))
                $box->add(self::crawlImple($entry, $box->getName())); 
            else
                $box->add(new FileEntry($entry, $box->getName()));
        }
        return $box;
    }


    private function getEntries($dirname){
        $list = array();
        $d=dir($dirname);
        while($entry = $d->read()){
            if(preg_match("/^\.+$/", $entry)) continue;
            $list[] = $dirname.DS.$entry;
        }
        $d->close();
        sort($list);
        return $list;
    }
}
