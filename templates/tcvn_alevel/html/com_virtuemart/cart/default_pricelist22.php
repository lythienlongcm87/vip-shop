<?php defined ('_JEXEC') or die('Restricted access');
/**
 *
 * Layout for the shopping cart
 *
 * @package    VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 * @author Patrick Kohl
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

// jimport( 'joomla.application.component.view');
// $viewEscape = new JView();
// $viewEscape->setEscape('htmlspecialchars');

?>
<div class="billto-shipto">
    <div class="row-fluid">
        <div class="span6">

            <span><span class="vmicon vm2-billto-icon"></span>
                <?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_LBL'); ?></span>
            <?php // Output Bill To Address ?>
            <div class="output-billto">
                <?php

                foreach ($this->cart->BTaddress['fields'] as $item) {
                    if (!empty($item['value'])) {
                        if ($item['name'] === 'agreed') {
                            $item['value'] = ($item['value'] === 0) ? JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_NO') : JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_YES');
                        }
                        ?><!-- span class="titles"><?php echo $item['title'] ?></span -->
                        <span class="values vm2<?php echo '-' . $item['name'] ?>"><?php echo $this->escape ($item['value']) ?></span>
                        <?php if ($item['name'] != 'title' and $item['name'] != 'first_name' and $item['name'] != 'middle_name' and $item['name'] != 'zip') { ?>
                            <br class="clear"/>
                            <?php
                        }
                    }
                } ?>
                <div class="clear"></div>
            </div>

            <a class="details" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=user&task=editaddresscart&addrtype=BT', $this->useXHTML, $this->useSSL) ?>">
                <?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_EDIT_BILLTO_LBL'); ?>
            </a>

            <input type="hidden" name="billto" value="<?php echo $this->cart->lists['billTo']; ?>"/>
        </div>

        <div class="span6">

            <span><span class="vmicon vm2-shipto-icon"></span>
                <?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_SHIPTO_LBL'); ?></span>
            <?php // Output Bill To Address ?>
            <div class="output-shipto">
                <?php
                if (empty($this->cart->STaddress['fields'])) {
                    echo JText::sprintf ('COM_VIRTUEMART_USER_FORM_EDIT_BILLTO_EXPLAIN', JText::_ ('COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL'));
                } else {
                    if (!class_exists ('VmHtml')) {
                        require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'html.php');
                    }
                    echo JText::_ ('COM_VIRTUEMART_USER_FORM_ST_SAME_AS_BT');
                    echo VmHtml::checkbox ('STsameAsBTjs', $this->cart->STsameAsBT) . '<br />';
                    ?>
                    <div id="output-shipto-display">
                        <?php
                        foreach ($this->cart->STaddress['fields'] as $item) {
                            if (!empty($item['value'])) {
                                ?>
                                <!-- <span class="titles"><?php echo $item['title'] ?></span> -->
                                <?php
                                if ($item['name'] == 'first_name' || $item['name'] == 'middle_name' || $item['name'] == 'zip') {
                                    ?>
                                    <span class="values<?php echo '-' . $item['name'] ?>"><?php echo $this->escape ($item['value']) ?></span>
                                    <?php } else { ?>
                                    <span class="values"><?php echo $this->escape ($item['value']) ?></span>
                                    <br class="clear"/>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <div class="clear"></div>
            </div>
            <?php if (!isset($this->cart->lists['current_id'])) {
            $this->cart->lists['current_id'] = 0;
        } ?>
            <a class="details" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=user&task=editaddresscart&addrtype=ST&virtuemart_user_id[]=' . $this->cart->lists['current_id'], $this->useXHTML, $this->useSSL) ?>">
                <?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL'); ?>
            </a>

        </div>

        <div class="clear"></div>
    </div>
</div>

<div class="cart">
    <div class="cart-summary">
    <!--<tr>
        <th align="left"><?php echo JText::_ ('COM_VIRTUEMART_CART_NAME') ?></th>
        <th align="left"><?php echo JText::_ ('COM_VIRTUEMART_CART_SKU') ?></th>
        <th align="center" width="60px"><?php echo JText::_ ('COM_VIRTUEMART_CART_PRICE') ?></th>
        <th align="right" width="140px"><?php echo JText::_ ('COM_VIRTUEMART_CART_QUANTITY') ?> / <?php echo JText::_ ('COM_VIRTUEMART_CART_ACTION') ?></th>
        <?php if (VmConfig::get ('show_tax')) { ?>
            <th align="right" width="60px"><?php  echo "<span  class='priceColor2'>" . JText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?></th>
        <?php } ?>
        <th align="right" width="60px"><?php echo "<span  class='priceColor2'>" . JText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') ?></th>
        <th align="right" width="70px"><?php echo JText::_ ('COM_VIRTUEMART_CART_TOTAL') ?></th>
    </tr>-->
    <?php
    $i = 1;
    // 		vmdebug('$this->cart->products',$this->cart->products);
    foreach ($this->cart->products as $pkey => $prow) {
        ?>
    <div class="row-fluid cart-products-sectiontab sectiontableentry<?php echo $i ?>">
        <div class="span2 products-image">
            <?php if ($prow->virtuemart_media_id) { ?>
            <div class="cart-images">
                <?php
                if (!empty($prow->image)) {
                    echo $prow->image->displayMediaThumb ('', FALSE);
                }
                ?>
            </div>
            <?php } ?>

        </div>
        <div class="span3 cart-products-are name-sku">
            <div class="product_name">
                <?php echo JHTML::link ($prow->url, $prow->product_name) . $prow->customfields; ?>
            </div>
            <div class="sku">
                <?php echo JText::_ ('COM_VIRTUEMART_CART_SKU') ?>:
                <?php  echo $prow->product_sku ?>
            </div>          
        </div>
        <div class="span2 cart-products-are taxamount-prices">
            <?php
            // vmdebug('$this->cart->pricesUnformatted[$pkey]',$this->cart->pricesUnformatted[$pkey]['priceBeforeTax']);
            echo '<div class="color">' . $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $this->cart->pricesUnformatted[$pkey], FALSE) . '</div>';
            // echo $prow->salesPrice ;
            ?>
            <?php if (VmConfig::get ('show_tax')) { ?>
            <?php echo "<div  class='pricetax'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', JText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') . ' : ', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE, $prow->quantity) . "</div>" ?>
            <?php } ?>
        </div>
        <div class="span2 cart-products-are" style="position: relative">
            <?php
            //	$step=$prow->min_order_level;
            if ($prow->step_order_level)
                $step=$prow->step_order_level;
            else
                $step=1;
            if($step==0)
                $step=1;
            $alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
            ?>
            <script type="text/javascript">
                function check<?php echo $step?>(obj) {
                // use the modulus operator '%' to see if there is a remainder
                remainder=obj.value % <?php echo $step?>;
                quantity=obj.value;
                if (remainder  != 0) {
                    alert('<?php echo $alert?>!');
                    obj.value = quantity-remainder;
                    return false;
                }
                return true;
                }
            </script>
            <form action="<?php echo JRoute::_ ('index.php'); ?>" method="post" class="inline">
                <input type="hidden" name="option" value="com_virtuemart"/>
                    <!--<input type="text" title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="inputbox" size="3" maxlength="4" name="quantity" value="<?php echo $prow->quantity ?>" /> -->
                    <input type="text" onblur="check<?php echo $step?>(this);" onclick="check<?php echo $step?>(this);" onchange="check<?php echo $step?>(this);" onsubmit="check(<?php echo $step?>this);" title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="quantity-input js-recalculate" size="3" maxlength="4" name="quantity" value="<?php echo $prow->quantity ?>" />
                <input type="hidden" name="view" value="cart"/>
                <input type="hidden" name="task" value="update"/>
                <input type="hidden" name="cart_virtuemart_product_id" value="<?php echo $prow->cart_item_id  ?>"/>
                <input type="submit" class="vmicon vm2-add_quantity_cart" name="update" title="<?php echo  JText::_ ('COM_VIRTUEMART_CART_UPDATE') ?>" align="middle" value=" "/>
            </form>            
        </div>
        <div class="span3 cart-products-are">
            <?php
            if (VmConfig::get ('checkout_show_origprice', 1) && !empty($this->cart->pricesUnformatted[$pkey]['basePriceWithTax']) && $this->cart->pricesUnformatted[$pkey]['basePriceWithTax'] != $this->cart->pricesUnformatted[$pkey]['salesPrice']) {
                echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceWithTax', '', $this->cart->pricesUnformatted[$pkey], TRUE, FALSE, $prow->quantity) . '</span><br />';
            }
            echo '<div class="color">' . $this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE, $prow->quantity) . '</div>';
            ?>
            <?php echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('discountAmount', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE, $prow->quantity) . "</span>" ?>
            <div>
                <a class="tcvn-vmicon tcvn_remove_from_cart" title="<?php echo JText::_ ('COM_VIRTUEMART_CART_DELETE') ?>" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=cart&task=delete&cart_virtuemart_product_id=' . $prow->cart_item_id) ?>"> 
                    <span><?php echo JText::_ ('COM_VIRTUEMART_CART_DELETE') ?></span>
                </a>
            </div>
        </div>
    </div>
    <?php
        $i = ($i==1) ? 2 : 1;
    } ?>
    <!--Begin of SubTotal, Tax, Shipment, Coupon Discount and Total listing -->
    <?php if (VmConfig::get ('show_tax')) {
        $colspan = 3;
    } else {
        $colspan = 2;
    } ?>
    <div class="row-fluid sectiontableentry1 product-prices-result">
        <div class="span7" style="text-align: right">
            <?php echo JText::_ ('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_PRICES_TOTAL'); ?>
        </div>

        <?php if (VmConfig::get ('show_tax')) { ?>
        <div class="span5">
            <?php echo "<div  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $this->cart->pricesUnformatted, FALSE) . "</div>" ?>
            <?php echo "<div  class='priceColor1'>" . $this->currencyDisplay->createPriceDiv ('discountAmount', '', $this->cart->pricesUnformatted, FALSE) . "</div>" ?>
            <?php echo "<div  class='priceColor3'>" . $this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->pricesUnformatted, FALSE) . "</div>"?>
        </div>
        <?php } ?>
    </div>

    <?php
    if (VmConfig::get ('coupons_enable')) {
        ?>
    <div class="sectiontableentry2">
        <div colspan="4" align="left">
            <?php if (!empty($this->layoutName) && $this->layoutName == 'default') {
                // echo JHTML::_('link', JRoute::_('index.php?view=cart&task=edit_coupon',$this->useXHTML,$this->useSSL), JText::_('COM_VIRTUEMART_CART_EDIT_COUPON'));
                echo $this->loadTemplate ('coupon');
            }?>
            <?php if (!empty($this->cart->cartData['couponCode'])) { ?>
            <?php
            echo $this->cart->cartData['couponCode'];
            echo $this->cart->cartData['couponDescr'] ? (' (' . $this->cart->cartData['couponDescr'] . ')') : '';
            ?>

        </div>

        <?php if (VmConfig::get ('show_tax')) { ?>
            <div align="right"><?php echo $this->currencyDisplay->createPriceDiv ('couponTax', '', $this->cart->pricesUnformatted['couponTax'], FALSE); ?> </div>
                    <?php } ?>
            <div align="right">&nbsp;</div>
            <div align="right"><?php echo $this->currencyDisplay->createPriceDiv ('salesPriceCoupon', '', $this->cart->pricesUnformatted['salesPriceCoupon'], FALSE); ?> </div>
        <?php } 

        else { ?>
            <div colspan="6" align="left">&nbsp;</div>
        <?php } ?>
    </div>
    <?php } ?>


    <?php
    foreach ($this->cart->cartData['DBTaxRulesBill'] as $rule) {
        ?>
    <div class="sectiontableentry<?php echo $i ?>">
        <div colspan="4" align="right"><?php echo $rule['calc_name'] ?> </div>

        <?php if (VmConfig::get ('show_tax')) { ?>
        <div align="right"></div>
        <?php } ?>
        <div align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?></div>
        <div align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </div>
    </div>
        <?php
        if ($i) {
            $i = 1;
        } else {
            $i = 0;
        }
    } ?>

    <?php

    foreach ($this->cart->cartData['taxRulesBill'] as $rule) {
        ?>
    <div class="sectiontableentry<?php echo $i ?>">
        <div colspan="4" align="right"><?php echo $rule['calc_name'] ?> </div>
        <?php if (VmConfig::get ('show_tax')) { ?>
        <div align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </div>
        <?php } ?>
        <div align="right"><?php ?> </div>
        <div align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </div>
    </div>
        <?php
        if ($i) {
            $i = 1;
        } else {
            $i = 0;
        }
    }

    foreach ($this->cart->cartData['DATaxRulesBill'] as $rule) {
        ?>
    <div class="sectiontableentry<?php echo $i ?>">
        <div colspan="4" align="right"><?php echo   $rule['calc_name'] ?> </div>

        <?php if (VmConfig::get ('show_tax')) { ?>
        <div align="right"></div>

        <?php } ?>
        <div align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?>  </div>
        <div align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </div>
    </div>
        <?php
        if ($i) {
            $i = 1;
        } else {
            $i = 0;
        }
    } ?>


    <div class="sectiontableentry1">
        <?php if (!$this->cart->automaticSelectedShipment) { ?>

        <?php /*	<div colspan="2" align="right"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_SHIPPING'); ?> </div> */ ?>
                    <div colspan="4" align="left">
                    <?php echo $this->cart->cartData['shipmentName']; ?>
        <br/>
        <?php
        if (!empty($this->layoutName) && $this->layoutName == 'default' && !$this->cart->automaticSelectedShipment) {
            echo JHTML::_ ('link', JRoute::_ ('index.php?view=cart&task=edit_shipment', $this->useXHTML, $this->useSSL), $this->select_shipment_text, 'class=""');
        } else {
            JText::_ ('COM_VIRTUEMART_CART_SHIPPING');
        }
    } else {
        ?>
        <div colspan="4" align="left">
            <?php echo $this->cart->cartData['shipmentName']; ?>
        </div>
        <?php } ?>

        <?php if (VmConfig::get ('show_tax')) { ?>
        <div align="right"><?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('shipmentTax', '', $this->cart->pricesUnformatted['shipmentTax'], FALSE) . "</span>"; ?> </div>
        <?php } ?>
        <div></div>
        <div align="right"><?php echo $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->pricesUnformatted['salesPriceShipment'], FALSE); ?> </div>
    </div>
    <?php if ($this->cart->pricesUnformatted['salesPrice']>0.0 ) { ?>
    <div class="sectiontableentry1">
        <?php if (!$this->cart->automaticSelectedPayment) { ?>

        <div colspan="4" align="left">
            <?php echo $this->cart->cartData['paymentName']; ?>
            <br/>
            <?php if (!empty($this->layoutName) && $this->layoutName == 'default') {
            echo JHTML::_ ('link', JRoute::_ ('index.php?view=cart&task=editpayment', $this->useXHTML, $this->useSSL), $this->select_payment_text, 'class=""');
        } else {
            JText::_ ('COM_VIRTUEMART_CART_PAYMENT');
        } ?> </div>

        </div>
        <?php } else { ?>
        <div colspan="4" align="left"><?php echo $this->cart->cartData['paymentName']; ?> </div>
        <?php } ?>
        <?php if (VmConfig::get ('show_tax')) { ?>
        <div align="right"><?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('paymentTax', '', $this->cart->pricesUnformatted['paymentTax'], FALSE) . "</span>"; ?> </div>
        <?php } ?>
        <div align="right"><?php // Why is this commented? what is with payment discounts? echo "<span  class='priceColor2'>".$this->cart->pricesUnformatted['paymentDiscount']."</span>"; ?></div>
        <div align="right"><?php  echo $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->pricesUnformatted['salesPricePayment'], FALSE); ?> </div>
    </div>
    <?php } ?>
    <div>
        <div colspan="4">&nbsp;</div>
        <div colspan="<?php echo $colspan ?>">
            <hr/>
        </div>
    </div>
    <div class="sectiontableentry2">
        <div colspan="4" align="right" class="total-sectiontab"><?php echo JText::_ ('COM_VIRTUEMART_CART_TOTAL') ?>:</div>

        <?php if (VmConfig::get ('show_tax')) { ?>
        <div align="right"> <?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billTaxAmount', '', $this->cart->pricesUnformatted['billTaxAmount'], FALSE) . "</span>" ?> </div>
        <?php } ?>
        <div align="right"> <?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billDiscountAmount', '', $this->cart->pricesUnformatted['billDiscountAmount'], FALSE) . "</span>" ?> </div>
        <div align="right"><strong><?php echo $this->currencyDisplay->createPriceDiv ('billTotal', '', $this->cart->pricesUnformatted['billTotal'], FALSE); ?></strong></div>
    </div>
    <?php
    if ($this->totalInPaymentCurrency) {
    ?>

    <div class="sectiontableentry2">
        <div colspan="4" align="right"><?php echo JText::_ ('COM_VIRTUEMART_CART_TOTAL_PAYMENT') ?>:</div>

        <?php if (VmConfig::get ('show_tax')) { ?>
        <div align="right"></div>
        <?php } ?>
        <div align="right"></div>
        <div align="right"><strong><?php echo $this->totalInPaymentCurrency;   ?></strong></div>
    </div>
        <?php
    }
    ?>


    </div>
</div>
