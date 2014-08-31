<?php

class Sample1 {


    private $_fuga = null;

    public function __construct($fuga){

        $this->setFuga($fuga);

    }

    /**
     *  Function Description
     *
     *  @param $fuga 
     */
    private function setFuga($fuga){
        //set fuga
        $this->_fuga = $fuga;
    }

}
