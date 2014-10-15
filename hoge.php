<?php

$str = 'phpepub-navi.xhtml';



$filename = str_replace(' ', '', lcfirst(ucwords(preg_replace('/[.-]/', ' ', $str))));

echo $filename;
