<?php
/*
# ------------------------------------------------------------------------
# TCVN Content Camera Module for Joomla 2.5
# ------------------------------------------------------------------------
# Copyright(C) 2008-2012 www.Thecoders.vn. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-2.0.html GNU/GPL
# Author: Thecoders.vn
# Websites: http://Thecoders.com
# ------------------------------------------------------------------------
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div class="camera_wrap <?php echo $skin; ?>" id="camera_wrap_<?php echo $module->id;?>" style="height:<?php echo $moduleHeight;?>;width:<?php echo $moduleWidth;?>">
	<?php foreach($list as $key => $row): ?>
    	<?php require($itemLayoutPath); ?>
    <?php endforeach;?>
</div>