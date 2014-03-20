<?php
/*=========================================================================
# Joomla 2.5 Template - Global Functions
# =========================================================================
# Author    TheCoders.vn
# Copyright Copyright (C) 2013 Thecoders.vn. All Rights Reserved.
# License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://thecoders.vn
# Live Demo: http://gatheme.com
# Technical Support:  Forum - http://laptrinhvien-vn.com
  =======================================================================*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class TCVNCommon
{
	/* Global variables */
	public $params			= NULL;
	public $template 		= NULL;	
	
	function __construct($template, $params)
	{
		$this->template = $template;
		$this->params 	= $params;
	}
	
	/* Set Cookie Value */
	function setCookie($name, $value) 
	{
		$expires = time() + 60 * 60 * 24 * 365;
		setcookie($this->template . $name, $value, $expires, "/", "");
	}
	
	/* Get Cookie Value */
	function getCookie($name)
	{
		return (isset($_COOKIE[$this->template . $name])) ? urldecode($_COOKIE[$this->template . $name]) : false;
	}
	
	
	/* Set Language Direction */
	function setDirection()
	{
		$direction = JRequest::getCmd('direction');
		
		if($direction != '') { 
			$this->setCookie('direction', $direction);
		}
		elseif($this->getCookie('direction') != false) {
			$this->setCookie('direction', $this->getCookie('direction'));
		}
		else {
			$this->setCookie('direction', $this->params->get('languageDirection', 'ltr'));
		}
		return true;
	}
	
	/* Get Language Direction */
	function getDirection()
	{
		return (JRequest::getCmd('direction') == 'rtl') ? '.rtl' : 
			   ((JRequest::getCmd('direction') == 'ltr') ? '' : 
			   ($this->getCookie('direction') == 'rtl') ? '.rtl' : '');
	}

	/* Set Preset Color */
	function setColor () 
	{
		$color = JRequest::getCmd('color');

		if($color != '') { 
			$this->setCookie('color', $color);
		}
		elseif($this->getCookie('color') != false) {
			$this->setCookie('color', $this->getCookie('color'));
		}
		else {
			$this->setCookie('color', $this->params->get('templatecolor'));
		}
	}

	/* Get Preset Color */
	function getColor ()
	{
		$color = JRequest::getCmd('color');
		return ($color != '') ? $color : 
			   (($this->getCookie('color')) ? $this->getCookie('color') : $this->params->get('templatecolor', 'blue'));
	}
}