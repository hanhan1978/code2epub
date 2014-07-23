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
            $name = preg_replace('|/|', '_', $xhtml);
            $manifest .=  '      <item href="xhtml/phpepub-'. $name .'.xhtml" id="'.$name.'" media-type="application/xhtml+xml"/>'."\n";
            $spine    .=  '      <itemref idref="'.$name.'"/>'."\n";
        }

        return sprintf($template, $title, $manifest, $spine);
    }


    public static function navigation(){
        $template = '';

    }




    
}
