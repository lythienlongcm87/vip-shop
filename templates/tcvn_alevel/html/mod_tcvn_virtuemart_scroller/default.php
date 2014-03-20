<?php
/*
# ------------------------------------------------------------------------
# TCVN Product Scroller for Virtuemart - Joomla 2.5
# ------------------------------------------------------------------------
# Copyright(C) 2012-2013 www.TheCoders.vn. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: TheCoders.vn
# Websites: http://TheCoders.com
# Forum:    http://VinaForum.biz
# ------------------------------------------------------------------------
*/


defined('_JEXEC') or die('Restricted access');
$url_load   = JURI::base().'modules/mod_tcvn_virtuemart_scroller/assets/';	
?>
<style type="text/css">
#tcvn-scroller-virtuemart<?php echo $module->id; ?> {
	width: <?php echo $width; ?>px;
	height: <?php echo $height; ?>px; 
}
#tcvn-scroller-virtuemart<?php echo $module->id; ?> {
    position: relative;
}

.tcvn-scroller-virtuemart .buttonlight:link, 
#tcvn-scroller-virtuemart<?php echo $module->id; ?> .buttonlight:visited {
    background: url("<?php echo $url_load; ?>images/btn-light.png") repeat-x scroll center top #999999;
    border: 1px solid #CDCDCD;
    color: #777777;
    font-weight: bold;
    padding: 5px 20px;
    text-align: center;
    text-decoration: none;
    text-shadow: 1px 1px 0 #FFFFFF;
}

.tcvn-scroller-virtuemart .buttondark:link, 
#tcvn-scroller-virtuemart<?php echo $module->id; ?> .buttondark:visited {
    background: url("<?php echo $url_load; ?>images/btn-dark.png") repeat-x scroll center top #999999;
    border: 1px solid #151515;
    color: #FFFFFF;
    font-weight: bold;
    padding: 0 20px;
    text-align: center;
    text-decoration: none;
    text-shadow: 1px 1px 0 #000000;
}
div#tcvn-copyright<?php echo $module->id; ?> {
	height:<?php echo ($copyright) ? 'auto' : 0; ?>;
	overflow:hidden;
}
#tcvn-scroller-virtuemart<?php echo $module->id; ?> .thumb {
	width: <?php echo $params->get('thumbWidth'); ?>px;
	height: <?php echo $params->get('thumbHeight'); ?>px;
}
</style>
<div id="tcvn-scroller-virtuemart<?php echo $module->id; ?>" class="tcvn-scroller-virtuemart <?php echo $styleslide.$moduleclass_sfx; ?>">
    <ul class="row-fluid vmproduct productdetails">
        <?php
        foreach($products as $product) : 
        ?>
        <li>
            <?php if($show_image){?>
                <a class="img-link" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id); ?>">
                    <img style="background:none" class="thumb" src="<?php if($show_image){ if (!empty($product->images[0])){ $image = JURI::base() . $product->images[0]->file_url; } else $image = JURI::base().'modules/mod_tcvn_virtuemart_scroller/assets/images/img4.jpg'; echo $image;} ?>" alt="'. $altText .'"/>
                </a>
            <?php }?>
            <div style="margin-top:16px"></div>
            <h2>
                <?php if($showProductName){ ?>
                <a href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id); ?>">
                    <?php echo $product->product_name; ?>
                </a>
                <?php }?>
            </h2>
             <?php if($showProductShortDesc){ ?>
                <p><?php echo substr(strip_tags($product->product_s_desc), 0, $params->get('limitText', 120)); ?> ...</p>
            <?php }
                if ($show_price) {if (!empty($product->prices['salesPrice'] ) ){ echo "<span>Price : "; echo $currency->createPriceDiv('salesPrice','',$product->prices,true).'</span>';}}
                if($show_cart){
                    modTCVNProductScrollerHelper::addCart($product);
                }
            ?>
        </li>
        <?php endforeach; ?>
    </ul>
    
    <!-- Control Button -->
    <div class="toolbar">
        <div class="left tcvn-color"><span></span></div>
        <div class="right tcvn-color"><span></span></div>
    </div>
</div>
<div id="tcvn-copyright<?php echo $module->id; ?>">
	<a href="http://thecoders.vn" title="TheCoders.vn - Free Joomla 2.5 Extensions, Joomla Modules, Joomla Plugins.">(C) TheCoders.vn</a>
</div>