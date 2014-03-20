<?php
/**
 * @version		$Id: mod_vm2icon.php 22338 2011-11-04 17:24:53Z github_bot $
 * @package		Joomla.Administrator
 * @subpackage	mod_vm2icon
 * @copyright	Copyright (C) 2005 - 2011 P. Kohl(Studio 42 France). All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

require_once dirname(__FILE__).'/helper.php';
$buttons = modVm2IconHelper::getButtons();
$isVendor = modVm2IconHelper::SuperVendor();
require JModuleHelper::getLayoutPath('mod_vm2icon', $params->get('layout', 'default'));
