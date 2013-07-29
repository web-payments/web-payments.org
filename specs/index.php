<?php
function dirContents($dir)
{
   $contents = scandir($dir);
   rsort($contents);

   print("      <li style='padding-left: 3em;'>Previous Drafts: ");
   $items = array();
   foreach($contents as $item)
   {
      if(preg_match("/201[0-9]-[0-9]{2,2}-[0-9]{2,2}/", $item))
      {
         array_push($items, "<a href=\"$dir/$item/\">$item $type</a>");
      }
   }
   print(implode($items, ", "));
   print("</li>");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"
      class="wf-adelle1adelle2-n6-active wf-active">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>PaySwarm Specifications</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <link rel="stylesheet" href="../css/1140.css" type="text/css" media="screen" />
  <!--[if lte IE 9]>
  <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
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
      <h1>The PaySwarm Specifications.
        <span class="subhead">Open, standards-based, royalty-free.</span></h1>
    </div>
  </div>
  <div class="row">
    <div class="twelvecol last">
<p class="largeprint">
The PaySwarm specifications are available under an open, standards-based,
patent and royalty-free license. This means that, just like all other successful
Web technologies, any person or organization is free to implement the
specifications and inter-operate with one another without the express
permission or consent of the group that created PaySwarm.
</p>

<ul>
<li><a href="source/use-cases">PaySwarm Use Cases</a> - the primary
scenarios that are the basis for the PaySwarm Web API and Payment and
Transaction processing environment.
  <ul>
    <?php dirContents("ED/use-cases"); ?>
  </ul>
</li>
<li><a href="source/http-signatures">HTTP Signatures</a> - a digital signature
mechanism for the HTTP protocol that adds origin authentication and 
message integrity to HTTP requests.
  <ul>
    <?php dirContents("ED/http-signatures"); ?>
  </ul>
</li>
<li><a href="source/http-signature-nonces">HTTP Signature Nonces</a> - an extension
to the HTTP Signatures specification that enables replay protection when 
messages are sent over a non-secured HTTP connection.
  <ul>
    <?php dirContents("ED/http-signature-nonces"); ?>
  </ul>
</li>
<li><a href="source/http-signature-trailers">HTTP Signature Trailers</a> - an
extension to the HTTP Signatures specification that enables digital signatures
to be applied to content that is streamed, such as audio and video, via 
HTTP Trailers.
  <ul>
    <?php dirContents("ED/http-signature-trailers"); ?>
  </ul>
</li>
<li><a href="source/http-keys">HTTP Keys</a> - a secure and verifiable messaging
mechanism built using Linked Data principles to produce a distributed
Public Key Infrastructure for the Web.
  <ul>
    <?php dirContents("ED/web-keys"); ?>
  </ul>
</li>
<li><a href="source/web-payments">Web Payments</a> - the base layer of the
PaySwarm architecture; enables the creation of a monetary transaction between 
two participants on the Web.
  <ul>
    <?php dirContents("ED/web-payments"); ?>
  </ul>
</li>
<li><a href="source/web-commerce">Web Commerce</a> - the electronic 
commerce portion of the PaySwarm architecture; enabling the decentralized 
listing of assets for sale and the transaction of those assets resulting in a 
digitally verifiable receipt between the buyer and the vendor.
  <ul>
    <?php dirContents("ED/web-commerce"); ?>
  </ul>
</li>
<li><a href="source/payment-intents">Payment Intents</a> - the
parameterized transactions layer of the PaySwarm architecture; enables 
decentralized crowd-funding for innovative initiatives and projects.
  <ul>
    <?php dirContents("ED/payment-intents"); ?>
  </ul>
</li>
<li><a href="source/vocabs/commerce">Commerce Vocabulary</a> - the Web vocabulary 
that is used to describe commercial transactions.
  <ul>
    <!--<li>Current Editor Draft: <a href="../vocabs/commerce">current</a></li>-->
    <?php dirContents("ED/vocabs/commerce"); ?>
  </ul>
</li>
<li><a href="source/vocabs/payswarm">PaySwarm Vocabulary</a> - the Web vocabulary 
that is used to describe PaySwarm-specific concepts and properties on a 
PaySwarm network.
  <ul>
    <!--<li>Current Editor Draft: <a href="../vocabs/payswarm">current</a></li>-->
    <?php dirContents("ED/vocabs/payswarm"); ?>
  </ul>
</li>
<li><a href="source/vocabs/security">Security Vocabulary</a> - 
the Web vocabulary that is used to describe mechanisms for expressing
digital signatures and encrypting and decrypting messages.
  <ul>
    <!--<li>Current Editor Draft: <a href="../vocabs/security">current</a></li>-->
    <?php dirContents("ED/vocabs/security"); ?>
  </ul>
</li>
<li><a href="source/http-signatures-audit">Security Considerations for HTTP 
Signatures</a> - a complete security audit of the HTTP Signatures specification.
  <ul>
    <?php dirContents("ED/http-signatures-audit"); ?>
  </ul>
</li>
</ul>

</p>

<h2>Obsolete Specifications</h2>

<ul>
<li><a href="source/web-api">PaySwarm Web API</a> - the core PaySwarm 
protocol - listing, buying and selling digital assets.
  <ul>
    <?php dirContents("ED/web-api"); ?>
  </ul>
</li>
</ul>

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

