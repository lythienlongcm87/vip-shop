<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
    jQuery(document).ready(function($){

        // select element styling
        $('.tcvn-currency select').each(function(){
            var title 	= $('option:selected',this).text();
            var val 	= $('option:selected',this).val();

            if(val != '') {
                $(this).parent().addClass('selected');
            }

            $(this)
                .css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
                .after('<span class="select">' + title + '</span>')
                .change(function(){
                    txt = $('option:selected',this).text();
                    val = $('option:selected',this).val();

                    if(val != '')
                        $(this).parent().addClass('selected');
                    else
                        $(this).parent().removeClass('selected');

                    $(this).next().text(txt);
                })
        });
    });
</script>
<!-- Currency Selector Module -->
<?php echo $text_before ?>
<form class="tcvn-currency" action="<?php echo JURI::getInstance()->toString(); ?>" method="post">
    <span><?php echo JText::_('MOD_TCVN_VIRTUEMART_CURRENCIES_CHANGE_CURRENCIES')?></span>
	<?php echo JHTML::_('select.genericlist', $currencies, 'virtuemart_currency_id', 'class="inputbox"', 'virtuemart_currency_id', 'currency_txt', $virtuemart_currency_id) ; ?>
    <!-- <input class="button" type="submit" name="submit" value="<?php //echo JText::_('MOD_TCVN_VIRTUEMART_CURRENCIES_CHANGE_CURRENCIES') ?>" /> -->
</form>
