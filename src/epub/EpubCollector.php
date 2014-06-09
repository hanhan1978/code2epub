<?php


class EpubCollector{

    /*
     *
     */
    public static function assemble($dirname){
        $d=dir($dirname);
        
        $box = new DirectoryEntry($d); 
        while($entry = $d->read()){
            if(preg_match("/^\.+$/", $entry)) continue;
            if(is_dir($dirname."/".$entry))
              $box->add(ls($dirname."/".$entry)); 
            else
              $box->add(new FileEntry($entry));
        }
        $d->close();
        return $box;
    }
}
