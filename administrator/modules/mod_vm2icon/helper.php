<?php
/**
 * @version		$Id: helper.php 1.0 2012-09-28
 * @package		mod_vm2icon
 * @copyright	Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * @package		mod_vm2icon
 */
abstract class modVm2IconHelper
{
	/**
	 * Stack to hold default buttons
	 *
	 * @since	1.6
	 */
	protected static $buttons = array();

	/**
	 * Helper method to test VM2 vendor permissions
	 * @since	1.6
	 */
	public static function SuperVendor()
	{
		if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
		VmConfig::loadConfig();
		if(!class_exists('Permissions')) require(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'permissions.php');
		return Permissions::getInstance()->isSuperVendor();
	}

	/**
	 * Helper method to return button list.
	 *
	 * This method returns the array by reference so it can be
	 * used to add custom buttons or remove default ones.
	 *
	 * @return	array	An array of buttons
	 * @since	1.6
	 */
	public static function &getButtons()
	{

		if (empty(self::$buttons)) {
			self::SuperVendor();
			// Load mod_vm2icon language file in case this method is called before rendering the module
			JFactory::getLanguage()->load('com_virtuemart');

			self::$buttons = array(
				'virtuemart'=>
				array(
					'link' => JRoute::_('index.php?option=com_virtuemart'),
					'image' => 'vm_store_48',
					'text' => JText::_('COM_VIRTUEMART'),
					'vendor' => true
				),
				'category' =>
				array(
					'link' => JRoute::_('index.php?option=com_virtuemart&view=category'),
					'image' => 'vm_shop_categories_48',
					'text' => JText::_('COM_VIRTUEMART_CATEGORY_S'),
					'vendor' => true
				),
				'product' =>
				array(
					'link' => JRoute::_('index.php?option=com_virtuemart&view=product'),
					'image' => 'vm_shop_products_48',
					'text' => JText::_('COM_VIRTUEMART_PRODUCT_S'),
					'vendor' => true
				),
				'ratings' =>
				array(
					'link' => JRoute::_('index.php?option=com_virtuemart&view=ratings'),
					'image' => 'vm_ratings_48',
					'text' => JText::_('COM_VIRTUEMART_RATINGS'),
					'vendor' => true
				),
				'inventory' =>
				array(
					'link' => JRoute::_('index.php?option=com_virtuemart&view=inventory'),
					'image' => 'vm_inventory_48',
					'text' => JText::_('COM_VIRTUEMART_PRODUCT_INVENTORY'),
					'vendor' => true
				),
				'orders' =>
				array(
					'link' => JRoute::_('index.php?option=com_virtuemart&view=orders'),
					'image' => 'vm_shop_orders_48',
					'text' => JText::_('COM_VIRTUEMART_ORDER_S'),
					'vendor' => true
				),
				'report' =>
				array(
					'link' => JRoute::_('index.php?option=com_virtuemart&view=report'),
					'image' => 'vm_report_48',
					'text' => JText::_('COM_VIRTUEMART_REPORT'),
					'vendor' => true
				),
				'user' =>
				array(
					'link' => JRoute::_('index.php?option=com_virtuemart&view=user'),
					'image' => 'vm_shop_users_48',
					'text' => JText::_('COM_VIRTUEMART_USER_S'),
					'vendor' => true
				),
				'config' =>
				array(
					'link' => JRoute::_('index.php?option=com_virtuemart&view=config'),
					'image' => 'vm_shop_configuration_48',
					'text' => JText::_('COM_VIRTUEMART_CONFIG'),
					'vendor' => true
				),
				'editshop' =>
				array(
					'link' => JRoute::_('index.php?option=com_virtuemart&view=user&task=editshop'),
					'image' => 'vm_shop_mart_48',
					'text' => JText::_('COM_VIRTUEMART_STORE'),
					'vendor' => true
				),
				'vmg' =>
				array(
					'link' => JRoute::_('index.php?option=com_vmg_export'),
					'image' => 'st42_vmg_48',
					'text' => 'Google Export',
					'vendor' => true
				),
				'translator' =>
				array(
					'link' => JRoute::_('index.php?option=com_vm_fast_translator'),
					'image' => 'st42_translator_48',
					'text' => 'Translator',
					'vendor' => true
				),
				'documentation' =>
				array(
					'link' => JRoute::_('http://virtuemart.org/index.php?option=com_content&amp;task=view&amp;id=248&amp;Itemid=125'),
					'image' => 'vm_shop_help_48',
					'text' => JText::_('COM_VIRTUEMART_DOCUMENTATION'),
					'vendor' => false
				),
				'forum' =>
				array(
					'link' => 'http://forum.virtuemart.net/',
					'image' => 'vm_usergroup_48',
					'text' => JText::_('COM_VIRTUEMART_COMMUNITY_FORUM'),
					'vendor' => false
				),
				'website' =>
				array(
					'link' => 'http://www.virtuemart.net/',
					'image' => 'vm_virtuemart_48',
					'text' => 'Virtuemart 2',
					'vendor' => false
				),
				'extention' =>
				array(
					'link' => 'http://extensions.virtuemart.net/',
					'image' => 'vm_extension_48',
					'text' => 'VM2 Extensions',
					'vendor' => false
				),
				'studio42' =>
				array(
					'link' => 'http://www.st42.fr/',
					'image' => 'st42_48',
					'text' => '<b>Visit <b>Studio42</b></b>',
					'vendor' => false
				)
			);
		}

		return self::$buttons;
	}
}
