<?php
/**
 * Chick: A lightweight Monobook skin with no sidebar, the sidebar links are
 * given at the bottom of the page instead, as in the unstyled MySkin.
 *
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/** */
require_once( dirname(__FILE__) . '/MonoBook.php' );

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @ingroup Skins
 */
class SkinPaySwarm extends SkinTemplate {
	var $skinname = 'payswarm', $stylename = 'payswarm',
	$template = 'MonoBookTemplate', $useHeadElement = true;

	function setupSkinUserCss( OutputPage $out ){
		parent::setupSkinUserCss( $out );
		// Append to the default screen common & print styles...
		$out->addStyle( 'payswarm/main.css', 'screen,handheld' );
	}
}

