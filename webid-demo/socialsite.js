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
   var success = false;

   try
   {
      var output = JSON.parse(data);
      if(output.success)
      {
         //console.log('logged in', output);
         success = true;
      }
   }
   catch(ex)
   {
      // bad response
   }

   //console.log('success', success, data);
   if(!success)
   {
      // FIXME: show error text, invalid login
      $('#webid-frame').empty();
   }
   else
   {
      // set data in a cookie
      $.cookie('webid', escape(data), { secure: true });
      $.cookie('rdf', output.rdf, { secure: true });
      var url = 'https://payswarm.com/webid-demo/home.php';
      window.location = url;
   }
};
