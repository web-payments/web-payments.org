<?php
require_once('get_webid_rdf.inc');
require_once('check_public_key.inc');

$rval = array();
$rval['success'] = false;

// the user may have selected a browser-generated WebID...
// so grab that information here
$info = get_certificate_info();
if(!isset($rval['error']))
{
   // get the web ID rdf
   $rdf = get_webid_rdf($info['webID']);
   if($rdf === false)
   {
      $rval['error'] = 'Could not retrieve RDF from WebID url.';
   }
   // authenticate by checking public key
   else if(!check_public_key($rdf, $info['webID'], $info['publicKey']))
   {
      $rval['error'] = 'Public keys did not match.';
   }
   else
   {
      // set cert, web ID, and rdf
      $rval['success'] = true;
      $rval['cert'] = $info['cert'];
      $rval['webID'] = $info['webID'];
      $rval['rdf'] = $rdf;
   }
}
//print_r($rval);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
      <title>socialswarm</title>

      <link href="socialsite.css" rel="stylesheet" type="text/css" />

      <link rel="shortcut icon" href="favicon.ico" />

      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
      <script type="text/javascript" src="jquery.cookie.js"></script>
      <script type="text/javascript" src="socialsite.js"></script>
   </head>

   <body>
      <div id="container">
         <div id="header">
            <div class="col">
               <h1>socialswarm</h1>
            </div>
         </div>

         <div id="content">
            <div class="col">
               <div id="login">
                  <h2>Socialswarm Login</h2>
                  <div class="form">
                     <p>Select your demo WebID provider or Other to enter a provider.</p>

                     <div class="row">
                        <label>Provider</label>
                        <button id="button-db" class="provider">Digital Bazaar WebID</button>
                        <button id="button-other" class="provider">Other</button>
                     </div>

                     <div id="provider-other" class="row hidden">
                        <label for="provider-url">Address</label>
                        <input id="provider-url" class="form-input" type="text" />
                        <button id="button-provider" class="social">Go</button>
                     </div>
                     <p>Need a demo WebID? <a href="http://webid.digitalbazaar.com/manage">Create your demo WebID here</a>.</p>

                     <div id="webid-frame"></div>
                  </div>
               </div>
            </div>

            <div>
               <h3>About this site</h3>
               <p>This is a demo WebID-enabled website. It is meant to demonstrate that WebIDs can be generated
               using web-only technologies (JavaScript and Flash) without the assistance of a
               browser-specific UI. You must have a demo WebID, created by JavaScript and Flash, to be able to
               log into this website. A WebID created via your web browser is not appropriate for this demo.
               However, if you selected a valid WebID when you accessed this page you can display the RDF
               profile retrieved from its URI by clicking the link below. This demonstration purposely does not
               show the login page for browser-generated WebIDs to ensure that the viewers of this demo can
               select a web-generated WebID and witness how it works. A future demonstration may integrate
               both browser-generated and web-generated WebIDs.

               <p>This demo also does not read RDF information from your WebID or perform any of the other
               functions that have already been demonstrated by other WebID technologies. This demo merely
               shows that WebIDs can be generated and put to use with client-side web-only technologies -- the
               rest of the WebID stack (ie: the server-side) is unchanged and already proven.</p>

               <p>If you would like to learn more about this technology demo,
               <a href="http://blog.digitalbazaar.com/2010/08/07/webid/2/#demo">WebID and Universal Login
               for the Web</a> is a good place to start.</p>
            </div>
            <div>
               <h3>A Note Concerning Browser-Generated WebIDs</h3>
               <p>The purpose of is demonstration is to show that WebIDs can be generated using a web-only
               interface. This demonstration does not show the full potential of WebID, it only demonstrates
               that any barriers to creating and selecting a WebID via browser-interfaces have been overcome.
               This approach also helps eliminate any issues with viewers of the demo who are unfamiliar with
               WebID selecting non-WebID client-side certificates and then being confused as to what went
               wrong.</p>
               <p>However, those already familiar with WebID and browser-interfaces might like to see that their
               browser-generated WebIDs are still functional here. They can view the RDF profile they have
               stored at their WebID URL. This RDF profile allows a WebID to specify all kinds of information
               about a WebID owner's identity, permitting them to control access to their identity in a single,
               convenient, and global location.</p>
               <p>
               <?php if($rval['success'] === true) { echo 'This page has detected that you selected a valid '.
               'WebID using your web browser\'s interface. '.
               'To view your <a href="" onclick="$(\'#rdf\').toggle(); return false;">related RDF profile '.
               'click here</a>.'; } else { echo 'This page has not detected that you selected a valid WebID ' .
               'using your web browser\'s interface, so there is no profile information to display.'; }?>
               </p>
            </div>

            <div id="rdf" class="hidden">
               <pre><?php if($rval['success'] === true) echo htmlspecialchars($rval['rdf']); ?></pre>
            </div>

            <div class="clear"></div>
         </div>

         <div id="footer">
            <p id="copyright">
               Digital Bazaar, Inc. &#169; 2010
           </p>
            <p id="legal">
               Part of the <a href="http://payswarm.com/">payswarm.com</a> initiative.
            </p>
         </div>
      </div>
   </body>
</html>
