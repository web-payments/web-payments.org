	<div class="buttons-whitespace-social text-center">
    <a href="http://www.twitter.com/share?url=http://www.mediawikibootstrapskin.co.uk/&amp;text=Mediawiki%20BootStrap%20Skin" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;"><button type="button" class="btn btn-cyanide btn-social"><i class="fa fa-twitter-square"></i></button></a>
	
    <a href="https://www.facebook.com/sharer/sharer.php?u=http://www.mediawikibootstrapskin.co.uk/" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;"><button type="button" class="btn btn-info btn-social"><i class="fa fa-facebook-square"></i></button></a>
	
	<a href="https://plus.google.com/share?url=http://www.mediawikibootstrapskin.co.uk/" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;"><button type="button" class="btn btn-berry btn-social"><i class="fa fa-google-plus-square"></i></button></a>
	
    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=http://www.mediawikibootstrapskin.co.uk/&amp;title=Mediawiki%20BootStrap%20|Skin&amp;summary=Mediawiki%20BootStrap%20Skin&amp;source=http://www.mediawikibootstrapskin.co.uk/" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;"><button type="button" class="btn btn-cyanide btn-social"><i class="fa fa-linkedin-square"></i></button></a>
	
	
    <a href="http://www.tumblr.com/share?v=3&amp;u=http%3A//www.mediawikibootstrapskin.co.uk/" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;"><button type="button" class="btn btn-info btn-social"><i class="fa fa-tumblr-square"></i></button></a>	
    </div>
	
	<div id="footer" class="footer container-fluid"<?php $this->html( 'userlangattributes' ) ?>>
    <div class="row">
	<?php
      $footerLinks = $this->getFooterLinks();

      if (is_array($footerLinks)) {
        foreach($footerLinks as $category => $links ):
          if ($category === 'info') { continue; } ?>

            <ul id="footer-<?php echo $category ?>">
              <?php foreach( $links as $link ): ?>
                <li id="footer-<?php echo $category ?>-<?php echo $link ?>"><?php $this->html( $link ) ?></li>
              <?php endforeach; ?>
              <?php
                if ($category === 'places') {

                  # Show sign in link, if not signed in
                  if ($wgBootstrapSkinLoginLocation == 'footer' && !$this->data['loggedin']) {
                    $personalTemp = $this->getPersonalTools();

                    if (isset($personalTemp['login'])) {
                      $loginType = 'login';
                    } else {
                      $loginType = 'anonlogin';
                    }

                    ?><li id="pt-login"><a href="<?php echo $personalTemp[$loginType]['links'][0]['href'] ?>"><?php echo $personalTemp[$loginType]['links'][0]['text']; ?></a></li><?php
                  }

                  # Show the search in footer to all
                  if ($wgSearchPlacement['footer']) {
                    echo '<li>';
                    $this->renderNavigation( array( 'SEARCHFOOTER' ) ); 
                    echo '</li>';
                  }
                }
              ?>
            </ul>
          <?php 
              endforeach; 
            }
          ?>
	</div>
	</div>	
	
    <footer>
      <ul id="footer-icons" class="noprint text-center">
        <li id="footer-poweredbyico">
        <a href="//www.mediawiki.org/">
          <img src="http://www.mediawikibootstrapskin.co.uk//skins/common/images/poweredby_mediawiki_88x31.png"
          alt="Powered by MediaWiki" height="31" width="88" />
        </a> 
        <a href="http://www.mediawikibootstrapskin.co.uk/">
          <img src="http://www.mediawikibootstrapskin.co.uk/images/BootStrapSkin_mediawiki_88x31.png"
          alt="Powered by BootStrapSkin" height="31" width="88" />
        </a>
      </ul>
      <p class="text-center no-margins push-up">
      <a href="#" class="color-hover-white">Your Wiki Name</a> &copy; All Rights Reserved</p>
    </footer>