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
defined('_JEXEC') or die;
?>
<div data-thumb="<?php echo $row->thumbnail; ?>" data-src="<?php echo $row->mainImage; ?>">
    <div class="camera_caption fadeFromBottom">
        <!-- Show Title -->
        <?php if($showTitlle) { ?>
       		<h3 class="tcvn-title">
        	<?php if($linkOnTitle) { ?>
        		<a target="<?php echo $openTarget; ?>" title="<?php echo $row->title; ?>" href="<?php echo $row->link;?>">
        			<?php echo $row->title; ?>
        		</a>
        	<?php } else { ?>
        		<?php echo $row->title; ?>
        	<?php } ?>
        	</h3>
        <?php } ?>
        
        <!-- Show Description -->
        <?php if($showDesc) { ?>
       		<?php echo $row->description;?>
        <?php } ?>
        
        <!-- Show readmore button -->
        <?php if($showReadmore) { ?>
        	<a href="<?php echo $row->link; ?>" class="tcvn-more" title="<?php echo $row->title; ?>"><?php echo JText::_("more...");?></a>
        <?php } ?>
    </div>
</div>