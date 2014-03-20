<?php // Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/**
 * MoWebSo Library
 *
 * The MoWebSo Is The Foundation For All MoWebSo Extensions
 *
 * @package 	    Backend / Library
 * @author 		    MoWebSo.com / Eugen Stranz
 * @copyright       (C) 2009 - 2013 ENYtheme e.K.
 * @license		    GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */

 
jimport('joomla.form.formfield');


class JFormFieldMoWebSo extends JFormField {
 
	protected $type = 'mowebso';
 
	
	// label, description, default, multiple and class
 
	public function getInput() {

		// Lets Load The Neccassary JS & CSS Files
		$mowebso = new Mowebso();
		
// 		// Add jQuery Library
// 		$mowebso->addjQueryLibrary('jQuery');
		
// 		// Add jQuery UI Library
// 		$mowebso->addjQueryLibrary('jQuery-UI');
		
// 		$mowebso->addElementsJsCss();
		
		
		return 'MoWebSo ist da ;-)';
	}
}