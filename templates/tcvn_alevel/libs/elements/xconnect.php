<?php
/**
 * @package XConnect for Joomla! 2.5
 * @author http://Thecoders.vn
 * @copyright (C) 2011- Thecoders.vn
 * @license http://www.gnu.org/licenseses/gpl-2.0.html GNU/GPL
**/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.form.formfield');

$doc = JFactory::getDocument();
$doc->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js', 'text/javascript');
$doc->addScriptDeclaration('jQuery.noConflict();', 'text/javascript');
$doc->addScript(JURI::root(true).'/modules/mod_tcvn_instagram/assets/js/instagramGallery.js', 'text/javascript');
$doc->addStyleDeclaration('ul.adminformlist, ul.adminformlist li{overflow:hidden}', 'text/css');

class JFormFieldXConnect extends JFormField 
{
 
	protected $type = 'xconnect';
 
	public function getInput() 
	{
		return '<a id="connectbutton" href="javascript:void(0)"><span style="font-weight:bold; font-size:120%">Connect Instagram</span></a>';
	}
}