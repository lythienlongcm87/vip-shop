<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_relatedproducts.php 6431 2012-09-12 12:31:31Z alatak $
 */

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );
?>
    <div class="product-related-products">
    	<h4><?php echo JText::_('COM_VIRTUEMART_RELATED_PRODUCTS'); ?></h4>
		<?php 	
				$row = 'span';	
				$related_products = count($this->product->customfieldsRelatedProducts);
				if ($related_products <4){
					$row .= 12/$related_products;
 				}
				else{
					$row .= 3;
				}
			?>
    	<div class="row-fluid">
			
			<?php foreach ($this->product->customfieldsRelatedProducts as $field) {
				if(!empty($field->display)) {?>
					<div class=" <?php echo $row; ?> product-field product-field-type-<?php echo $field->field_type ?>">
					<span class="product-field-display"><?php echo $field->display ?></span>
				</div>
			<?php }
				} ?>
		</div>
    </div>
