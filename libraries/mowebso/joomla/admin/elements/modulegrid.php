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

class JFormFieldModulegrid extends JFormField {
 
	protected $type = 'modulegrid';

	public function getInput() {

		// Include The MoWebSo Library
		jimport('mowebso.joomla.thirdparty.virtuemart');
		$mowebso = MoWebSoVirtuemart::getInstance();
		
		// Include The Grid Structures.
		include JPATH_LIBRARIES.'/mowebso/core/features/grid12_structures.php';
		
		// Add jQuery Library
		$mowebso->addjQueryLibrary('jQuery');
		
		// Add jQuery UI Library
		$mowebso->addjQueryLibrary('jQuery-UI');
		
		$mowebso->addElementsJsCss();
		
		$mowebso->addElementsJsCss('stylesheet','jquery-ui-1.8.23.custom.css','libraries/mowebso/joomla/assets/css/elements/');
		
		// Add The Module Grid Plugin
		$mowebso->addElementsJsCss('script','modulegrid.js','libraries/mowebso/joomla/assets/js/elements/');
		
		// Get The Prepared Array With Module Grid Settings
		if(empty($this->value)) {
			$this->value = '1,1:12||1;,2:6,6||1;,3:4,4,4||1;,4:3,3,3,3||1;,5:2,3,2,3,2||1;,6:2,2,2,2,2,2||1;,7:2,2,2,1,1,2,2||1;,8:2,2,1,1,1,1,2,2||1;,9:2,1,1,1,2,1,1,1,2||1;,10:2,1,1,1,1,1,1,1,1,2||1;,11:2,1,1,1,1,1,1,1,1,1,1||1;,12:1,1,1,1,1,1,1,1,1,1,1,1||1;';
		}
		$preSavedGrid = $mowebso->prepareArrayForModuleGridSettings($this->value);

		$js = "
				jQuery(document).ready(function() {
					jQuery('div#field-".$this->id."').moduleGrid({
						gridStructures: ".json_encode($gridStructures).",
						grid: ".json_encode($grids).",
						preSavedGrid: ".json_encode($preSavedGrid)."
					});

				});	
			";
		$mowebso->addInlineScript($js);
		
		// Lets Define The Index For Modules Or Mainbody
		(!preg_match('/^mainbody/', $this->element['name'])) ? $index = 12 : $index = 4;
		
		$html = '';
		
		$html .=	'<div id="field-'.$this->id.'" class="modulegrid-container">';
		
		$html .=		'<ul class="grid-no">';
			
			for ($i = 1; $i <= $index; $i++) {
				$html .= '<li>'.$i.'</li>';
			}
	
		$html .=		'</ul>';
		
		$html .= 		'<div class="grid-blocks"></div>';
		
		$html .= 		'<div style="width:150px;" id="slider"></div>';
		
		$html .= 		'<input size="40" id="'.$this->id.'" name="'.$this->name.'" value="'. $this->value.'">';

		$html .= 	'<div class="clear"></div></div>';
		
		return $html;
	}
}