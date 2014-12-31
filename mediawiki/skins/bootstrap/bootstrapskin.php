<?php
/**
 * Initialisation file for the BootStrapSkin
 *
 * BootStrapSkin is a skin built on top of a modified Vector theme from
 * MediaWiki and utilises Bootstrap 3.1.1 for base layout,
 * typography, and additional widgets.
 * 
 * @file
 * @ingroup Skins
 * @authors Lee Miller
 */

if( !defined( 'MEDIAWIKI' ) ) die( "This is an extension to the MediaWiki package and cannot be run standalone." );
 
$wgExtensionCredits['skin'][] = array(
        'path' => __FILE__,
        'name' => 'BootStrapSkin',
        'url' => "http://www.mediawikibootstrapskin.co.uk/",
        'author' => 'Lee Miller and [http://www.vanhamel.nl/wiki/Main_page Dennis Groenewegen]',
        'descriptionmsg' => 'bootstrapskin-desc',
		'version' => '1.0.43',
);

$wgValidSkinNames['bootstrapskin'] = 'Bootstrap';
$wgAutoloadClasses['SkinBootstrap'] = dirname(__FILE__).'/Bootstrapskin.skin.php';
$wgExtensionMessagesFiles['SkinBootstrap'] = dirname(__FILE__).'/Bootstrapskin.i18n.php';
 
$wgResourceModules['skins.bootstrapskin'] = array(
        'styles' => array(
		        'bootstrap/bootstrap/less/bootstrap.less' => array( 'media' => 'screen' ),
                'bootstrap/bootstrap/css/bootstrap-blue.css' => array( 'media' => 'screen' ),
                'bootstrap/screen.css' => array( 'media' => 'screen' ),
                'bootstrap/theme.css' => array( 'media' => 'screen' ),
				'bootstrap/bootstrap/css/jquery-ui.min.css' => array( 'media' => 'screen' ),
				'bootstrap/bootstrap/css/font.css' => array( 'media' => 'screen' ),
				'bootstrap/bootstrap/css/jquery-ui.min.css' => array( 'media' => 'screen' ),
				//'bootstrap/bootstrap/css/glyphicons.css' => array( 'media' => 'screen' ),
				//'bootstrap/bootstrap/css/fam-icons.css' => array( 'media' => 'screen' ),
                'bootstrap/bootstrap/css/typography.css' => array( 'media' => 'screen' ),
                'bootstrap/bootstrap/css/misc.css' => array( 'media' => 'screen' ),
                //'bootstrap/bootstrap/css/social-buttons.css' => array( 'media' => 'screen' ),
				//'bootstrap/bootstrap/css/prettify.css' => array( 'media' => 'screen' ),
	),

	'scripts' => array(
	    'bootstrap/bootstrap/js/jquery-ui.min.js',
		'bootstrap/bootstrap/js/bootstrap.js',
		'bootstrap/skin.js',
		'bootstrap/bootstrap/js/buttons.js',
        'bootstrap/bootstrap/js/portlets.js',
		'bootstrap/bootstrap/js/misc.js',
        'bootstrap/bootstrap/js/tab.js',
      //'bootstrap/bootstrap/js/run_prettify.js',	  
	),	
        'remoteBasePath' => &$GLOBALS['wgStylePath'],
        'localBasePath' => &$GLOBALS['wgStyleDirectory'],
);

# Default options to customise skin
$wgBootstrapSkinLogoLocation = 'bodycontent';
$wgBootstrapSkinLoginLocation = 'footer';
$wgBootstrapSkinAnonNavbar = true;
$wgBootstrapSkinUseStandardLayout = false;
$wgBootstrapSkinDisplaySidebarNavigation = false;
# Show print/export in navbar by default
$wgBootstrapSkinSidebarItemsInNavbar = array( 'coll-print_export' );

$wgFooterIcons['poweredby']['bootstrapskin'] = array(
	      "src" => "http://www.mediawikibootstrapskin.co.uk/images/BootStrapSkin_mediawiki_88x31.png",
	      "url" => "http://www.mediawikibootstrapskin.co.uk/",
	      "alt" => "Powered by BootStrapSkin",
          );
		  
$wgFooterIcons['poweredby']['youricon'] = array(
	      "src" => "", //url to your wiki logo
	      "url" => "", //url to your wiki
	      "alt" => "", //alt text
          );
