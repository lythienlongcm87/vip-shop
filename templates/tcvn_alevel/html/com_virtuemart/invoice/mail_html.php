<?php
/**
 *
 * Layout for the shopper mail, when he confirmed an ordner
 *
 * The addresses are reachable with $this->BTaddress, take a look for an exampel at shopper_adresses.php
 *
 * With $this->orderDetails['shipmentName'] or paymentName, you get the name of the used paymentmethod/shippmentmethod
 *
 * In the array order you have details and items ($this->orderDetails['details']), the items gather the products, but that is done directly from the cart data
 *
 * $this->orderDetails['details'] contains the raw address data (use the formatted ones, like BTaddress). Interesting informatin here is,
 * order_number ($this->orderDetails['details']['BT']->order_number), order_pass, coupon_code, order_status, order_status_name,
 * user_currency_rate, created_on, customer_note, ip_address
 *
 * @package	VirtueMart
 * @subpackage Cart
 * @author Max Milbers, Valerie Isaksen
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

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="initial-scale=1.0">    <!-- So that mobile webkit will display zoomed in -->
    <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->

    <title>2 columns to rows template | Antwort</title>

    <style type="text/css">
      
/* Resets: see reset.css for details */
.ReadMsgBody { width: 100%; background-color: #ebebeb;}
.ExternalClass {width: 100%; background-color: #ebebeb;}
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
body {margin:0; padding:0;}
table {border-spacing:0;}
table td {border-collapse:collapse;}
.yshortcuts a {border-bottom: none !important;}


/* Constrain email width for small screens */
@media screen and (max-width: 600px) {
    table[class="container"] {
        width: 95% !important;
    }
}

/* Give content more room on mobile */
@media screen and (max-width: 480px) {
    td[class="container-padding"] {
        padding-left: 12px !important;
        padding-right: 12px !important;
    }
 }

      
    /* Styles for forcing columns to rows */
    @media only screen and (max-width : 600px) {

        /* force container columns to (horizontal) blocks */
        td[class="force-col"] {
            display: block;
            padding-right: 0 !important;
        }
        table[class="col-2"] {
            /* unset table align="left/right" */
            float: none !important;
            width: 100% !important;

            /* change left/right padding and margins to top/bottom ones */
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }

        /* remove bottom border for last column/row */
        table[id="last-col-2"] {
            border-bottom: none !important;
            margin-bottom: 0;
        }

        /* align images right and shrink them a bit */
        img[class="col-2-img"] {
            float: right;
            margin-left: 6px;
            max-width: 130px;
        }
    }


    </style>

</head>
<body style="margin:0; padding:10px 0;" bgcolor="#ebebeb" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<br>

<!-- 100% wrapper (grey background) -->
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#ebebeb">
  <tr>
    <td align="center" valign="top" bgcolor="#ebebeb" style="background-color: #ebebeb;">

      <!-- 600px container (white background) -->
      <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" bgcolor="#ffffff">
        <tr>
          <td class="container-padding" bgcolor="#ffffff" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 14px; line-height: 20px; font-family: Helvetica, sans-serif; color: #333;">
            <br>

            <div style="font-weight: bold; font-size: 18px; line-height: 24px; color: #D03C0F;">
              New Test Quick Two Columns to Rows Demo
            </div>
            <br>
			<?php
// Shop desc for shopper and vendor
			if ($this->recipient == 'shopper') {
			    echo $this->loadTemplate('header');
			}
// Message for shopper or vendor
			echo $this->loadTemplate($this->recipient);
// render shipto billto adresses
			echo $this->loadTemplate('shopperaddresses');
// render price list
			echo $this->loadTemplate('pricelist');
// more infos
			echo $this->loadTemplate($this->recipient . '_more');
// end of mail
			echo $this->loadTemplate('footer');
			?>
    </td>
        </tr>
      </table>
      <!--/600px container -->

    </td>
  </tr>
</table>
<!--/100% wrapper-->
<br>
<br>
</body>
</html>