<?php
/**
 *
 * Define here the Header for order mail success !
 *
 * @package    VirtueMart
 * @subpackage Cart
 * @author Kohl Patrick
 * @author Valérie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 */
// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');
/* TODO Change the header place in helper or assets ??? */
?>
<div>
			<img src="<?php  echo JURI::root () . $this->vendor->images[0]->file_url ?>" />
<br>
			<h1><?php echo JText::sprintf ('COM_VIRTUEMART_MAIL_SHOPPER_NAME',  $this->orderDetails['details']['BT']->first_name . ' ' . $this->orderDetails['details']['BT']->last_name); ?></h1><br/>
<br>
</div>
