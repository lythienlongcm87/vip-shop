<?php
# =========================================================================
# Joomla 2.5 Template - Global Variables
# =========================================================================
# Author    TheCoders.vn
# Copyright Copyright (C) 2013 Thecoders.vn. All Rights Reserved.
# License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://thecoders.vn
# Live Demo: http://gatheme.com
# Technical Support:  Forum - http://laptrinhvien-vn.com
/*========================================================================*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$app  		= JFactory::getApplication();
$menu 		= $app->getMenu();
$active 	= $menu->getActive();
$params 	= $menu->getParams($active->id);
$classSfx 	= $params->get('pageclass_sfx');

// Get params
/*=========================================================================*/

$logo               = $this->params->get('logo');
$siteTitle          = $this->params->get('siteTitle');
$siteDescription    = $this->params->get('siteDescription');
$loadjquery         = $this->params->get('loadjquery');
$logoWidth          = $this->params->get('logoWidth');
$customcss	        = $this->params->get('customcss');
$container			= $this->params->get('templateWidth');
$columnwidth		= $this->params->get('columnWidth');
$menutop            = 12 - $logoWidth;
$usercolor          = $this->params->get('usercolor');
$backtotop          = $this->params->get('backtotop');
$mainbody = '';

if($this->countModules('left') && $this->countModules('right'))  $mainbody = 'span' . (12 - 2*$columnwidth);
elseif ($this->countModules('left') || $this->countModules('right')) $mainbody = 'span' . (12 - $columnwidth);
else $mainbody = 'span12';

if($container == 1){
   $container = "container-fluid";
   $row       = "row-fluid";
}
else{
    $container = "container";
    $row       = "row";
}
// Common +
/*============================================================================*/
$tcvn = new TCVNCommon($this->template, $this->params);

// Language Direction 
$tcvn->setDirection();
$direction = $tcvn->getDirection();

// Preset Color
$tcvn->setColor();
$color = $tcvn->getColor();