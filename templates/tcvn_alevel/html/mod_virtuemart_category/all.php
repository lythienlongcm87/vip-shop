<?php // no direct access
defined('_JEXEC') or die('Restricted access');
//JHTML::stylesheet ( 'menucss.css', 'modules/mod_virtuemart_category/css/', false );
$categoryModel->addImages($categories);
?>
<ul class="menu <?php echo $class_sfx ?>" >
<?php foreach ($categories as $category) {
    //echo($category->images[0]->file_url_thumb);
     $active_menu = '';
    $caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category->virtuemart_category_id);
    $cattext ='<img class="img-categorys"  src="' . JURI::base() . $category->images[0]->file_url_thumb . '">' . $category->category_name;
    //if ($active_category_id == $category->virtuemart_category_id) $active_menu = 'class="active"';
    if (in_array( $category->virtuemart_category_id, $parentCategories)) $active_menu = 'class="active '.$category->category_name .'"';
    else $active_menu = 'class="'.$category->category_name .'"';
    ?>

    <li <?php echo $active_menu ?>>
        <div>
           <?php echo JHTML::link($caturl, $cattext); ?>
            <span class="arrow"></span>
        </div>

    <?php if ($category->childs ) {
?>
        <ul class="menu<?php echo $class_sfx; ?>">
            <?php
                //$categoryModel->addImages($category->childs);
                foreach ($category->childs as $child) {

                    //echo($child->images[0]->file_url_thumb);
                    $caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$child->virtuemart_category_id);
                    $cattext = $child->category_name;
                    ?>
            <li class="<?php echo $cattext; ?>">
                <div >
                    <?php echo JHTML::link($caturl, $cattext); ?>
                </div>
            </li>
            <?php } ?>
        </ul>
    <?php 	} ?>
    </li>
    <?php
} ?>
</ul>
