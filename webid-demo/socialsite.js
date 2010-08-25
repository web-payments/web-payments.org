/**
 * Digital Bazaar, Inc. Copyright (c) 2010
 */
$(document).ready(function()
{
   $('#button-other').click(function()
   {
      $('#provider-other').toggle();
   });

   $('#button-db').click(function()
   {
      webidLogin('http://webid.digitalbazaar.com');
   });

   $('#button-provider').click(function()
   {
      var provider = $('#provider-url')[0].value;
      webidLogin(provider);
   });
});

var webidLogin = function(url)
{
   url += '?domain=payswarm.com&auth=webid-demo/auth.php&redirect=webid-demo/redirect.html&pport=501';
   $('#webid-frame').html('<iframe id="webid-iframe" src="' + url + '"></iframe>');
};

window.authenticate = function(data)
{
   var output;

   try
   {
      output = JSON.parse(data);
      //console.log('logged in', output);
   }
   catch(ex)
   {
      // bad response, set error
      output = {
         success: false,
         error: 'Invalid response from server.',
         rdf: ''
      };
   }
   
   // set data in a cookie
   $.cookie('rdf', output.rdf, { secure: true });
   delete output.rdf;
   $.cookie('webid', escape(JSON.stringify(output)), { secure: true });
   
   // redirect
   var url = 'https://payswarm.com/webid-demo/home.php';
   window.location = url;
};
