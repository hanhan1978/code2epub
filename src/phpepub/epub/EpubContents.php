<?php

class EpubContents{
    private $_book;
    private $_smartyParams;

    public function __construct($book){
        $this->_book = $book;
    }


    public function archive(){

    }

    public function getBook(){
        return $this->_book;
    }

    public function addSmartyParams($key, $paramArray){
        $this->_smartyParams[$key] = $paramArray;
    }


}
