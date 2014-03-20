<?php
/*
# ------------------------------------------------------------------------
# TCVN Rotating Image Module for Joomla 2.5
# ------------------------------------------------------------------------
# Copyright(C) 2008-2012 www.Thecoders.vn. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: Thecoders.vn
# Websites: http://Thecoders.com
# Forum:    http://laptrinhvien-vn.com/forum/
# ------------------------------------------------------------------------
*/
// no direct access
defined('_JEXEC') or die('Restricted access');

$doc = JFactory::getDocument();

$doc->addScript('modules/mod_tcvn_rotating_image/assets/js/jquery.iosslider.js', 'text/javascript');
$doc->addScript('modules/mod_tcvn_rotating_image/assets/js/jquery.easing-1.3.js', 'text/javascript');
$doc->addScript('modules/mod_tcvn_rotating_image/assets/js/script.js', 'text/javascript');
$doc->addStyleSheet('modules/mod_tcvn_rotating_image/assets/css/default.css', 'text/css');
?>
<style type="text/css">
#tcvnRotatingImage<?php echo $module->id; ?> {
	width: <?php echo $params->get('moduleWidth', '1000')?>px;
	height: <?php echo $params->get('moduleHeight', '300')?>px;
	margin:0 auto;
}
#tcvnRotatingImage<?php echo $module->id; ?> .tcvntSlider .tcvnItem .image {
	height: <?php echo $params->get('moduleHeight', '300')?>px;
	left: 0;
	position: absolute;
	top: 0;
	width: 100%;
}
#tcvnRotatingImage<?php echo $module->id; ?> .tcvntSlider .tcvnItem .text {
	position: absolute;
	right: 0;
	width: 180px;
	height: <?php echo (int)$params->get('moduleHeight', '300')-40;?>px;
	padding: 20px;
}
#tcvnRotatingImage<?php echo $module->id; ?> .tcvntSlider .tcvnItem .text .bg {
	position: absolute;
	top: 0;
	right: 0;
	width: 215px;
	height: <?php echo (int)$params->get('moduleHeight', '300');?>px;
	background: #000;
	opacity: 0.5;
}
</style>
<div id="tcvnRotatingImage" style="position: relative; overflow: hidden;">
    <div id="tcvnRotatingImage<?php echo $module->id; ?>" class="tcvnRotatingImage">

        <div class="tcvntSlider">
            <?php for($i=0; $i < count($slides); $i++) : ?>
                <div class="tcvnItem" id="<?php echo 'tcvnItem'.$i;?>" data="<?php echo $slides[$i]->easing; ?>">
                    <div class="image"><img src="<?php echo $slides[$i]->img; ?>" style="width:100%"></div>
                    <?php if($slider->src == 'list') echo $slides[$i]->text; ?>
                    <?php if($slider->src == 'art' && ($slider->art->showtitle || $slider->art->showreadmore)) : ?>
                    <div class="text">
                        <div class="bg"></div>

						<?php if($slider->art->showtitle) : ?>
                        <div class="title">
                            <span><?php echo $slides[$i]->title; ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if($slider->art->showintro) : ?>
                        <div class = 'desc'>
                            <span><?php echo $slides[$i]->intro;?></span>
                        </div>
                        <?php endif; ?>

                        <?php if($slider->art->showreadmore) : ?>
                        <div class = 'button'>
                            <a href="<?php echo $slides[$i]->link;?>"><span>Read More &rsaquo;</span></a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>

        <?php if($params->get('navigation','1')=='1') : ?>
        <div class="tcvnRotatingImageButtons">
            <?php for($i=0; $i<count($slides); $i++) : ?>
                        <div class="button"></div>
            <?php endfor; ?>
        </div>
        <?php endif; ?>

    </div>
</div>