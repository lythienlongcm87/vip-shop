<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz
 * @author RolandD,
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 6530 2012-10-12 09:40:36Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// addon for joomla modal Box
JHTML::_('behavior.modal');
// JHTML::_('behavior.tooltip');
$document = JFactory::getDocument();
$document->addScriptDeclaration("
//<![CDATA[
	jQuery(document).ready(function($) {
		$('a.ask-a-question').click( function(){
			$.facebox({
				iframe: '" . $this->askquestion_url . "',
				rev: 'iframe|550|550'
			});
			return false ;
		});
	/*	$('.additional-images a').mouseover(function() {
			var himg = this.href ;
			var extension=himg.substring(himg.lastIndexOf('.')+1);
			if (extension =='png' || extension =='jpg' || extension =='gif') {
				$('.main-image img').attr('src',himg );
			}
			console.log(extension)
		});*/
	});
//]]>
");
/* Let's see if we found the product */
if (empty($this->product)) {
    echo JText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
    echo '<br /><br />  ' . $this->continue_link_html;
    return;
}
?>

<div class="productdetails-view productdetails">
	<?php // Back To Category Button
	if ($this->product->virtuemart_category_id) {
		$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->product->virtuemart_category_id);
		$categoryName = $this->product->category_name ;
	} else {
		$catURL =  JRoute::_('index.php?option=com_virtuemart');
		$categoryName = jText::_('COM_VIRTUEMART_SHOP_HOME') ;
	}
	?>
    <?php
    if (!empty($this->product->customfieldsSorted['ontop'])) {
	$this->position = 'ontop';
	echo $this->loadTemplate('customfields');
    } // Product Custom ontop end
    ?>

    <div class="product_content row-fluid">
        <div class="span5">
            <?php
            echo $this->loadTemplate('images');
            ?>
        </div>

        <div class="span7">

            <div class="spacer-buy-area">
                <div class="back-to-category">
                    <a href="<?php echo $catURL ?>" class="product-details" title="<?php echo $categoryName ?>"><?php echo JText::sprintf('COM_VIRTUEMART_CATEGORY_BACK_TO',$categoryName) ?></a>
                </div>
                <?php // Product Title   ?>
                <h2 class="title"><?php echo $this->product->product_name ?></h2>
                <?php // Product Title END   ?>

                <?php // afterDisplayTitle Event
                echo $this->product->event->afterDisplayTitle ?>

                <?php
                // Product Edit Link
                //echo $this->edit_link;
                // Product Edit Link END
                ?>
                <?php
                // TODO in Multi-Vendor not needed at the moment and just would lead to confusion
                /* $link = JRoute::_('index2.php?option=com_virtuemart&view=virtuemart&task=vendorinfo&virtuemart_vendor_id='.$this->product->virtuemart_vendor_id);
                  $text = JText::_('COM_VIRTUEMART_VENDOR_FORM_INFO_LBL');
                  echo '<span class="bold">'. JText::_('COM_VIRTUEMART_PRODUCT_DETAILS_VENDOR_LBL'). '</span>'; ?><a class="modal" href="<?php echo $link ?>"><?php echo $text ?></a><br />
                 */
                ?>
                <?php
                if ($this->showRating) {
                    $maxrating = VmConfig::get('vm_maximum_rating_scale', 5);

                    if (empty($this->rating)) {
                    ?>
                    <span class="vote"><?php echo JText::_('COM_VIRTUEMART_RATING') . ' ' . JText::_('COM_VIRTUEMART_UNRATED') ?></span>
                        <?php
                    } else {
                        $ratingwidth = $this->rating->rating * 24; //I don't use round as percetntage with works perfect, as for me
                        ?>
                    <span class="vote">
                    <?php echo JText::_('COM_VIRTUEMART_RATING') //. ' ' . round($this->rating->rating) . '/' . $maxrating; ?>
                        <span title=" <?php echo (JText::_("COM_VIRTUEMART_RATING_TITLE") . round($this->rating->rating) . '/' . $maxrating) ?>" class="ratingbox" style="display:inline-block;">
                        <span class="stars-orange" style="width:<?php echo $ratingwidth.'px'; ?>">
                        </span>
                        </span>
                    </span>
                    <?php
                    }
                }
                //<?php
                // Add To Cart Button
                // 	if (!empty($this->product->prices) and !empty($this->product->images[0]) and $this->product->images[0]->file_is_downloadable==0 ) {
                // if (!VmConfig::get('use_as_catalog', 0) and !empty($this->product->prices['salesPrice'])) {
                echo $this->loadTemplate('addtocart');
                // }  // Add To Cart Button END
                //?//>
                if (is_array($this->productDisplayShipments)) {
                    foreach ($this->productDisplayShipments as $productDisplayShipment) {
                    echo $productDisplayShipment . '<br />';
                    }
                }
                if (is_array($this->productDisplayPayments)) {
                    foreach ($this->productDisplayPayments as $productDisplayPayment) {
                    echo $productDisplayPayment . '<br />';
                    }
                }

                ?>
                <div class="availability-prices" style="clear: both">
                    <div class="product-salesPrice">
                        <?php
                       //var_dump($this->currency->createPriceDiv ('salesPrice', JText::_ ('COM_VIRTUEMART_CART_PRICE'), $this->product->prices)); die();
                        if (!empty($this->product->prices['salesPrice'])) {
                            echo $this->currency->createPriceDiv ('salesPrice', JText::_ ('COM_VIRTUEMART_CART_PRICE'), $this->product->prices);
                        }
                        ?>
                        <div class="clear"></div>
                    </div>
                    <div class="row-fluid">
                        <div class="span5 ">
                            <div class="product_sku"><b><?php echo JText::_('SKU: ') . $this->product->product_sku; ?></b></div>
                            <?php
                            // Manufacturer of the Product
                            if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
                                echo $this->loadTemplate('manufacturer');
                            }
                            // Availability Image
                            $stockhandle = VmConfig::get('stockhandle', 'none');
                            if (($this->product->product_in_stock - $this->product->product_ordered) < 1) {
                                if ($stockhandle == 'risetime' and VmConfig::get('rised_availability') and empty($this->product->product_availability)) {
                                    ?>	<div class="availability">
                                        <?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability'))) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability', '7d.gif'), VmConfig::get('rised_availability', '7d.gif'), array('class' => 'availability')) : VmConfig::get('rised_availability'); ?>
                                    </div>
                                <?php
                                } else if (!empty($this->product->product_availability)) {
                                    ?>
                                    <div class="availability">
                                        <?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability)) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability, $this->product->product_availability, array('class' => 'availability')) : $this->product->product_availability; ?>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                        </div>

                        <div class="span7 ">
                            <?php
                            // Product Price
                            // the test is done in show_prices
                            //if ($this->show_prices and (empty($this->product->images[0]) or $this->product->images[0]->file_is_downloadable == 0)) {
                            echo $this->loadTemplate('showprices');
                            //}
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                // Product Short Description
                if (!empty($this->product->product_s_desc)) {
                    ?>
                    <div class="product-short-description">
                        <h6 class="title"><?php echo JText::_('Quick overview')?></h6>
                        <?php
                        /** @todo Test if content plugins modify the product description */
                        echo nl2br($this->product->product_s_desc);
                        ?>
                    </div>
                <?php
                } // Product Short Description END
                // PDF - Print - Email Icon
                if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_button_enable')) {
                    ?>
                    <div class="icons">
                        <?php
                        //$link = (JVM_VERSION===1) ? 'index2.php' : 'index.php';
                        $link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;
                        $MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';

                        if (VmConfig::get('pdf_icon', 1) == '1') {
                            echo $this->linkIcon($link . '&format=pdf', 'COM_VIRTUEMART_PDF', 'pdf_button', 'pdf_button_enable', false);
                        }
                        echo $this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon');
                        echo $this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'emailButton', 'show_emailfriend');
                        ?>
                        <div class="clear"></div>
                    </div>
                <?php } // PDF - Print - Email Icon END
                // Ask a question about this product
                if (VmConfig::get('ask_question', 1) == 1) {
                    ?>
                    <div class="ask-a-question">
                        <a class="ask-a-question" href="<?php echo $this->askquestion_url ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
                        <!--<a class="ask-a-question modal" rel="{handler: 'iframe', size: {x: 700, y: 550}}" href="<?php echo $this->askquestion_url ?>"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>-->
                    </div>
                <?php }
                // Product Navigation
                if (VmConfig::get('product_navigation', 1)) {
                    ?>
                    <div class="product-neighbours">
                        <?php
                        if (!empty($this->product->neighbours ['previous'][0])) {
                            $prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
                            echo JHTML::_('link', $prev_link, $this->product->neighbours ['previous'][0]
                            [''], array('class' => 'previous-page'));
                        }
                        if (!empty($this->product->neighbours ['next'][0])) {
                            $next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
                            echo JHTML::_('link', $next_link, $this->product->neighbours ['next'][0] [''], array('class' => 'next-page'));
                        }
                        ?>
                        <div class="clear"></div>
                    </div>
                <?php } // Product Navigation END
                ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>

	<?php // event onContentBeforeDisplay
	echo $this->product->event->beforeDisplayContent; ?>

	<?php
	// Product Description
	//if (!empty($this->product->product_desc)) {?>
        <!--<div class="product-description">
        <?php /** @todo Test if content plugins modify the product description */ ?>
            <span class="title"><?php// echo JText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE') ?></span>
        <?php// echo $this->product->product_desc; ?>
            </div>-->
        <?php
    //} // Product Description END
    //echo $this->loadTemplate('reviews');
    ?>
    <?php
    // Product Description
    //if (!empty($this->product->product_desc)) { ?>
    <div class="tcvn-tabs">
        <?php /** @todo Test if content plugins modify the product description */ ?>
        <ul class="nav nav-tabs" id="myTab">
            <li class="active">
                <a href="#<?php echo JText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE') ?>" data-toggle="tab"><span class="title"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE') ?></span></a>
            </li>
            <li>
                <a href="#<?php echo JText::_ ('COM_VIRTUEMART_REVIEWS') ?>" data-toggle="tab"><span class="title"><?php echo JText::_ ('COM_VIRTUEMART_REVIEWS') ?></span></a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="<?php echo JText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE') ?>">
                <?php echo $this->product->product_desc; ?>
            </div>
            <div class="tab-pane" id="<?php echo JText::_ ('COM_VIRTUEMART_REVIEWS') ?>">
                <div class="list-reviews">
                    <?php
                    echo $this->loadTemplate('reviews');
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="itemSocialSharing">
        <h3 class="socialSharing-title">
            <?php echo JText::_('Share to your friend'); ?>
        </h3>
        <div class="itemlinkedinButton socialSharing">
            <script src="//platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
            <script type="IN/Share" data-counter="right"></script>
        </div>

        <!-- Twitter Button -->
        <div class="itemTwitterButton socialSharing">
            <a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal">
                <?php echo JText::_('K2_TWEET'); ?>
            </a>
            <script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
        </div>

        <!-- Facebook Button -->
        <div class="itemFacebookButton socialSharing">
            <div id="fb-root"></div>
            <script type="text/javascript">
                (function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>
            <div class="fb-like" data-send="true" data-layout="button_count" data-width="450" data-show-faces="false"> </div>
        </div>

        <!-- Google +1 Button -->
        <div class="itemGooglePlusOneButton socialSharing">
            <g:plusone annotation="bubble" size="medium" width="120"></g:plusone>
            <script type="text/javascript">
                (function() {
                    window.___gcfg = {lang: 'en'}; // Define button default language here
                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                    po.src = 'https://apis.google.com/js/plusone.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                })();
            </script>
        </div>

        <div class="clr"></div>
    </div>
    <?php
    //} // Product Description END

    if (!empty($this->product->customfieldsSorted['normal'])) {
	$this->position = 'normal';
	echo $this->loadTemplate('customfields');
    } // Product custom_fields END
    // Product Packaging
    $product_packaging = '';
    if ($this->product->product_box) {
	?>
        <div class="product-box">
	    <?php
	        echo JText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX') .$this->product->product_box;
	    ?>
        </div>
    <?php } // Product Packaging END
    ?>

    <?php
    // Product Files
    // foreach ($this->product->images as $fkey => $file) {
    // Todo add downloadable files again
    // if( $file->filesize > 0.5) $filesize_display = ' ('. number_format($file->filesize, 2,',','.')." MB)";
    // else $filesize_display = ' ('. number_format($file->filesize*1024, 2,',','.')." KB)";

    /* Show pdf in a new Window, other file types will be offered as download */
    // $target = stristr($file->file_mimetype, "pdf") ? "_blank" : "_self";
    // $link = JRoute::_('index.php?view=productdetails&task=getfile&virtuemart_media_id='.$file->virtuemart_media_id.'&virtuemart_product_id='.$this->product->virtuemart_product_id);
    // echo JHTMl::_('link', $link, $file->file_title.$filesize_display, array('target' => $target));
    // }
    if (!empty($this->product->customfieldsRelatedProducts)) {
	echo $this->loadTemplate('relatedproducts');
    } // Product customfieldsRelatedProducts END

    if (!empty($this->product->customfieldsRelatedCategories)) {
	echo $this->loadTemplate('relatedcategories');
    } // Product customfieldsRelatedCategories END
    // Show child categories
    if (VmConfig::get('showCategory', 1)) {
	//echo $this->loadTemplate('showcategory');
    }
    if (!empty($this->product->customfieldsSorted['onbot'])) {
    	$this->position='onbot';
    	echo $this->loadTemplate('customfields');
    } // Product Custom ontop end
    ?>
<?php // onContentAfterDisplay event
echo $this->product->event->afterDisplayContent; ?>

</div>
