<?php
/*=========================================================================
# Joomla 2.5 Template - Red Design
# =========================================================================
# Author    Thecoders.vn
# Copyright Copyright (C) 2013 Thecoders.vn. All Rights Reserved.
# License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://thecoders.vn
# Live Demo: http://gatheme.com
# Technical Support:  Forum - http://laptrinhvien-vn.com
  =======================================================================*/

// No direct access.
defined('_JEXEC') or die;

/**
 * This is a file to add template specific chrome to module rendering.  To use it you would
 * set the style attribute for the given module(s) include in your template to use the style
 * for each given modChrome function.
 *
 * This gives template designers ultimate control over how modules are rendered.
 *
 * NOTICE: All chrome wrapping methods should be named: modChrome_{STYLE} and take the same
 * three arguments.
 */

/**
 * Custom module chrome, echos the whole module in a <div> and the header in <h{x}>. The level of
 * the header can be configured through a 'headerLevel' attribute of the <jdoc:include /> tag.
 * Defaults to <h3> if none given
 */
function modChrome_normal($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="moduletable <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}

function modChrome_style($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	if (!empty ($module->content)) : ?>
		<div class="moduletable <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <?php if ($module->showtitle != 0) : ?>
                <div class="title"><?php echo '<h' .$headerLevel .'>' .$module->title .'</h' .$headerLevel .'>'; ?></div>
            <?php endif; ?>
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}

function modChrome_xstyle($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	if (!empty ($module->content)) : ?>
		<div class="moduletable-xstyle <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <?php if ($module->showtitle != 0) : ?>
                <div class="title"><?php echo '<h' .$headerLevel .'>' .$module->title .'</h' .$headerLevel .'>'; ?>
                    <div class="right"><span></span></div>
                    <div class="left"><span></span></div>
                </div>

            <?php endif; ?>
            <?php echo $module->content; ?>
		</div>
	<?php endif;
}

function modChrome_right($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	if (!empty ($module->content)) : ?>
		<div class="mod-right right-wrapper <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <?php if ($module->showtitle != 0) : ?>
                <div class="title"><?php echo '<h' .$headerLevel .'>' .$module->title .'</h' .$headerLevel .'>'; ?></div>
            <?php endif; ?>
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}
function modChrome_xright($module, &$params, &$attribs)
{
    $headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
    if (!empty ($module->content)) : ?>
        <div class="right-wrapper <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <?php if ($module->showtitle != 0) : ?>
                <?php echo '<h' .$headerLevel .'>' .$module->title .'</h' .$headerLevel .'>'; ?>
            <?php endif; ?>
            <?php echo $module->content; ?>
        </div>
    <?php endif;
}
function modChrome_yright($module, &$params, &$attribs)
{
    $headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
    if (!empty ($module->content)) : ?>
        <div class="yright-wrapper <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <?php if ($module->showtitle != 0) : ?>
                <div class="yright-title">
                <?php echo '<h' .$headerLevel .'><span>' .$module->title .'</span></h' .$headerLevel .'>'; ?>
                </div>
            <?php endif; ?>
            <div class="yright-content">
                <?php echo $module->content; ?>
            </div>
        </div>
    <?php endif;
}
function modChrome_zright($module, &$params, &$attribs)
{
    $headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
    if (!empty ($module->content)) : ?>
        <div class="zright-wrapper <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <?php if ($module->showtitle != 0) : ?>
                <?php echo '<h' .$headerLevel .'>' .$module->title .'</h' .$headerLevel .'>'; ?>
            <?php endif; ?>
            <div class="content">
                <?php echo $module->content; ?>
            </div>
        </div>
    <?php endif;
}
function modChrome_zstyle($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	if (!empty ($module->content)) : ?>
		<div class="moduletable <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <?php if ($module->showtitle != 0) : ?>
                <?php echo '<h' .$headerLevel .'>' .$module->title .'</h' .$headerLevel .'>'; ?>
                <div class="modhdg1"><div class="modhdg2"><div class="modhdg3"></div></div></div>
            <?php endif; ?>
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}
function modChrome_menubootstrap($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="moduletable <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
        	<div class="navbar navbar-inverse">
                <div class="navbar-inner">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="#">Menu</a>
                    <div class="nav-collapse collapse">
                        <?php echo $module->content; ?>
                    </div>
                </div>
        	</div>
		</div>
	<?php endif;
}

function modChrome_footer($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 4;
	if (!empty ($module->content)) : ?>
		<?php if ($module->showtitle) : ?>
			<?php echo '<h' .$headerLevel .'>' .$module->title .'</h' .$headerLevel .'>'; ?>
		<?php endif; ?>
		<?php echo $module->content; ?>
	<?php endif;
}

function modChrome_sidebar($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
    <div class="moduletable <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
		<?php if ($module->showtitle) : ?>
			<h3><?php echo $module->title; ?></h3>
		<?php endif; ?>
		<?php echo $module->content; ?>
    </div>
	<?php endif;
}
function modChrome_tcvntabs($module, $params, $attribs)
{
    $area = isset($attribs['id']) ? (int) $attribs['id'] :'1';
    $area = 'area-'.$area;

    static $modulecount;
    static $modules;

    if ($modulecount < 1) {
        $modulecount = count(JModuleHelper::getModules($module->position));
        $modules = array();
    }

    if ($modulecount == 1) {
        $temp = new stdClass();
        $temp->content = $module->content;
        $temp->title = $module->title;
        $temp->params = $module->params;
        $temp->id=$module->id;
        $modules[] = $temp;
        // list of moduletitles
        // list of moduletitles
        //var_dump($document->baseurl); die();
?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('.product-presenter-omgly').productPresenter({
                    categoryNames: [<?php
                        foreach($modules as $rendermodule) {
                            echo '"'.$rendermodule->title.'",';
                        }
                    ?>]

                });

            });
        </script>
<?php
        echo '<div class="product-presenter-omgly" id="product-presenter">';
        foreach($modules as $rendermodule) {
            $counter ++;

            echo '<div id="product-container" class="product-container module_'.$rendermodule->id.'">';
            echo $rendermodule->content;
            if ($counter!= count($modules))
            {
                //echo '<a href="#" class="unseen" onclick="nexttab(\'module_'. $rendermodule->id.'\');return false;" id="next_'.$rendermodule->id.'">'.JText::_('TPL_BEEZ5_NEXTTAB').'</a>';
            }
            echo '</div>';
        }
        $modulecount--;
        echo '</div>';
    } else {
        $temp = new stdClass();
        $temp->content = $module->content;
        $temp->params = $module->params;
        $temp->title = $module->title;
        $temp->id = $module->id;
        $modules[] = $temp;
        $modulecount--;
    }

}
function modChrome_tcvntabs2($module, $params, $attribs)
{
    $area = isset($attribs['id']) ? (int) $attribs['id'] :'1';
    $area = 'area-'.$area;

    static $modulecount;
    static $modules;

    if ($modulecount < 1) {
        $modulecount = count(JModuleHelper::getModules($module->position));
        $modules = array();
    }

    if ($modulecount == 1) {
        $temp = new stdClass();
        $temp->content = $module->content;
        $temp->title = $module->title;
        $temp->params = $module->params;
        $temp->id=$module->id;
        $modules[] = $temp;
        // list of moduletitles
        // list of moduletitles
        echo '<div id="'. $area.'" class="tabouter"><ul class="tabs">';

        foreach($modules as $rendermodule) {
            echo '<li class="tab"><a href="#" id="link_'.$rendermodule->id.'" class="linkopen" onclick="tabshow(\'module_'. $rendermodule->id.'\');return false">'.$rendermodule->title.'</a></li>';
        }
        echo '</ul>';
        $counter=0;
        // modulecontent
        foreach($modules as $rendermodule) {
            $counter ++;

            echo '<div tabindex="-1" class="tabcontent tabopen" id="module_'.$rendermodule->id.'">';
            echo $rendermodule->content;
            if ($counter!= count($modules))
            {
                //echo '<a href="#" class="unseen" onclick="nexttab(\'module_'. $rendermodule->id.'\');return false;" id="next_'.$rendermodule->id.'">'.JText::_('TPL_BEEZ5_NEXTTAB').'</a>';
            }
            echo '</div>';
        }
        $modulecount--;
        echo '</div>';
    } else {
        $temp = new stdClass();
        $temp->content = $module->content;
        $temp->params = $module->params;
        $temp->title = $module->title;
        $temp->id = $module->id;
        $modules[] = $temp;
        $modulecount--;
    }

}

