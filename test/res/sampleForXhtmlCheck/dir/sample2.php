
<?php

class Sample2 {


    private $_hoge = null;

    public function __construct($hoge){

        $this->setHoge($hoge);

    }

    /**
     *  Function Description
     *
     *  @param $hoge 
     */
    private function setHoge($hoge){
        //set hoge
        $this->_hoge = $hoge;
    }

}
