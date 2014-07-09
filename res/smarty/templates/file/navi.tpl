
<?xml version="1.0" encoding="utf-8"?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:epub="http://www.idpf.org/2007/ops">
<head>
<meta charset="utf-8"/>
<title>{$title}</title>
<link rel="stylesheet" type="text/css" href="../css/epub-spec.css"/>
</head>

<body>        
  <nav epub:type="toc" id="toc">
    <h1 class="title">Table of Contents</h1>    
    <ol>
      <li id="ttl"><a href="epub30-titlepage.xhtml">EPUB 3.0 Specification</a></li>
      <li id="ovw">
        <a href="epub30-overview.xhtml">EPUB 3 Overview</a>
        <ol>
          <li>
            1. Introduction
            <ol>
              <li><a href="epub30-overview.xhtml#sec-intro-overview">1.1. Overview</a></li>
              <li><a href="epub30-overview.xhtml#sec-intro-roadmap">1.2. Roadmap</a></li>
            </ol>
          </li>
          <li>
            <a href="epub30-overview.xhtml#sec-features">2. Features</a>
            <ol>
              <li><a href="epub30-overview.xhtml#sec-package-file">2.1. Package Document</a></li>
              <li>
                <a href="epub30-overview.xhtml#sec-nav">2.2. Navigation</a>
                <ol>
                  <li><a href="epub30-overview.xhtml#sec-nav-order">2.2.1. Reading Order</a></li>
                  <li><a href="epub30-overview.xhtml#sec-nav-nav-doc">2.2.2. Navigation Document</a></li>
                </ol>
              </li>
              <li><a href="epub30-overview.xhtml#sec-linking">2.3. Linking</a></li>
              <li><a href="epub30-overview.xhtml#sec-metadata">2.4. Metadata</a></li>
            </ol>
          </li>
        </ol>
      </li>
    </ol>
  </nav>

{function name=menu level=0}
  <ol class="level{$level}">
  {foreach $data as $entry}
    {if is_array($entry)}
      <li>{$entry@key}</li>
      {call name=menu data=$entry level=$level+1}
    {else}
      <li>{$entry}</li>
    {/if}
  {/foreach}
  </ol>
{/function}



  <nav epub:type="toc" id="toc">
    <h1 class="title">Table of Contents</h1>    
    <ol>
      <li id="ttl"><a href="epub30-titlepage.xhtml">EPUB 3.0 Specification</a></li>
    </ol>

  </nav>
</body>
</html>
