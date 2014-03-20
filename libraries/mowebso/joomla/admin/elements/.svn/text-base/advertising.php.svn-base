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


class JFormFieldAdvertising extends JFormField {

	protected $type = 'advertising';

	public function getInput() {

		// Include The MoWebSo Library
		jimport('mowebso.joomla.thirdparty.virtuemart');
		$mowebso = MoWebSoVirtuemart::getInstance();

		// Include CSS
		$mowebso->addElementsJsCss('stylesheet','advertising.css','libraries/mowebso/joomla/assets/css/elements/');

		// JPATH_LIBRARIES
		// $this->id
		// $this->element['name']
		// $this->value

		$html = '';
		return $html;
	}

	public function getLabel() {

		// Get The User Informations
		$user = JFactory::getUser();

		$html = '<br />';

		$html .= '<span class="welcome">';
		$html .= 'Hello '.$user->get('name');
		$html .= '</span>';

		$html .= '<span class="intro">';
		$html .= 'on our site you will find more useful extensions.';
		$html .= '</span>';

		$html .= '<span class="link">';
		$html .= '<a href="http://www.developing-and-design.com/" target="_blank" class="btn btn-success">';
		$html .= 'visit www.developing-and-design.com';
		$html .= '</a>';
		$html .= '</span>';

		$html .= '<span class="advertising-separator"></span>';

		return $html;
	}

}