<?php
/**
 *
 * Layout for the order email
 * shows the chosen adresses of the shopper
 * taken from the stored order
 *
 * @package	VirtueMart
 * @subpackage Order
 * @author Max Milbers,   Valerie Isaksen
 *
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
defined('_JEXEC') or die('Restricted access');
?>
<div style="font-weight: bold; font-size: 18px; line-height: 24px; color: #D03C0F; border-top: 1px solid #ddd; padding-bottom:10px;">
<br>
<?php echo JText::_('EXTRA_SHOPPER_ADDRESS'); ?>
</div>
<table border="0" cellpadding="0" cellspacing="0" class="columns-container">
  <tr>
    <td class="force-col" style="padding-right: 20px;" valign="top">

        <!-- ### COLUMN 1 ### -->
        <table border="0" cellspacing="0" cellpadding="0" width="260" align="left" class="col-2">
        <tr>
            <td align="left" valign="top" style="font-size:13px; line-height: 20px; font-family: Arial, sans-serif;">
                <strong><?php echo JText::_('COM_VIRTUEMART_USER_FORM_BILLTO_LBL'); ?></strong>
                <br>
                 <?php

	    foreach ($this->userfields['fields'] as $field) {
        //modify by Eddy for don't display some field in order email
		if (!empty($field['value']) && $field['name'] !='newsletter' && $field['name'] !='gender'  && $field['name'] !='birthday' && $field['name'] !='virtuemart_country_id') {
			?><!-- span class="titles"><?php echo $field['title'] ?></span -->
	    	    <span class="values vm2<?php echo '-' . $field['name'] ?>" ><?php echo $this->escape($field['value']) ?></span>
			<?php if ($field['name'] != 'title' and $field['name'] != 'first_name' and $field['name'] != 'middle_name' and $field['name'] != 'zip') { ?>
			    <br class="clear" />
			    <?php
			}
		    }
		 
	    }
	    ?>
	    <br>
            </td>
        </tr>
        </table>

    </td>
    <td class="force-col"  valign="top">

        <!-- ### COLUMN 2 ### -->
        <table border="0" cellspacing="0" cellpadding="0" width="260" align="right" class="col-2" id="last-col-2">
            <tr>
                <td align="left" valign="top" style="font-size:13px; line-height: 20px; font-family: Arial, sans-serif;">
                    <strong><?php echo JText::_('COM_VIRTUEMART_USER_FORM_SHIPTO_LBL'); ?></strong>
                    <br>
                   <?php
	    foreach ($this->shipmentfields['fields'] as $field) {

		if (!empty($field['value'])) {
			    ?><!-- span class="titles"><?php echo $field['title'] ?></span -->
			    <span class="values vm2<?php echo '-' . $field['name'] ?>" ><?php echo $this->escape($field['value']) ?></span>
			    <?php if ($field['name'] != 'title' and $field['name'] != 'first_name' and $field['name'] != 'middle_name' and $field['name'] != 'zip') { ?>
		    	    <br class="clear" />
				<?php
			    }
			}
	    }

	    ?>
	     <br>
                </td>
            </tr>
        </table>

    </td>
  </tr>
  
  
</table><!--/ end .columns-container-->


