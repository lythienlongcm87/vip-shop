<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<!--BEGIN Search Box -->
<div class="search">
    <?php
    if($text=='Search...'){
        $text = 'By Keyword';
    }
    $icon = '';
    
    ?>
    <form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&search=true&limitstart=0&virtuemart_category_id='.$category_id ); ?>" method="get">
        <div class="search<?php echo $params->get('moduleclass_sfx'); ?>">
            <?php $output = '<input style="height:16px;vertical-align :middle;" name="keyword" id="mod_virtuemart_search" maxlength="'.$maxlength.'" alt="'.$button_text.'" class="inputbox'.$moduleclass_sfx.'" type="text" size="'.$width.'" value="'.$text.'"  onblur="if(this.value==\'\') this.value=\''.$text.'\';" onfocus="if(this.value==\''.$text.'\') this.value=\'\';" />';
            $image = JURI::base().'components/com_virtuemart/assets/images/vmgeneral/search.png' ;

                if ($button) :
                    if ($imagebutton) :
                        $button = '<input style="vertical-align :middle;height:16px;border: 1px solid #CCC;" type="image" value="'.$button_text.'" class="button'.$moduleclass_sfx.'" src="'.$image.'" onclick="this.form.keyword.focus();"/>';
                    elseif ($moduleclass_sfx == "home-search") :
                        $button = '<button onclick="this.form.keyword.focus();" class = "btn btn-primary button'.$moduleclass_sfx.'" type="submit"><i class="icon-search icon-white"></i></button>';
                    else :
                        $button = '<input type="submit" value="'.$button_text.'" class="btn btn-primary button'.$moduleclass_sfx.'" onclick="this.form.keyword.focus();"/>';
                    endif;
                    switch ($button_pos) :
                        case 'top' :
                            $button = $button.'<br />';
                            $output = $button.$output;
                            break;

                        case 'bottom' :
                            $button = '<br />'.$button;
                            $output = $output.$button;
                            break;

                        case 'right' :
                            $output = $output.$button;
                            break;

                        case 'left' :
                        default :
                            $output = $button.$output;
                            break;
                    endswitch;
                endif;

                echo $output;
            ?>
        </div>
        <input type="hidden" name="limitstart" value="0" />
        <input type="hidden" name="option" value="com_virtuemart" />
        <input type="hidden" name="view" value="category" />
    </form>
</div>

<!-- End Search Box -->
