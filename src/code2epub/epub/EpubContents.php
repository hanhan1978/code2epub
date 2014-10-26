<?php

class EpubContents{

    private $_twig;
    private $_source;
    private $_book;

    public function __construct($source = null, $book = null){
        $loader = new Twig_Loader_Filesystem(ROOT.'res/twig/templates');
        $this->_twig = new Twig_Environment($loader);
        $this->_source = $source;
        $this->_book = $book;
    }

    public function mimetype(){
        return $this->_twig->render('mimetype', array(''));
    }

    public function containerXml(){
        return $this->_twig->render('container.xml', array(''));
    }

    public function packageOPF(){
        $files = array();
        foreach(EpubUtility::contents2array($this->_source) as $file){
            $files[] = array('name' => EpubUtility::createFileName($file->getPath()) , 'id' => EpubUtility::createId($file->getPath()));
        }
        return $this->_twig->render('package.opf', array('title' => $this->_source->getName(), 'files' => $files));
    }


    public function styleCss(){
        return $this->_twig->render('style.css', array(''));
    }

    public function code2epubNaviXhtml(){
        $nav = self::makeNavigation($this->_source);
        return $this->_twig->render('navigation.xhtml', array('title' => $this->_source->getName(), 'navi' => $nav));
    }

    private function makeNavigation($contents, $level=1){
        $navi = "";
        $children = $contents->getChildren();
        if($children === false){
            $name = EpubUtility::replaceSlash($contents->getPath());
            $navi .= '   <ol><li class=\'level'.$level.'\' id="'.$name.'"><a href="code2epub_'.$name.'.xhtml">'.$contents->getName().'</a></li></ol>'."\n";
        }else{
            $navi .= (count($children) > 0)? "    <ol>\n" : "";
            foreach($children as $child){
                if($child->getChildren() !==false){
                    $navi .= "    <li class='level$level'>".$child->getName()."\n";
                    $navi .= self::makeNavigation($child, $level+1);
                    $navi .= "    </li>\n";
                }else{
                    $name = EpubUtility::replaceSlash($child->getPath());
                    $navi .= '    <li class=\'level'.$level.'\' id="'.$name.'"><a href="code2epub_'.$name.'.xhtml">'.$child->getName().'</a></li>'."\n";
                }
            }
            $navi .= (count($children) > 0)? "    </ol>\n" : "";
        }
        return $navi;

    }

    public function singleFile($title, $source){
        return $this->_twig->render('base.xhtml', array('title' => $title, 'lines' => $this->editSource($source)));
    }


    private function editSource($source){
        $source = htmlentities($source);
        $source = preg_replace("/\t/", '    ', $source);
        $lines = preg_split("/[\r\n]+/", $source);
        $lines = preg_replace("/ /", '&#160;', $lines);
        return $lines; 
    }



    
}
