<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'BootStrapSkinContact',
	'author' => array(
		'[http://www.mediawikibootstrapskin.co.uk Lee Miller]',
	),
	'descriptionmsg' => 'contact-desc',
	'url' => 'http://www.mediawikibootstrapskin.co.uk',
);

$wgExtensionMessagesFiles['BootStrapSkinContact'] = __DIR__ . '/BootStrapSkinContact.i18n.php';

$wgResourceModules['ext.BootStrapSkinContact'] = array(
	'scripts' => array('modules/ext.validate.js','modules/ext.form.js','modules/ext.placeholder.js'),
	'styles' => array('modules/ext.vector.css','modules/ext.forms.css'),
 
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'BootStrapSKinContact',
	
);

$wgAutoloadClasses[ 'SpecialContact' ] = __DIR__ . '/SpecialContact.php';
$wgSpecialPages[ 'SpecialContact' ] = 'SpecialContact';
$wgExtensionMessagesFiles[ 'SpecialContact' ] = __DIR__ . '/BootStrapSkinContact.alias.php';

