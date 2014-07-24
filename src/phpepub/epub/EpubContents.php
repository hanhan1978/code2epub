<?php

class EpubContents{


    public static function mimetype(){
        return "application/epub+zip";
    }

    public static function containerXml(){
        $con = ' <?xml version="1.0" encoding="UTF-8"?>
<container xmlns="urn:oasis:names:tc:opendocument:xmlns:container" version="1.0">
   <rootfiles>
      <rootfile full-path="EPUB/package.opf" media-type="application/oebps-package+xml"/>
   </rootfiles>
</container>';
        return $con;
    }

    public static function packageOPF($title, $xhtmls){
        $template = '
<?xml version="1.0" encoding="UTF-8"?>
<package xmlns="http://www.idpf.org/2007/opf" version="3.0" unique-identifier="uid">
   <metadata xmlns:dc="http://purl.org/dc/elements/1.1/">
      <dc:identifier id="uid">code.google.com.epub-samples.epub30-spec</dc:identifier>
      <dc:title>%s</dc:title>
      <dc:creator>PHP EPUB CREATOR</dc:creator>
      <dc:language>en</dc:language>
      <meta property="dcterms:modified">2012-02-27T16:38:35Z</meta>
   </metadata>
   <manifest>
      <item href="xhtml/phpepub-navi.xhtml" id="navi" media-type="application/xhtml+xml" properties="nav"/>
%s
   </manifest>
   <spine>
      <itemref idref="navi"/>
%s
   </spine>
</package>
            ';
        $manifest = "";
        $spine = "";
        foreach($xhtmls as $xhtml){
            $name = self::replaceSlash($xhtml); 
            $manifest .=  '      <item href="xhtml/phpepub_'. $name .'.xhtml" id="'.$name.'" media-type="application/xhtml+xml"/>'."\n";
            $spine    .=  '      <itemref idref="'.$name.'"/>'."\n";
        }

        return sprintf($template, $title, $manifest, $spine);
    }
    private static function replaceSlash($str){
        return preg_replace('|/|', '_', $str);
    }


    public static function navigation($contents){
        $template = '
<?xml version="1.0" encoding="utf-8"?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:epub="http://www.idpf.org/2007/ops">
<head>
<meta charset="utf-8"/>
<title>EPUB 3 Specifications - Table of Contents</title>
<!--link rel="stylesheet" type="text/css" href="../css/epub-spec.css"/ -->
</head>

<body>        
  <nav epub:type="toc" id="toc">
    <h1 class="title">Table of Contents</h1>    
%s
        
  </nav>
        
  <nav epub:type="landmarks" hidden="">
    <h2>Guide</h2>
    <ol>
      <li><a epub:type="toc" href="#toc">Table of Contents</a></li>
    </ol>
  </nav>
</body>
</html>
            ';

        $nav = self::makeNavigation($contents);
        return sprintf($template, $nav);

    }

    private static function makeNavigation($contents){
        return self::scan($contents); 
    }


    private static function scan($contents){
        $navi = "";

        $children = $contents->getChildren();
        if($children === false){
        }else{
            $navi .= (count($children) > 0)? "    <ol>\n" : "";
            foreach($children as $child){
                if($child->getChildren() !==false){
                    //$navi[] = array($child->getName() => self::scan($child));
                    $navi .= "    <li>".$child->getName()."\n";
                    $navi .= self::scan($child);
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



    
}
