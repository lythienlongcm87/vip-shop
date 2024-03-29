<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_latest
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<ul class="latestnews<?php echo $moduleclass_sfx; ?>">
<?php foreach ($list as $item) :  ?>
	<li>
        <div class="latestnewstitle">
            <?php echo $item->title; ?>
        </div>
		<a href="<?php echo $item->link; ?>">
			<?php echo JText::_(TCVN_READ_MORE)?>
        </a>
	</li>
<?php endforeach; ?>
</ul>
