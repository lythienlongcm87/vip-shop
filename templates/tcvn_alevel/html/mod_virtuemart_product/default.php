<?php // no direct access
defined ('_JEXEC') or die('Restricted access');

// add javascript for price and cart, need even for quantity buttons, so we need it almost anywhere
vmJsApi::jPrice();

$col = 1;
$pwidth = ' span' . floor (12 / $products_per_row);
if ($products_per_row > 1) {
	$float = "floatleft";
} else {
	$float = "center";
}
if($params->get ('moduleclass_sfx') == "slider-product"):
    $document = JFactory::getDocument();
    $document->addScript(JURI::base() . 'templates/tcvn_alevel/js/js.slide.js');

?>
<script language="javascript">
    jQuery(document).ready(function(){
        jQuery('#virtuemart-product<?php echo $module->id; ?>').manufacturerSlide({
            numberListElements: 3,
            autoPlay: true,
            interval: 3000,
            height: 120
        });
    });
</script>
<?php endif;  ?>
<div id="virtuemart-product<?php echo $module->id; ?>" class="vmgroup <?php echo $params->get('moduleclass_sfx'); ?>">

	<?php if ($headerText) { ?>
	<div class="vmheader"><?php echo $headerText ?></div>
	<?php }
	$last = count ($products) - 1;
	if($params->get ('moduleclass_sfx') == "slider-product") { ?>
	<ul class="row-fluid vmproduct <?php echo $params->get ('moduleclass_sfx'); ?> productdetails">
		<?php foreach ($products as $product) : ?>
			<li class="product <?php echo $pwidth ?> <?php echo $float ?>" style="position: relative;">
				<div class="bg-best-sales"></div>
                <div class="spacer">
				<?php
				if (!empty($product->images[0])) {
					$image = $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE);
				} else {
					$image = '';
				}
				echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));
				echo '<div class="clear"></div>';
				$url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
					$product->virtuemart_category_id); ?>
				<p><a class="vmproduct-name" href="<?php echo $url ?>"><?php echo $product->product_name ?></a></p>
				<?php    echo '<div class="clear"></div>';
				// $product->prices is not set when show_prices in config is unchecked
                   // var_dump($product->prices); die();
				if ($show_price and  isset($product->prices)) {
					echo '<div class="product-price">'.$currency->createPriceDiv ('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
					if ($product->prices['salesPriceWithDiscount'] > 0) {
						echo $currency->createPriceDiv ('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
					}
					echo '</div>';
				}
				if ($show_addtocart) {
					echo mod_virtuemart_product::addtocart ($product);
				}
				?>
                </div>
			</li>
			<?php
			$last--;
		endforeach; ?>
	</ul>
	<div class="clear"></div>

	<?php }

	else
	{ ?>
		<div class="row-fluid vmproduct <?php echo $params->get ('moduleclass_sfx'); ?> productdetails">
			<?php foreach ($products as $product) : ?>
			<div class="product <?php echo $pwidth ?> <?php echo $float ?>" style="position: relative;">
				<div class="bg-best-sales"></div>
                <div class="spacer">
				<?php
				if (!empty($product->images[0])) {
					$image = $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE);
				} else {
					$image = '';
				}
				echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));
				echo '<div class="clear"></div>';
				$url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
					$product->virtuemart_category_id); ?>
				<p><a class="vmproduct-name" href="<?php echo $url ?>"><?php echo $product->product_name ?></a></p>
				<?php    echo '<div class="clear"></div>';
				// $product->prices is not set when show_prices in config is unchecked
                   // var_dump($product->prices); die();
				if ($show_price and  isset($product->prices)) {
					echo '<div class="product-price">'.$currency->createPriceDiv ('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
					if ($product->prices['salesPriceWithDiscount'] > 0) {
						echo $currency->createPriceDiv ('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
					}
					echo '</div>';
				}
				if ($show_addtocart) {
					echo mod_virtuemart_product::addtocart ($product);
				}
				?>
                </div>
			</div>
			<?php
			if ($col == $products_per_row && $products_per_row && $last) {
				?>
		</div><div class="clear"></div>
		<div class="row-fluid vmproduct<?php echo $params->get ('moduleclass_sfx'); ?> productdetails">
			<?php
				$col = 1;
			} else {
				$col++;
			}
			$last--;
		endforeach; ?>
		</div>
		<div class="clear"></div>
	<?php }
	if ($footerText) : ?>
		<div class="vmfooter<?php echo $params->get ('moduleclass_sfx') ?>">
			<?php echo $footerText ?>
		</div>
		<?php endif; ?>
</div>
