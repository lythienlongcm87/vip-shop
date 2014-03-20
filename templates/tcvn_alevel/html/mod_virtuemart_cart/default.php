<?php // no direct access
defined('_JEXEC') or die('Restricted access');
//dump ($cart,'mod cart');
//var_dump($moduleclass_sfx); die();
// Ajax is displayed in vm_cart_products
// ALL THE DISPLAY IS Done by Ajax using "hiddencontainer" ?>

<!-- Virtuemart 2 Ajax Card -->
<div class="vmCartModule <?php echo $moduleclass_sfx ;?>" id="vmCartModule">
	<?php
	//var_dump($params); die();
	if ($moduleclass_sfx == 'top') {
		if (false && $data->dataValidated == true) {
	    $taskRoute = '&task=confirm';
		    $linkName = JText::_('COM_VIRTUEMART_CART_CONFIRM');
		} else {
		    $taskRoute = '';
		    $linkName = JText::_('COM_TCVN_VIRTUEMART_CART_SHOW');
		}
	}

	if ($show_product_list) {
		?>
		<div id="hiddencontainer" style=" display: none; ">
			<div class="container">
				<?php if ($show_price) { ?>
				  <div class="prices" style="float: right;"></div>
				<?php } ?>
				<div class="product_row">
					<span class="quantity"></span>&nbsp;x&nbsp;<span class="product_name"></span>
				</div>

				<div class="product_attributes"></div>
			</div>
		</div>
		<div class="vm_cart_products">
			<div class="container">

			<?php
				foreach ($data->products as $product)
			{
				if ($show_price) { ?>
					  <div class="prices" style="float: right;"><?php echo  $product['prices'] ?></div>
					<?php } ?>
				<div class="product_row">
					<span class="quantity"><?php echo  $product['quantity'] ?></span>&nbsp;x&nbsp;<span class="product_name"><?php echo  $product['product_name'] ?></span>
				</div>
				<?php if ( !empty($product['product_attributes']) ) { ?>
					<div class="product_attributes"><?php echo $product['product_attributes'] ?></div>

				<?php }
				}
			?>
			</div>
		</div>
	<?php } ?> 
		<?php if ($moduleclass_sfx == 'top') { ?>
		<!--<div class="total">
			<?php //if ($data->totalProduct and $show_price) echo  $data->billTotal; ?>
		</div> -->
		<div class="show_cart">

			<?php
		        if ($data->totalProduct and $show_price) {
		            echo '<a href="'.JRoute::_("?option=com_virtuemart&view=cart".$taskRoute,$useXHTML,$useSSL).'">'.$linkName.'</a>';
		        }
		        else echo "<span class='shopping_cart'>" .$linkName. "</span>";
		    ?>
		    <span class="total_products"><?php echo "(<span>" . $data->totalProduct . "</span>) " . JText::_('COM_TCVN_VIRTUEMART_CART_SHOW_ITEM')  ?></span>
		</div>

		<div style="clear:both;"></div>

		<noscript>
		<?php echo JText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
		</noscript>

	<?php } else{ 
		$a = JText::_('COM_TCVN_VIRTUEMART_NO_PRODUCT');
	?>

		<div class="totalproduct">
			<?php if ($data->totalProduct) {
				# c
			} else{
				echo $a;
			}?>
		</div>
		<div class="total">
			<?php echo  $data->billTotal; ?>			
		</div>
		<div class="show_cart">

			<?php
		        if ($data->totalProduct and $show_price) {
		            echo '<a class="btn btn-primary" href="'.JRoute::_("?option=com_virtuemart&view=cart".$taskRoute,$useXHTML,$useSSL).'">'.$linkName.'</a>';
		        }
		        else echo '<a  class="btn btn-primary" href="javascript: void(0)" onclick="alert('."'".$a."'".')">'.$linkName.'</a>';
		    ?>
		</div>

		<div style="clear:both;"></div>

		<noscript>
		<?php echo JText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
		</noscript>
	<?php } ?>
</div>

