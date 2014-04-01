<?php
defined('_JEXEC') or die('');

/**
 * Renders the email for the user send in the registration process
 * @package	VirtueMart
 * @subpackage User
 * @author Max Milbers
 * @author Valérie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: view.html.php 2459 2010-07-02 17:30:23Z milbo $
 */
$li = '<br />';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="initial-scale=1.0">    <!-- So that mobile webkit will display zoomed in -->
    <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->

    <title><?php echo JText::sprintf('COM_VIRTUEMART_WELCOME_USER', $this->user->name); ?></title>

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
<?php echo JText::sprintf('COM_VIRTUEMART_WELCOME_USER', $this->user->name); ?>
</div>
<br>

	<!-- content below -->
    
				    <?php
				    if (!empty($this->activationLink)) {
					$activationLink = '<a class="default" href="' . JURI::root() . $this->activationLink . '">' . JText::_('COM_VIRTUEMART_LINK_ACTIVATE_ACCOUNT') . '</a>';
					echo $li;
					echo $activationLink . $li;
				    }
				    ?>
			
</td>
</tr>
<tr>
<td class="container-padding" bgcolor="#ffffff" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: Helvetica, sans-serif; color: #333;" align="left">
<br>
<br>

<div style="font-weight: bold; font-size: 18px; line-height: 24px; color: #D03C0F; border-top: 1px solid #ddd;"><br><?php echo JText::_('COM_VIRTUEMART_SHOPPER_REGISTRATION_DATA') ?></div>
<br>
				    
				
				    <?php
				    echo JText::_('COM_VIRTUEMART_YOUR_LOGINAME')   . $this->user->username . $li;
				    echo JText::_('COM_VIRTUEMART_YOUR_DISPLAYED_NAME')   . $this->user->name . $li;
				    echo JText::_('COM_VIRTUEMART_YOUR_PASSWORD')  . $this->user->password_clear . $li. $li;
				    echo JText::_('COM_VIRTUEMART_YOUR_ADDRESS')  . $li;

				    //modify by Eddy for don't display some customer fields in registration email
				    foreach ($this->userFields['fields'] as $userField) {
						if (!empty($userField['value']) && $userField['type'] != 'delimiter' && $userField['type'] != 'BT' && $userField['type'] != 'hidden' && $userField['name'] !='newsletter' && $userField['name'] !='agreed') {
						    echo $userField['title'] . ': ' . $userField['value'] . $li;
	
						}
				    }
				    ?>
				

    <!-- content above -->
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