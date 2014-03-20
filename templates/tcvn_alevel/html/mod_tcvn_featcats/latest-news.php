<?php
/*------------------------------------------------------------------------
# mod_tcvn_featcats - TCVN Articles Featured Categories
# ------------------------------------------------------------------------
# author    Thecoders.vn
# copyright Copyright(C) 2012 Thecoders.vn. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://thecoders.vn
# Technical Support:  Forum - http://laptrinhvien-vn.com
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;

$link_cats   = $params->get('link_cats', 1);
$show_image  = $params->get('show_image', 0);
$show_more   = $params->get('show_more');
$link_target = $params->get('link_target');
?>
<div id="latest-news">
	<?php foreach($cats as $cat) : ?>
    	<?php if($cat->articles) : ?>
        	<?php foreach($cat->articles as $article) : 			
				if($params->get('link_image',0)) :
					$image = '<a href="' . $article->link . '"' .($link_target == 1 ? ' target="_blank"' : '') . '>' . $article->image . '</a>';
				else :
					$image = $article->image;
				endif;
				if($params->get('bold_firstsentence', 0)) :
					$regex = '/^(.*?)[\.\?!]\s/';
					$article->displayIntrotext =(preg_match($regex, $article->displayIntrotext) == 1 ? preg_replace($regex, '<strong>$0</strong>', $article->displayIntrotext) : '<strong>'.$article->displayIntrotext.'</strong>'); 	
				endif; ?>
                <div class="item">
                    <h5><?php echo $article->title; ?> (<?php echo $article->displayHits; ?>)</h5>
                    <p><?php echo $image; ?><?php echo $article->displayIntrotext; ?></p>
                    <p>
                    	<span class="date"><?php echo $article->displayDate; ?></span>
                        <span class="readmore">
						<a class="tcvn-title <?php echo $article->active; ?>" href="<?php echo $article->link; ?>"<?php echo($link_target == 1 ? ' target="_blank"' : ''); ?>><?php echo JText::_('MOD_TCVN_FEATCATS_READ_MORE'); ?> &gt;&gt;</a>
                        </span>
                        <div class="clear"></div>
                    </p>
                </div>
            <?php endforeach; ?>
    	<?php endif; ?>
    <?php endforeach; ?>
</div>