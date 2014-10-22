<?php $TOP_DIR='..'; include '../header.inc'; ?>

<!-- ==== HEADER -->
<section class="section-divider textdivider divider1">
  <div class="container">
    <h1>PRESENTATIONS</h1>
    <hr>
    <p>
The following presentations have been given over the years to explain the 
basic concepts behind the Web Payments initiative. Documents 
marked as historical are provided to show how the concept has evolved 
throughout the years.
    </p>
  </div>
</section>

<section>
<div class="container" id="presentations">
  <div class="row white">
  <br>
    <div class="col-lg-offset-1 col-lg-10">
      <ul>
    
<?php 
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
   
   print("                 <li><a href=\"$deck\">$deckYear - $deckTitle</a> (<a href=\"$zipfile\">zip archive</a>)</li>\n");
}
?>
      </ul>
    </div>
  </div>
</section>

<?php $TOP_DIR='..'; include '../footer.inc'; ?>
