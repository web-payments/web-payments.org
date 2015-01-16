<?php $TOP_DIR='..'; include '../header.inc'; ?>

<?php
function dirContents($dir)
{
   $contents = scandir($dir);
   rsort($contents);

   $items = array();
   foreach($contents as $item)
   {
      if(preg_match("/201[0-9]-[0-9]{2,2}-[0-9]{2,2}/", $item))
      {
         array_push($items, "<a href=\"$dir/$item/\">$item $type</a>");
      }
   }
   print(implode($items, ", "));
   
   if(count($items) === 0) 
   {
      print "None.";
   }
}
?>
<!-- ==== HEADER -->
<section class="section-divider textdivider divider1">
  <div class="container">
    <h1>THE SPECIFICATIONS</h1>
    <hr>
    <p>
The Web Payments specs are available under an open, patent and royalty-free 
license. Just like all other successful open Web technologies, the freedom to 
innovate is a fundamental part of what we do.
    </p>
  </div><!-- container -->
</section>

<!-- ==== DESIGN ==== -->
<section>
<div class="container" id="use-cases">
  <div class="row white">
  <br>
    <h1 class="centered"><span class="icon icon-yin-yang"></span><br/> DESIGN</h1>
    <hr>
    <div class="col-lg-offset-1 col-lg-10">
      <p>
<a href="source/design-principles">Design Principles</a>:
An outline of the design principles and general philosophy used to guide the 
standards making process behind the technology that the Web Payments group 
creates. The principles are meant to be a set of general guidelines rather than 
a set of prescriptive rules. Time-stamped drafts: <?php dirContents("ED/design-principles"); ?>
      </p>
      <p>
<a href="source/use-cases">Use Cases</a>:
The primary goal of the Web Payments work is to create a safe, 
decentralized system and a set of open, patent and 
royalty-free specifications that allow people on the Web to send each other 
money as easily as they exchange instant messages and e-mail today. The 
following use cases focus on concrete scenarios that the technology created
by the group should enable.
Time-stamped drafts: 
<?php dirContents("FCGS/use-cases"); ?>, <?php dirContents("ED/use-cases"); ?>
      </p>
      <p>
<a href="source/roadmap">Roadmap</a>:
The Web Payments CG Roadmap outlines the proposed technology stack and 
development timeline for the set of technologies being worked on by the 
Web Payments Community Group.
Time-stamped drafts: <?php dirContents("ED/roadmap"); ?>
      </p>
    </div><!-- col-lg-6 -->
  </div><!-- row -->
</div><!-- container -->
</section>

<!-- ==== PRODUCTS ==== -->
<section>
<div class="container" id="products">
  <div class="row white">
  <br>
    <h1 class="centered"><span class="icon icon-rocket"></span><br/> PRODUCTS</h1>
    <hr>
    <div class="col-lg-offset-1 col-lg-10">
      <p>
<a href="source/web-commerce">Web Commerce</a>: The electronic 
commerce portion of the PaySwarm architecture; enabling the decentralized 
listing of assets for sale and the transaction of those assets resulting in a 
digitally verifiable receipt between the buyer and the vendor.
Time-stamped drafts: <?php dirContents("ED/web-commerce"); ?>
      </p>
      <p>
<a href="source/web-price-indexes">Pricing Indices</a>: Vendors can select one of the available online price indexing services, which could be a currency exchange rate, or another type of index more relevant to the scope and dynamics of their particular business that would enable greater price stability, variability with key input prices, or some other criterion.
Time-stamped drafts: <?php dirContents("ED/web-price-indexes"); ?>
      </p>
    </div><!-- col-lg-6 -->
  </div><!-- row -->
</div><!-- container -->
</section>

<!-- ==== TRANSACTIONS ==== -->
<section>
<div class="container" id="transactions">
  <div class="row white">
  <br>
    <h1 class="centered"><span class="icon icon-cart"></span><br/> TRANSACTIONS</h1>
    <hr>
    <div class="col-lg-offset-1 col-lg-10">
      <p>
<a href="source/web-payments">Web Payments</a>: The base layer of the
Web Payments architecture; enables the creation of a monetary transaction 
between two participants on the Web.     
Time-stamped drafts: <?php dirContents("ED/web-payments"); ?>
      </p>
      <p>
<a href="source/web-commerce-api">Web Commerce API</a>: Outlines a browser 
polyfill that makes financial transactions easier to initiate and verify 
while also making them more secure. The solution is designed to work with both 
proprietary (PayPal, Google Wallet) and non-proprietary (PaySwarm, Bitcoin, 
Ripple) payment solutions.
Time-stamped drafts: <?php dirContents("ED/web-commerce-api"); ?>
      </p>

      <p>
<a href="source/payment-intents">Payment Intents</a>: The parameterized 
transactions layer of the Web Payments architecture; enables decentralized, 
open crowd-funding over the Web.
Time-stamped drafts: <?php dirContents("ED/payment-intents"); ?>
      </p>
      <p>
<a href="source/vocabs/commerce.html">Commerce Vocabulary</a>: The Web vocabulary 
that is used to describe commercial transactions.
Time-stamped drafts: <?php dirContents("ED/vocabs/commerce"); ?>
      </p>
      <p>
<a href="source/vocabs/payswarm.html">PaySwarm Vocabulary</a>: The Web vocabulary 
that is used to describe specific concepts and properties on a 
Web Payments network.
Time-stamped drafts: <?php dirContents("ED/vocabs/payswarm"); ?>
      </p>
      <p>
<a href="source/vocabs/creditcard.html">Credit Card Vocabulary</a>: The Web vocabulary 
that is used to describe credit cards.
      </p>
    </div><!-- col-lg-6 -->
  </div><!-- row -->
</div><!-- container -->
</section>

<!-- ==== RECEIPTS ==== -->
<section>
<div class="container" id="receipts">
  <div class="row white">
  <br>
    <h1 class="centered"><span class="icon icon-file"></span><br/> RECEIPTS</h1>
    <hr>
    <div class="col-lg-offset-1 col-lg-10">
      <p>
<a href="source/web-commerce">Web Commerce</a>: The electronic commerce portion 
of the Web Payments architecture; enabling the decentralized listing of assets 
for sale and the transaction of those assets resulting in a digitally 
verifiable receipt between the buyer and the vendor. 
Time-stamped drafts: <?php dirContents("ED/web-commerce"); ?>
      </p>
    </div><!-- col-lg-6 -->
  </div><!-- row -->
</div><!-- container -->
</section>

<!-- ==== IDENTITY ==== -->
<section>
<div class="container" id="identity">
  <div class="row white">
  <br>
    <h1 class="centered"><span class="icon icon-users"></span><br/> IDENTITY</h1>
    <hr>
    <div class="col-lg-offset-1 col-lg-10">
      <p>
<a href="source/identity-credentials/">Identity Credentials</a>: A decentralized 
identity mechanism for the Web that allows arbitrary Linked Data to be read from 
and written to an identity URL.
Time-stamped drafts: <?php dirContents("ED/identity-credentials"); ?>
      </p>
    </div><!-- col-lg-6 -->
  </div><!-- row -->
</div><!-- container -->
</section>

<!-- ==== SECURITY ==== -->
<section>
<div class="container" id="security">
  <div class="row white">
  <br>
    <h1 class="centered"><span class="icon icon-lock"></span><br/> SECURITY</h1>
    <hr>
    <div class="col-lg-offset-1 col-lg-10">
      <p>
<a href="source/http-signatures">HTTP Signatures</a>: A digital signature
mechanism for the HTTP protocol that adds origin authentication and message 
integrity to HTTP requests.
Time-stamped drafts: <?php dirContents("ED/http-signatures"); ?>
      </p>
      <p>
<a href="source/http-signature-nonces">HTTP Signature Nonces</a>: An extension
to the HTTP Signatures specification that enables replay protection when 
messages are sent over a non-secured HTTP connection.
Time-stamped drafts: <?php dirContents("ED/http-signature-nonces"); ?>
      </p>
      <p>
<a href="source/http-signature-trailers">HTTP Signature Trailers</a>: An
extension to the HTTP Signatures specification that enables digital signatures
to be applied to content that is streamed, such as audio and video, via 
HTTP Trailers.
Time-stamped drafts: <?php dirContents("ED/http-signature-trailers"); ?>
      </p>
      <p>
<a href="source/ld-signatures">Linked Data Signatures</a>: An extensible
cryptographically verifiable messaging mechanism built using Linked Data 
principles to produce a distributed Public Key Infrastructure for the Web.
Time-stamped drafts: <?php dirContents("ED/ld-signatures"); ?>
      </p>
      <p>
<a href="source/vocabs/security.html">Security Vocabulary</a>: the Web vocabulary 
that is used to describe mechanisms for expressing digital signatures and 
encrypting and decrypting messages.
Time-stamped drafts: <?php dirContents("ED/vocabs/security"); ?>
      </p>
<a href="source/http-signatures-audit">Security Considerations for HTTP 
Signatures</a>: A complete security audit of the HTTP Signatures specification.
Time-stamped drafts: <?php dirContents("ED/http-signatures-audit"); ?>
      </p>
    </div><!-- col-lg-6 -->
  </div><!-- row -->
</div><!-- container -->
</section>

<!-- ==== ARCHIVES ==== -->
<section>
<div class="container" id="use-cases">
  <div class="row white">
  <br>
    <h1 class="centered">ARCHIVES</h1>
    <hr>
    <div class="col-lg-offset-1 col-lg-10">
      <p>
<a href="source/web-api">PaySwarm Web API</a>: The initial PaySwarm protocol 
designed to allow open listing, buying, and selling digital assets over the Web.
Time-stamped drafts: <?php dirContents("ED/web-api"); ?>
      </p>
    </div><!-- col-lg-6 -->
  </div><!-- row -->
</div><!-- container -->
</section>

<?php $TOP_DIR='..'; include '../footer.inc'; ?>

