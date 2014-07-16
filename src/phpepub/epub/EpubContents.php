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
      <item href="xhtml/epub30-titlepage.xhtml" id="ttl" media-type="application/xhtml+xml"/>
      <item href="xhtml/epub30-nav.xhtml" id="nav" media-type="application/xhtml+xml" properties="nav"/>
      <item href="xhtml/epub30-terminology.xhtml" id="term" media-type="application/xhtml+xml"/>
   </manifest>
   <spine>
      <itemref idref="ttl"/>
      <itemref idref="nav" linear="no"/>
   </spine>
</package>
            ';

        return $template;
    }


    public static function navigation(){
        $template = '';

    }




    
}
