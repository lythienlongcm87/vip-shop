<?php // no direct access
defined('_JEXEC') or die;

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


class Mowebso {

	// Instance
	protected static $_instance;
	
	// Site Elements
	var $document;
	var $language;
	var $shortLanguageString;
	var $facebookLanguageCode;
	var $direction;
	var $templateName;
	var $templatePath;
	var $supportedTemplate;
	var $themeName;
	
	// Modules
	var $modulePositionAdditives    = array('-a','-b','-c','-d','-e','-f','-g','-h','-i','-j','-k','-l');
	var $activeModuleAdditives      = array();
	var $modulePositionGridNo       = array();
	
	// Browser Information
	var $name;
	var $version;
	var $shortVersion;
	var $platform;
	var $engine;
	var $_checks                    = array ();

	/**
	 * Create An Instance of MoWebSo Class If It Does Not Exist Already
	 * @return Mowebso
	 */
	public static function getInstance() {
		if (!isset(self::$_instance)) {
			self::$_instance = new Mowebso();
		}
		return self::$_instance;
	}

	/**
	 * Construct Method
	 *
	 * Is Called Automatically After Class Was Initialised
	 */
	function __construct() {
		
		// Get & Set The Document
		$doc = JFactory::getDocument();
		$this->document = $doc;

		// Load And Set The Current Language
		$this->setLanguage ();

		// Load And Set The Current Page Direction
		$this->getDirection ();

		// Load And Set The Current Template Name
		$this->getCurrentTemplateName ();

		// Check If We Run A Template Supported By Us
		$this->isItASupportedMoWebSoTemplate();

		// Load And Set The Browser informations
		$this->getBrowserInformations ();

	}

	/**
	 * Set The Current Page Language
	 *
	 * Also Forms Language Tags For Facebook
	 */
	function setLanguage() {
		$this->language = $this->document->language;

		// Lets Define The Short Version before the '-' Character For SEO
		$shortLanguageCode = preg_replace('#[-].*#', '',  $this->language);
		$this->shortLanguageString = $shortLanguageCode;

		// Lets Form The Language Code To Match the Facebook Syntax
		$facebookLanguageCode = $this->shortLanguageString.'_'.strtoupper(preg_replace('#..[-]#', '',  $this->language));
		$this->facebookLanguageCode = $facebookLanguageCode;
	}

	/**
	 * Set The Current Page Direction
	 */
	function getDirection() {
		$this->direction = $this->document->direction;
	}

	/**
	 * Set The Current Template Name And Path
	 */
	function getCurrentTemplateName() {
		$doc = JFactory::getApplication ();
		$this->templateName = $doc->getTemplate ();

		// Set The Template Path
		$this->templatePath = JPATH_ROOT . '/templates/' . $this->templateName;

	}

	/**
	 * Count Modules
	 *
	 * Counts The Module Of A Specific Position
	 * @param $shortModuleName
	 * @return bool|string
	 */
	function countModules($shortModuleName) {
		
		// Cancel This Function In The Joomla Administration Area
		$app = JFactory::getApplication();
		if(!$app->isAdmin()) {
		
			$this->activeModuleAdditives = array();

			foreach ($this->modulePositionAdditives as $modulePositionAdditive) {
				$countModules = $this->document->countModules($shortModuleName.$modulePositionAdditive);
				if($countModules != 0) {
					$this->activeModuleAdditives[] = $shortModuleName.$modulePositionAdditive;
				}
			}

			$this->modulePositionGridNo[] = array($shortModuleName => count($this->activeModuleAdditives));

			if (!empty($this->activeModuleAdditives)) {
				return TRUE;
			} else {
				return FALSE;
			}

		} else {
			return '';
		}
		
	}

	/**
	 * MoWebSo Support Prove
	 *
	 * Proves If The Current Template Is A Supported Template By MoWebSo
	 * Also Sets ThemeName
	 *
	 * @return boolean
	 */
	function isItASupportedMoWebSoTemplate() {

		// This are our arrays we have to enhance for future templates

		// The MoWebSo Template Portfolio
		$mowebsoTemplates = array ('shoplicious' );

		// 1. Check If It Is A MoWebSo Template
		if(in_array ( $this->templateName, $mowebsoTemplates )) {
			$this->supportedTemplate = true;
			$this->themeName = $this->templateName;
			return true;
		} else {
			$this->supportedTemplate = false;
			$this->themeName = 'default';
			return false;
		}
	}

	/**
	 * Get And Set The Browser And Platform Information
	 */
	function getBrowserInformations() {

		// Include The Browser Class
		jimport ( 'mowebso.core.mowebsobrowser' );
		$browser = mowebsobrowser::getInstance();

		// Set The Variables
		$this->name         = $browser->name;
		$this->version      = $browser->version;
		$this->shortVersion = $browser->shortversion;
		$this->platform     = $browser->platform;
		$this->engine       = $browser->engine;
		$this->_checks      = $browser->_checks;

		return true;
	}

	/**
	 * Output: Mainbody
	 *
	 * This Method Prepares The Output For Mainbody
	 * With The Right Grid Structure
	 *
	 * @param string $style
	 * @param string $type
	 * @return string
	 */
	function displayMainbody($style='standard',$type='mainbody') {
		
		if($this->countModules('sidebar')) {

			// Include The Modules Class
			jimport ( 'mowebso.joomla.layouts.mowebsomodules' );

			$mowebsoModules = MowebsoModules::getInstance();
			$displayMainbody = $mowebsoModules->displayModules($this->activeModuleAdditives,$style,$type);
			
			return $displayMainbody;
				
		} else if ($this->document->params->get('showmainbody', 1) && !$this->countModules('sidebar')) {
			
			// Include The Mowebso Mainbody Class
			jimport ( 'mowebso.joomla.layouts..mowebsomainbody' );
			
			$displayMainbody = MowebsoMainbody::getInstance();
			$displayMainbody = $displayMainbody->displayMainbody(12);
			
			return $displayMainbody;

		} else {
			return '';
		}
	}

	/**
	 * Output: Modules
	 *
	 * This Method Prepares The Output For Modules
	 * With The Right Grid Structure
	 *
	 * @param $shortModuleName
	 * @param string $style
	 * @param string $type
	 * @return string
	 */
	function displayModules($shortModuleName,$style='standard',$type='modules') {
		
		if($this->countModules($shortModuleName)) {

			// Include The Modules Class
			jimport ( 'mowebso.joomla.layouts.mowebsomodules' );

			$mowebsoModules = MowebsoModules::getInstance();
			$displayModules = $mowebsoModules->displayModules($this->activeModuleAdditives,$style,$type);

			return $displayModules;

		} else {
			return '';
		}

	}

	/**
	 * Prepare Array For Module Grid Output
	 *
	 * @param $value
	 * @return array
	 */
	function prepareArrayForModuleGridSettings($value) {
	
		// Prepare The Array Of Last Saved Value
		$preSavedGrid = array();
	
		$preSavedGrid['start'] = substr($value, 0, 1);
	
		// Lets Define The Start Index
		$preSavedValues = explode(';', substr($value, 2));
	
		// Lets Define Slider Value
		$i = 1;
		$gridarrays = array();
		foreach ($preSavedValues as $preSavedValue) {
			$splittedPreSavedValues = explode('||', $preSavedValue);
			if(!empty($splittedPreSavedValues[1])) {
				$preSavedGrid['slider'][$i] = $splittedPreSavedValues[1];
			}
			$gridarrays[$i] = $splittedPreSavedValues[0];
			$i++;
		}
	
		// Lets Get The Grid Structure Values
		$i = 1;
		$gridVariants = array();
		foreach ($gridarrays as $gridarray) {
			$splittedPreSavedValues = explode(':', $gridarray);
			if(!empty($splittedPreSavedValues[1])) {
				$gridVariants[$i] = $splittedPreSavedValues[1];
			}
			$i++;
		}
	
		// Lets Assign The Grid Values To The Right Index And Finish it ;-)
		$i = 1;
		foreach ($gridVariants as $gridStrcuture) {
	
			$splittedGrid = explode(',', $gridStrcuture);
			$preSavedGrid[$i] = $splittedGrid;
			$i++;
		}
	
		return $preSavedGrid;
	}

	/**
	 * Output The Neccassary Joomla Head
	 */
	public function displayHead() {
		echo '<jdoc:include type="head" />';

		// TODO ADD A Settings To Load The Meta Tag or Not For Responsive Design
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
	}

	/**
	 * Add StyleSheet:
	 *
	 * Lets Load CSS File And Also Browser Specific One If Available
	 *
	 * @param $file
	 * @param string $path
	 * @return bool|void
	 */
	public function addStyleSheet($file, $path = '', $browserSpecific=false) {

		$filename = str_replace ( '.css', '', $file );
		$savedPath = (! empty ( $path )) ? JURI::base () . $path : JURI::base () . 'templates/' . $this->templateName . '/assets/css/';
		$path = (! empty ( $path )) ? JPATH_ROOT . '/' . $path : JPATH_ROOT . '/templates/' . $this->templateName . '/assets/css/';

		// If We Should Check For browser Soecific Files
		if($browserSpecific) {
			$checkFiles = $this->getChecks ( $file, $path );
			$checks = $this->_checks;
			jimport ( 'joomla.filesystem.file' );

			$i = 0;
			foreach ( $checkFiles as $checkFile ) {
				if (JFile::exists ( $checkFile )) {
					$this->document->addStyleSheet ( $savedPath . $filename . $checks [$i] . '.css', 'text/css' );
				}
				$i ++;
			}
		} else {

			// No Browser Spcific Files - Just One
			$this->document->addStyleSheet ($savedPath . $file);
		}

		return true;
	}
	
	/**
	 * Add StyleSheets:
	 * Lets Load CSS File And Also Browser Specific One If Available
	 *
	 * @param $files
	 * @param string $path
	 */
	function addStyleSheets($files, $path = '') {
		foreach ( $files as $file )
			$this->addStyleSheet ( $file, $path );
	}

	/**
	 * Add Script:
	 * Lets Load JavaScript File And Also Browser Specific One If Available
	 * @param $file
	 * @param string $path
	 * @param string $mime
	 * @param bool $defer
	 * @param bool $async
	 * @param string $type
	 * @return bool|void
	 */
	function addScript($file, $path = '', $browserSpecific=false, $mime = 'text/javascript', $defer = false, $async = false, $type = 'js') {

		$filename = str_replace ( '.' . $type, '', $file );
		$savedPath = (! empty ( $path )) ? JURI::base () . $path : JURI::base () . 'templates/' . $this->templateName . '/assets/js/';
		$path = (! empty ( $path )) ? JPATH_ROOT . '/' . $path : JPATH_ROOT . '/templates/' . $this->templateName . '/assets/js/';

		// If We Should Check For browser Soecific Files
		if($browserSpecific) {

			$checkFiles = $this->getChecks ( $file, $path );
			$checks = $this->_checks;

			jimport ( 'joomla.filesystem.file' );

			$i = 0;
			foreach ( $checkFiles as $checkFile ) {
				if (JFile::exists ( $checkFile )) {
					$this->document->addScript ( $savedPath . $filename . $checks [$i] . '.' . $type, $mime, $defer, $async );
				}
				$i ++;
			}
		} else {

			// No Browser Spcific Files - Just One
			$this->document->addScript ($savedPath . $file, $mime, $defer, $async );
		}

		return true;
	}
	
	/**
	 * Add Scripts:
	 * Lets Load JavaScript File And Also Browser Specific One If Available
	 *
	 * @param $files
	 * @param string $path
	 * @param string $mime
	 * @param bool $defer
	 * @param bool $async
	 * @param string $type
	 */
	function addScripts($files, $path = '', $mime = 'text/javascript', $defer = false, $async = false, $type = 'js') {
		foreach ( $files as $file )
			$this->addScript ( $file, $path, $mime, $defer, $async, $type );
	}
	
	/**
	 * Adds Inline Javascript To The Head Area
	 *
	 * @param string $js        	
	 * @param string $type        	
	 */
	function addInlineScript($js, $type = 'text/javascript') {
		$this->document->addScriptDeclaration ( $js, $type );
	}
	
	/**
	 * Adds Inline Styles To The Head Area
	 *
	 * @param $css
	 * @param string $type
	 */
	function addInlineStyle($css, $type = 'text/css') {
		$this->document->addStyleDeclaration ( $css, $type );
	}
	
	/**
	 * Add External Libraries
	 *
	 * @param $url
	 * @param string $mime
	 * @param bool $defer
	 * @param bool $async
	 */
	function addExtLibrary($url, $mime = 'text/javascript', $defer = false, $async = false) {
		$this->document->addScript ( $url, $mime, $defer, $async );
	}
	
	/**
	 * Load The jQuery Library From The Google Api
	 *
	 * @param string $jquery
	 * @param string $mime
	 * @param bool $defer
	 * @param bool $async
	 */
	function addjQueryLibrary($jquery='jQuery', $mime = 'text/javascript', $defer = false, $async = false) {	
		
		if($jquery == 'jQuery') {
			$url = '//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js';
			$this->document->addScript ( $url, $mime, $defer, $async );
		} else if($jquery == 'jQuery-UI') {
			$url = '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js';
			$this->document->addScript ( $url, $mime, $defer, $async );
		}
	}

	/**
	 * Load CSS And JS Files For Elements
	 * @param string $type
	 * @param string $fileName
	 * @param string $path
	 */
	function addElementsJsCss($type='stylesheet',$fileName='tmpl_elements.css',$path='libraries/mowebso/joomla/assets/css/elements/') {
		JHTML::_($type, $fileName, $path);
	}
	
	/**
	 * Get The Joomla Head
	 */
	function getHeadData() {
		return $this->document->getHeadData ();
	}
	
	/**
	 * This Function Can Modify / Unset Elements From The HeadData
	 */
	function modifyHead($task = 'unset', $scripts = '', $inlineScripts = '') {
		// TODO
	}
	
	/**
	 *
	 * @version 3.2.19 April 2, 2012
	 * @author RocketTheme http://www.rockettheme.com
	 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
	 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
	 */
	function getChecks($file, $checkPath = '') {
		$checkfiles = array ();
		$ext = substr ( $file, strrpos ( $file, '.' ) );
		$path = (! empty ( $checkPath )) ? $checkPath : dirname ( $file ) . DS;
		$filename = basename ( $file, $ext );
		foreach ( $this->_checks as $suffix ) {
			$checkfiles [] = $path . $filename . $suffix . $ext;
		}

		return $checkfiles;
	}
}