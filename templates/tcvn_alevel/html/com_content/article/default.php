<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params		= $this->item->params;
$images 	= json_decode($this->item->images);
$urls 		= json_decode($this->item->urls);
$canEdit	= $this->item->params->get('access-edit');
$user		= JFactory::getUser();

?>
<div class="row-fluid">
	<div class="tcvn-border-rad item-page<?php echo $this->pageclass_sfx?> ">
		<?php if ($canEdit ||  $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
		<!-- Item Actions -->
		<div class="btn-group actions">
			<?php if (!$this->print) : ?>
			<?php if ($params->get('show_print_icon')) : ?>
			<span class="btn print-icon"> <?php echo JHtml::_('icon.print_popup',  $this->item, $params); ?> </span>
			<?php endif; ?>
			<?php if ($params->get('show_email_icon')) : ?>
			<span class="btn email-icon"> <?php echo JHtml::_('icon.email',  $this->item, $params); ?> </span>
			<?php endif; ?>
			<?php if ($canEdit) : ?>
			<span class="btn edit-icon"> <?php echo JHtml::_('icon.edit', $this->item, $params); ?> </span>
			<?php endif; ?>
			<?php else : ?>
			<span class="btn print-icon"> <?php echo JHtml::_('icon.print_screen',  $this->item, $params); ?> </span>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<?php if ($this->params->get('show_page_heading', 1)) : ?>
		<!-- Page Title -->
		<div class="page-header">
			<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
		</div>
		<?php endif; ?>
		<?php
		if (!empty($this->item->pagination) AND $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative)
		{
		echo $this->item->pagination;
		}
		?>
		<?php if ($params->get('show_title')) : ?>
		<div class="page-header">
			<h3>
				<?php if ($params->get('link_titles') && !empty($this->item->readmore_link)) : ?>
				<a href="<?php echo $this->item->readmore_link; ?>"> <?php echo $this->escape($this->item->title); ?></a>
				<?php else : ?>
				<?php echo $this->escape($this->item->title); ?>
				<?php endif; ?>
			</h3>
			<?php if ($params->get('show_author') && !empty($this->item->author )) : ?>
			<p class="createdby">
				<?php $author = $this->item->created_by_alias ? $this->item->created_by_alias : $this->item->author; ?>
				<?php if (!empty($this->item->contactid) && $params->get('link_author') == true): ?>
				<?php
				$needle = 'index.php?option=com_contact&view=contact&id=' . $this->item->contactid;
				$item = JSite::getMenu()->getItems('link', $needle, true);
				$cntlink = !empty($item) ? $needle . '&Itemid=' . $item->id : $needle;
				?>
				<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', JRoute::_($cntlink), $author)); ?>
				<?php else: ?>
				<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
				<?php endif; ?>
			</p>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<?php $useDefList = (($params->get('show_category')) or ($params->get('show_parent_category'))
		or ($params->get('show_create_date')) or ($params->get('show_modify_date')) or ($params->get('show_publish_date'))
		or ($params->get('show_hits'))); ?>
		<?php if ($useDefList) : ?>
		<!-- Item Info -->
		<p class="article-info">
			<?php endif; ?>
			<?php if ($params->get('show_create_date')) : ?>
			<span class="create"><i class="icon-time"></i> <?php echo JText::sprintf(JHtml::_('date', $this->item->created, JText::_('DATE_FORMAT_LC1'))); ?> </span>
			<?php endif; ?>
			<?php if ($params->get('show_parent_category') && $this->item->parent_slug != '1:root') : ?>
			<span class="parent-category-name">
			<?php $title = $this->escape($this->item->parent_title);
				$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)).'">'.$title.'</a>';?>
			<?php if ($params->get('link_parent_category') and $this->item->parent_slug) : ?>
			<?php echo JText::sprintf($url); ?>
			<?php else : ?>
			<?php echo JText::sprintf($title); ?>
			<?php endif; ?>
			</span>
			<?php endif; ?>
			<?php if ($params->get('show_category')) : ?>
			<span class="category-name">
			<?php $title = $this->escape($this->item->category_title);
				$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)).'">'.$title.'</a>';?>
			<?php if ($params->get('link_category') and $this->item->catslug) : ?>
			<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $url); ?>
			<?php else : ?>
			<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $title); ?>
			<?php endif; ?>
			</span>
			<?php endif; ?>
			<!--
			<?php if ($params->get('show_publish_date')) : ?>
			<span class="published"> <?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', JHtml::_('date', $this->item->publish_up, JText::_('DATE_FORMAT_LC1'))); ?> </span>
			<?php endif; ?>
			<?php if ($params->get('show_modify_date')) : ?>
				<span class="modified"> <?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $this->item->modified, JText::_('DATE_FORMAT_LC1'))); ?> </span>
			<?php endif; ?>
			-->
			<?php if ($params->get('show_hits')) : ?>
			<span class="hits pull-right"><i class="icon-signal"></i> <?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?> </span>
			<?php endif; ?>
			<?php if ($useDefList) : ?>
		</p>
		<?php endif; ?>
		<?php if ($this->item->event->beforeDisplayContent) : ?>
		<!-- Rating Plugin -->
		<div class="item-rating"> <?php echo $this->item->event->beforeDisplayContent; ?> </div>
		<?php endif ; ?>
		<?php  if (!$params->get('show_intro')) :
			echo $this->item->event->afterDisplayTitle;
		endif; ?>
		<?php if (isset($urls) AND ((!empty($urls->urls_position) AND ($urls->urls_position=='0')) OR  ($params->get('urls_position')=='0' AND empty($urls->urls_position) ))
			OR (empty($urls->urls_position) AND (!$params->get('urls_position')))): ?>
		<!-- Item URLS -->
		<?php echo $this->loadTemplate('links'); ?>
		<?php endif; ?>
		<?php if (isset ($this->item->toc)) : ?>
		<!-- Table of Contents -->
		<?php echo $this->item->toc; ?>
		<?php endif; ?>
		<?php if ($params->get('access-view')):?>
		<?php  if (isset($images->image_fulltext) and !empty($images->image_fulltext)) : ?>
		<?php $imgfloat = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext; ?>
		<div class="img-fulltext-<?php echo htmlspecialchars($imgfloat); ?> pull-<?php echo htmlspecialchars($imgfloat); ?>"> <img
		<?php if ($images->image_fulltext_caption):
			echo 'class="caption"'.' title="' .htmlspecialchars($images->image_fulltext_caption) .'"';
		endif; ?>
		src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>"/> </div>
		<?php endif; ?>
		<?php
		if (!empty($this->item->pagination) AND $this->item->pagination AND !$this->item->paginationposition AND !$this->item->paginationrelative):
		echo $this->item->pagination;
		endif;
		?>
		<!-- Item Content --> 
		<?php echo $this->item->text; ?> 
		<!-- Pagination -->
		<?php
		if (!empty($this->item->pagination) AND $this->item->pagination AND $this->item->paginationposition AND!$this->item->paginationrelative):
		 echo $this->item->pagination;?>
		<?php endif; ?>
		<?php if (isset($urls) AND ((!empty($urls->urls_position)  AND ($urls->urls_position=='1')) OR ( $params->get('urls_position')=='1') )): ?>
		<?php echo $this->loadTemplate('links'); ?>
		<?php endif; ?>
		<?php //optional teaser intro text for guests ?>
		<?php elseif ($params->get('show_noauth') == true and  $user->get('guest') ) : ?>
		<?php echo $this->item->introtext; ?>
		<?php //Optional link to let them register to see the whole article. ?>
		<?php if ($params->get('show_readmore') && $this->item->fulltext != null) :
			$link1 = JRoute::_('index.php?option=com_users&view=login');
			$link = new JURI($link1);?>
		<!-- Readmore -->
		<p class="readmore"> <a class="btn btn-small btn-primary" href="<?php echo $link; ?>">
			<?php $attribs = json_decode($this->item->attribs);  ?>
			<?php
			if ($attribs->alternative_readmore == null) :
				echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
			elseif ($readmore = $this->item->alternative_readmore) :
				echo $readmore;
				if ($params->get('show_readmore_title', 0) != 0) :
					echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
				endif;
			elseif ($params->get('show_readmore_title', 0) == 0) :
				echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
			else :
				echo JText::_('COM_CONTENT_READ_MORE');
				echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
			endif; ?>
			</a> </p>
		<?php endif; ?>
		<?php endif; ?>
		<?php
		if (!empty($this->item->pagination) AND $this->item->pagination AND $this->item->paginationposition AND $this->item->paginationrelative):
		 echo $this->item->pagination;?>
		<?php endif; ?>
		<!-- Item Nav --> 
		<?php echo $this->item->event->afterDisplayContent; ?> 
	</div>
</div>