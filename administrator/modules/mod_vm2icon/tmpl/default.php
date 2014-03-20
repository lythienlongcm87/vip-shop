<?php
/**
 * @version		$Id: helper.php 1.0 2012-09-28
 * @package		mod_vm2icon
 * @copyright	Copyright (C) 2012 P. Kohl(Studio 42 France). All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

$admin = JURI::root(true).'/administrator/';
$document = JFactory::getDocument();
$document->addStyleSheet($admin.'modules/mod_vm2icon/assets/css/toolbar_images.css');

?>
<div id="cpanel">
<?php
foreach ($buttons as $view => $button) {
	if ($params->get($view,1) == 0) continue;
	if (!empty($button['vendor'])) {
		if ($button['vendor']=== true and !$isVendor )
		continue;
	} ?>
<div class="icon-wrapper">
	<div class="icon">
		<a href="<?php echo $button['link']; ?>">
			<span class="vmicon48 <?php echo $button['image'] ?>" ></span>
			<br /><?php echo $button['text']; ?>
		</a>
	</div>
</div>
<?php 
}
?>
</div>
