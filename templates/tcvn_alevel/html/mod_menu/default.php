<?php
/*------------------------------------------------------------------------
# Joomla 2.5 Template - Menu Package
# ------------------------------------------------------------------------
# Author    Thecoders.vn
# Copyright Copyright (C) 2012 Thecoders.vn. All Rights Reserved.
# License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://thecoders.vn
# Live Demo: http://gatheme.com
# Technical Support:  Forum - http://laptrinhvien-vn.com
-------------------------------------------------------------------------*/

// No direct access.
defined('_JEXEC') or die;
$nav_dropdown = '';
if ( preg_match( '/nav-dropdown/', $class_sfx ) ) {
	$nav_dropdown = " nav-dropdown";
}
$nav_flyout = '';
if ( preg_match( '/nav-flyout/', $class_sfx ) ) {
	$nav_flyout = " nav-flyout";
}
$nav_stacked = '';
if ( preg_match( '/nav-stacked/', $class_sfx ) ) {
	$nav_stacked = " nav-stacked";
}
$nav_list = '';
if ( preg_match( '/nav-list/', $class_sfx ) ) {
	$nav_list = " nav-list";
}
// Note. It is important to remove spaces between elements.
?>

<ul class="menu nav <?php echo $class_sfx;?>"<?php
	$tag = '';
	if ($params->get('tag_id')!=NULL) {
		$tag = $params->get('tag_id').'';
		echo ' id="'.$tag.'"';
	}
?>>
<?php
foreach ($list as $i => &$item) :
	$class = 'item-'.$item->id;
	if ($item->id == $active_id) {
		$class .= ' current';
	}

	if (	$item->type == 'alias' &&
			in_array($item->params->get('aliasoptions'),$path)
		||	in_array($item->id, $path)) {
		$class .= ' active';
	}

	if (($item->deeper) && ($nav_dropdown)) {
		$class .= ' dropdown';
	}

	elseif ($item->deeper) {
		$class .= ' deeper';
	}

	if ($item->parent) {
		$class .= ' parent';
	}

	if (!empty($class)) {
		$class = ' class="'.trim($class) .'"';
	}

	echo '<li'.$class.'>';

	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
			require JModuleHelper::getLayoutPath('mod_menu', 'default_'.$item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
			break;
	endswitch;
	// The next item is deeper.
	if (($item->deeper) && ($nav_flyout)) {
		echo '<ul class="flyout-menu">';
	}
	elseif (($item->deeper) && ($nav_dropdown)){
		if ($item->level < 2) {
			echo '<ul class="dropdown-menu">';
		}
		else {
			echo '<ul class="flyout-menu">';
		}
	}
	elseif ($item->deeper) {
		echo '<ul>';
	}
	// The next item is shallower.
	elseif ($item->shallower) {
		echo '</li>';
		echo str_repeat('</ul></li>', $item->level_diff);
	}
	// The next item is on the same level.
	else {
		echo '</li>';
	}
endforeach;
?></ul>
