<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$col= 1 ;
$document = JFactory::getDocument();
$document->addScript(JURI::base() . 'templates/tcvn_alevel/js/js.slide.js');
?>
<div class="vmgroup<?php echo $params->get( 'moduleclass_sfx' ) ?>">

<?php if ($headerText) : ?>
	<div class="vmheader"><?php echo $headerText ?></div>
<?php else : ?>
    <div class="vmheader"><?php echo JText::_('We offer products from the following Manufacturer') ?></div>
<?php endif;
//var_dump($manufacturers); die();
if ($display_style =="div") { ?>
	<div class="vmmanufacturer<?php echo $params->get('moduleclass_sfx'); ?>">
	<?php foreach ($manufacturers as $manufacturer) {
		$link = JROUTE::_('index.php?option=com_virtuemart&view=manufacturer&virtuemart_manufacturer_id=' . $manufacturer->virtuemart_manufacturer_id);
        $link1 = JROUTE::_('index.php?option=com_virtuemart&view=category&virtuemart_manufacturer_id=' . $manufacturer->virtuemart_manufacturer_id);
        ?>
		<div style="float:left;">
			<a href="<?php echo $link; ?>">
                <?php
                if ($show == 'text' or $show == 'all' ) { ?>
                    <div class="manufacturer-name"><?php echo $manufacturer->mf_name; ?></div>
                <?php
                }
                if ($manufacturer->images && ($show == 'image' or $show == 'all' )) { ?>
                    <?php echo $manufacturer->images[0]->displayMediaThumb('',false);?>
                <?php
                }
                 ?>
			</a>
            <a class="manufacturer-link-products" href="<?php echo $link1; ?>">
                <?php echo JText::_('VIEW_PRODUCTS'); ?>
            </a>
		</div>
		<?php
		if ($col == $manufacturers_per_row) {
			echo "</div><div style='clear:both;'>";
			$col= 1 ;
		} else {
			$col++;
		}
	} ?>
	</div>
	<br style='clear:both;' />

<?php
} else {
	$last = count($manufacturers)-1;
?>
<div class="manufacturer-slider-aam" id="manufacturer-slider">
    <ul id="slide" class="vmmanufacturer<?php echo $params->get('moduleclass_sfx'); ?>">
    <?php
    foreach ($manufacturers as $manufacturer) {
        $link = JROUTE::_('index.php?option=com_virtuemart&view=manufacturer&virtuemart_manufacturer_id=' . $manufacturer->virtuemart_manufacturer_id);
        $link1= JROUTE::_('index.php?option=com_virtuemart&view=category&virtuemart_manufacturer_id=' . $manufacturer->virtuemart_manufacturer_id);
        ?>
        <li><a href="<?php echo $link; ?>">
            <?php
            if ($show == 'text' or $show == 'all' ) { ?>
                <div class="manufacturer-name"><?php echo $manufacturer->mf_name; ?></div>
            <?php
            }
            if ($manufacturer->images && ($show == 'image' or $show == 'all' )) { ?>
                <?php echo $manufacturer->images[0]->displayMediaThumb('',false);?>
            <?php
            }

            ?>
            </a>
            <a class="manufacturer-link-products" href="<?php echo $link1; ?>">
                <?php echo JText::_('VIEW_PRODUCTS'); ?>
            </a>
        </li>
        <?php
        if ($col == $manufacturers_per_row && $manufacturers_per_row && $last) {
            echo '</ul><ul class="vmmanufacturer'.$params->get('moduleclass_sfx').'">';
            $col= 1 ;
        } else {
            $col++;
        }
        $last--;
    } ?>
    </ul>
</div>
<?php }
	if ($footerText) : ?>
	<div class="vmfooter<?php echo $params->get( 'moduleclass_sfx' ) ?>">
		 <?php echo $footerText ?>
	</div>
<?php endif; ?>
</div>
<script language="javascript">
jQuery(document).ready(function(){
    jQuery('#manufacturer-slider').manufacturerSlide({
        numberListElements: 6,
        autoPlay: true,
        interval: 3000,
        height: 120
    });
});
</script>