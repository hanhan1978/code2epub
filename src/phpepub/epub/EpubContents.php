<?php

class EpubContents{

    private $_twig;

    public function __construct(){
        $loader = new Twig_Loader_Filesystem(ROOT.'res/twig/templates');
        $this->_twig = new Twig_Environment($loader);
    }

    public function mimetype(){
        return $this->_twig->render('mimetype', array(''));
    }

    public function containerXml(){
        return $this->_twig->render('container.xml', array(''));
    }

    public function packageOPF($title, $xhtmls){
        $files = array();
        foreach($xhtmls as $xhtml){
            $files[] = array('name' => self::createFileName($xhtml) , 'id' => self::createId($xhtml));
        }
        return $this->_twig->render('package.opf', array('title' => $title, 'files' => $files));
    }
    private function replaceSlash($str){
        return preg_replace('|[/\.]|', '_', $str);
    }

    public function createFileName($str){
        return "phpepub_".self::replaceSlash($str).".xhtml";
    }
    private function createId($str){
        return self::replaceSlash($str);
    }


    public function navigation($contents){
        $nav = self::makeNavigation($contents);
        return $this->_twig->render('navigation.xhtml', array('navi' => $nav));
    }

    private function makeNavigation($contents){
        $navi = "";
        $children = $contents->getChildren();
        if($children === false){
            $name = self::replaceSlash($contents->getPath());
            $navi .= '   <ol><li id="'.$name.'"><a href="phpepub_'.$name.'.xhtml">'.$contents->getName().'</a></li></ol>'."\n";
        }else{
            $navi .= (count($children) > 0)? "    <ol>\n" : "";
            foreach($children as $child){
                if($child->getChildren() !==false){
                    $navi .= "    <li>".$child->getName()."\n";
                    $navi .= self::makeNavigation($child);
                    $navi .= "    </li>\n";
                }else{
                    $name = self::replaceSlash($child->getPath());
                    $navi .= '    <li id="'.$name.'"><a href="phpepub_'.$name.'.xhtml">'.$child->getName().'</a></li>'."\n";
                }
            }
            $navi .= (count($children) > 0)? "    </ol>\n" : "";
        }
        return $navi;

    }

    public function singleFile($title, $source){
        return $this->_twig->render('base.xhtml', array('title' => $title, 'source' => $this->editSource($source)));
    }


    private function editSource($source){
        $source = htmlentities($source);
        $source = preg_replace("/\t/", '    ', $source);

        $lines = preg_split("/[\r\n]+/", $source);
        $lines = preg_replace("/ /", '&#160;', $lines);

        $edited="";
        $num=1;
        foreach($lines as $line){
            $edited .= "<span style='margin-right:15px'>". $num++ . "</span>" . $line . "\n";
        }
        return nl2br($edited);
    }



    
}
