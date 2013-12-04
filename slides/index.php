<?php
print <<< htmlcode
<?xml version="1.0" encoding="UTF-8"?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="en" lang="en"
      class="wf-adelle1adelle2-n6-active wf-active"> 
 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>PaySwarm - Presentations</title> 
 
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
 
  <link rel="stylesheet" href="../css/1140.css" type="text/css" media="screen" /> 
  <!--[if lte IE 9]>
  <link rel="stylesheet" href="../css/ie.css" type="text/css" media="screen" />
  <![endif]--> 
  <link rel="stylesheet" href="../css/typeimg.css" type="text/css" media="screen" /> 
  <link rel="stylesheet" href="../css/smallerscreen.css" media="only screen and (max-width: 1023px)" /> 
  <link rel="stylesheet" href="../css/mobile.css" media="handheld, only screen and (max-width: 767px)" /> 
  <link rel="stylesheet" href="../css/layout.css" type="text/css" media="screen" /> 
  <link rel="shortcut icon" type="image/png" href="../images/payswarm-icon.png" /> 
  
</head> 
<body> 
 
<div class="titlebar"> 
   <h1>PaySwarm</h1> 
</div> 
<div class="container vspacing"> 
  <div class="row"> 
    <div class="twelvecol"> 
      <h1>PaySwarm -
        <span class="subhead">Presentations</span></h1> 
    </div> 
  </div>
</div>

  <div id="content"> 

  <div class="row"> 
    <div class="twelvecol last"> 
      <p class="largeprint">
The following presentations have been given over the years to explain the 
basic concepts behind PaySwarm and the Web Payments initiatives. Documents 
marked as historical are provided to show how the concept has evolved 
throughout the years.
      </p>

      <ul>
htmlcode;

$Directory = new RecursiveDirectoryIterator('.', FilesystemIterator::SKIP_DOTS);
$Iterator = new RecursiveIteratorIterator($Directory);
$allSlides = new RegexIterator($Iterator, '/^.+index\.x?html$/i', RecursiveRegexIterator::GET_MATCH);

//rsort($allSlides);

foreach($allSlides as $match)
{
   $deck = $match[0];
   $zipfile = str_replace("/index.xhtml", ".zip", $match[0]);
   $zipfile = str_replace("/index.html", ".zip", $zipfile);
   $deckTitle = "Untitled";
   
   if(strpos($deck, 'template') !== false) continue;
   
   if(preg_match('/<title>(.+)<\/title>/', 
      file_get_contents($deck), $matches) && isset($matches[1]))
      $deckTitle = $matches[1];
   else
      $deckTitle = $deck;
   
   preg_match('/[0-9]{4,4}/', $deck, $matches);
   $deckYear = $matches[0];
   
   if($deckYear == "2010") $deckYear = "(Historical Document) 2010";
   
   print("                 <li><a href=\"$deck\">$deckYear - $deckTitle</a> (<a href=\"$zipfile\">zip archive</a>)</li>");
}

print <<< htmlcode

      </div>
    </div>
  </div>

 
<div class="container vspacing"> 
  <div class="row"> 
    <div class="threecol"> 
      <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/"><img alt="Creative Commons License" src="https://i.creativecommons.org/l/by-sa/3.0/88x31.png" /></a> 
    </div> 
    <div class="ninecol last"> 
      <p>&copy; 2010-2013 Digital Bazaar, Inc. 
Website CSS created by <a href="http://cssgrid.net/">@andytlr</a> 
and is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/au/"> 
Creative Commons Attribution-ShareAlike 3.0 Australia License</a>. All other
website content is licensed under a 
<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/"> 
Creative Commons Attribution-ShareAlike 3.0 License</a> 
</p> 
    </div> 
  </div> 
</div> 
 
<script type="text/javascript"> 
 
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1539674-7']);
  _gaq.push(['_trackPageview']);
 
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
  })();
 
</script> 
</body> 
</html>

htmlcode;

?>

