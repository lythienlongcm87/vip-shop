<?php
/*=========================================================================
# Joomla 2.5 Template - Groups
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

/* Group module positions / users */
# Count user from 1 to 3
$user12= 'span';
$sumModules = 0;
for($i = 1; $i <= 2; $i++) {
    if($this->countModules('user-' . $i) > 0) $sumModules += 1;
}
$user12 .= ($sumModules != 0) ? 12/$sumModules : 12;
# Count position from 1 to 3

$position13= 'span';
$sumModules = 0;

for($i = 1; $i <= 3; $i++) {
	if($this->countModules('position-' . $i) > 0) $sumModules += 1;
}

$position13 .= ($sumModules != 0) ? 12/$sumModules : 12;


# Count position from 5 to 6
$position56 = 'span';
$sumModules  = 0;

for($i = 5; $i <= 6; $i++) {
	if($this->countModules('position-' . $i) > 0) $sumModules += 1;
}

$position56.= ($sumModules != 0) ? 12/$sumModules : 12;



# Count position from 8 to 10
$position810= 'span';
$sumModules = 0;

for($i = 8; $i <= 10; $i++) {
    if($this->countModules('position-' . $i) > 0) $sumModules += 1;
}

$position810 .= ($sumModules != 0) ? 12/$sumModules : 12;