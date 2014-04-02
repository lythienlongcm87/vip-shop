<?php
/*=========================================================================
# Joomla 2.5 Template - Alevel Shop
# =========================================================================
# Author    TheCoders.vn
# Copyright Copyright (C) 2013 Thecoders.vn. All Rights Reserved.
# License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://thecoders.vn
# Live Demo: http://gatheme.com
# Technical Support:  Forum - http://laptrinhvien-vn.com
  =======================================================================*/

// No direct access.
defined('_JEXEC') or die;

include_once JPATH_ROOT . "/templates/" . $this->template . '/libs/groups.php';
include_once JPATH_ROOT . "/templates/" . $this->template . '/libs/class.php';
include_once JPATH_ROOT . "/templates/" . $this->template . '/libs/variables.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<jdoc:include type="head" />
<?php
    $document = JFactory::getDocument();

    $document->addStyleSheet(JURI::base() . 'templates/system/css/system.css');
    $document->addStyleSheet(JURI::base() . 'templates/system/css/general.css');
    $document->addStyleSheet(JURI::base() . 'templates/' . $this->template . '/css/default.css');
    $document->addStyleSheet(JURI::base() . 'templates/' . $this->template . '/css/template' . $direction . '.css');
    $document->addStyleSheet(JURI::base() . 'templates/' . $this->template . '/css/menu' . $direction . '.css');
    $document->addStyleSheet(JURI::base() . 'templates/' . $this->template . '/css/modules' . $direction . '.css');
    $document->addStyleSheet(JURI::base() . 'templates/' . $this->template . '/css/' . $color .'.css');
    $document->addStyleSheet(JURI::base() . 'templates/' . $this->template . '/css/responsive' . $direction . '.css');
	$document->addStyleSheet(JURI::base() . 'templates/' . $this->template . '/css/bootstrap' . $direction . '.css');
	$document->addStyleSheet(JURI::base() . 'templates/' . $this->template . '/css/bootstrap-responsive' . $direction . '.css');

	//add by Eddy for responsive design table
	$document->addStyleSheet(JURI::base() . 'templates/' . $this->template . '/css/footable.core.css');
	
	
	if($customcss) {
    	$document->addStyleSheet(JURI::base() . 'templates/' . $this->template . '/css/custom.css');
	}
    if($loadjquery){
        $document->addScript(JURI::base() . 'templates/' . $this->template . '/js/jquery-1.8.3.min.js');
    }
    $document->addScript(JURI::base() . 'templates/' . $this->template . '/js/my.js' . $direction . '.js');
	$document->addScript(JURI::base() . 'templates/' . $this->template . '/js/bootstrap' . $direction . '.js');
	
	$document->addScript(JURI::base() . 'templates/' . $this->template . '/js/jquery.twzipcode.min.js');
	$document->addScript(JURI::base() . 'templates/' . $this->template . '/js/footable.js');
	
?>
</head>
<body id="tcvn-body" class="<?php echo ($menu->getActive() == $menu->getDefault()) ? "home " : ""; ?><?php echo ($classSfx != '') ? $classSfx : ""; ?>clearfix">
<?php
if($backtotop == 1) {
?>
<script type="text/javascript">

    jQuery(document).ready(function($) {
    	 //for responsive table
        $('.footable').footable();
        
        
        $('#tcvn-position-810 .tcvn-wrapper-inner').append('<div id="tcvn-backtop"><span>Back to Top</span></div>');
        $(window).scroll(function() {
            if($(window).scrollTop() != 0) {
                $('#tcvn-backtop').fadeIn();
            } else {
                $('#tcvn-backtop').fadeOut();
            }
        });
        $('#tcvn-backtop').click(function() {
            $('html, body').animate({scrollTop:0},500);
        });
        
        //Add by Eddy for twzipcode
        //find zipcode first
        //if have zipcode field use it for twzipcode default value
        //if not use default setup
        //$('#twzipcode').twzipcode();
        
        
        if($('#zip_field').length>0){
        $('#twzipcode').twzipcode({
		     zipcodeSel: $('#zip_field').val(),
             readonly: true
		  
	    });

        $('#twzipcode').change( function() {
 		   //console.log($('.zipcode').val());
            $('#zip_field').val($('.zipcode').val());
            $('#district_field').val($('.district').val());
            $('#county_field').val($('.county').val());
         });
	    
	    }else if($('#shipto_zip_field').length>0){
		    
	    	$('#twzipcode').twzipcode({
			     zipcodeSel: $('#shipto_zip_field').val(),
	             readonly: true
			  
		    });

	    	$('#twzipcode').change( function() {
	            $('#shipto_zip_field').val($('.zipcode').val());
	            $('#shipto_district_field').val($('.district').val());
	            $('#shipto_county_field').val($('.county').val());
	         });

	    }else{
		 $('#twzipcode').twzipcode({
		    readonly: true	 
	     });
		 
		}

       
        
        
        
    });

    
</script>
<?php } ?>
<div id="tcvn-wrapper">
    <div class="tcvn-wrapper-in">

        <!-- tcvn-top Blook -->
        <?php if ($this->countModules('user-1 or user-2')): ?>
        <div id="tcvn-top">
            <div class="tcvn-wrapper-inner">
                <div class="<?php echo $container; ?> main">              
                    <div class="<?php echo $row; ?>">
                        <!-- tcvn-user-2 Bloook -->
                        <?php if ($this->countModules('user-1')): ?>
                        <div id="tcvn-user-1" class="<?php echo $user12; ?>">
                            <jdoc:include type="modules" name="user-1" style="normal" />
                        </div>
                        <?php endif; ?>
                        <!-- tcvn-user-2 Bloook -->
                        <?php if ($this->countModules('user-2')): ?>
                        <div id="tcvn-user-2" class="<?php echo $user12; ?>">
                            <jdoc:include type="modules" name="user-2" style="normal" />
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;?>
         <!-- tcvn-header Blook -->
        <div id="tcvn-header">
            <div class="tcvn-wrapper-inner">
                <div class="<?php echo $container; ?> main">
                    <div class="<?php echo $row; ?>">
                        <div id="tcvn-logo" class="span<?php echo $logoWidth; ?>">
                            <?php if($logo): ?>
                                <a href="<?php echo JURI::base(); ?>">
                                    <img src="<?php echo $this->baseurl ?>/<?php echo htmlspecialchars($logo); ?>" alt="<?php echo htmlspecialchars($siteTitle);?>" />
                                </a>
                            <?php elseif($siteTitle) : ?>
                                <a href="<?php echo JURI::base(); ?>">
                                    <span class="site-title"><?php echo htmlspecialchars($siteTitle);?></span>
                                    <span class="site-description"><?php echo htmlspecialchars($siteDescription);?></span>
                                </a>
                            <?php else : ?>
                                <a href="<?php echo JURI::base(); ?>">
                                    <img alt="<?php echo $siteTitle; ?>" src="<?php echo JURI::base() . 'templates/' . $this->template; ?>/images/logo<?php echo $color; ?>.png" />
                                </a>
                            <?php endif;?>
                        </div>
                         <!-- tcvn-top-menu Blook -->
                        <?php if ($this->countModules('top-menu')): ?>
                        <div id="tcvn-top-menu" class="span<?php echo $menutop; ?>">
                            <div class="tcvn-module-inner">
                            <jdoc:include type="modules" name="top-menu" style="menubootstrap" />
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    	<!-- tcvn-slideshow Blook -->
		<?php if ($this->countModules('slideshow')): ?>
        <div id="tcvn-slideshow">
            <div class="<?php echo $container; ?> main">
                <div class="tcvn-wrapper-inner">
                    <jdoc:include type="modules" name="slideshow" style="normal" />
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- tcvn-slideshow-fluid Blook -->
        <?php if ($this->countModules('slideshow-fluid')): ?>
            <div id="tcvn-slideshow-fluid">
                <div class="main">
                    <div class="tcvn-wrapper-inner">
                        <jdoc:include type="modules" name="slideshow-fluid" style="normal" />
                    </div>
                </div>
            </div>
        <?php endif; ?>

         <!-- tcvn-position-123 Blook -->
		<?php if ($this->countModules('position-1 or position-2 or position-3')): ?>
        <div id="tcvn-position-13">
            <div class="tcvn-wrapper-inner">
                <div class="<?php echo $container; ?> main">
                    <div class="<?php echo $row; ?>">
                         <!-- tcvn-position-1 Blook -->
                        <?php if ($this->countModules('position-1')): ?>
                        <div id="tcvn-position-1" class="<?php echo $position13;?>">
                            <div class="tcvn-module-inner">
                                <jdoc:include type="modules" name="position-1" style="style" />
                            </div>
                        </div>
                        <?php endif; ?>

                         <!-- tcvn-position-2 Blook -->
                        <?php if ($this->countModules('position-2')): ?>
                        <div id="tcvn-position-2" class="<?php echo $position13;?>">
                            <div class="tcvn-module-inner">
                            <jdoc:include type="modules" name="position-2" style="style" />
                            </div>
                        </div>
                        <?php endif; ?>

                         <!-- tcvn-position-3 Blook -->
                        <?php if ($this->countModules('position-3')): ?>
                        <div id="tcvn-position-3" class="<?php echo $position13;?>">
                            <div class="tcvn-module-inner">
                            <jdoc:include type="modules" name="position-3" style="style" />
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- tcvn-position-4 Blook -->
		<?php if ($this->countModules('position-4')): ?>
        <div id="tcvn-position-4">
            <div class="tcvn-wrapper-inner">
                <div class="<?php echo $container; ?> main"> 
                    <div class="tcvn-module-inner">              
                    <jdoc:include type="modules" name="position-4" style="style" />
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- Breadcrumbs Block -->
        <?php if ($this->countModules('promotion')): ?>
            <div id="tcvn-promotion">
                <div class="tcvn-wrapper-inner">
                    <div class="<?php echo $container; ?> main">
                        <div class="tcvn-module-inner">
                        <jdoc:include type="modules" name="promotion" style="normal" />
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
         <!-- Breadcrumbs Block -->
        <?php if ($this->countModules('breadcrumbs')): ?>
        <div id="tcvn-breadcrumbs">
            <div class="tcvn-wrapper-inner">
                <div class="<?php echo $container; ?> main">
                    <div class="tcvn-module-inner">
                    <jdoc:include type="modules" name="breadcrumbs" style="normal" />
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
		 <!--Content + Left + Right Block -->
		<div id="tcvn-container">
            <div class="tcvn-wrapper-inner">
    			<div class="<?php echo $container; ?> main">

                    <div class="tcvn-main-inner">
                        <jdoc:include type="message" />
                        <div class="<?php echo $row; ?>">
                            <!-- Left Block -->
                            <?php if($this->countModules('left')) : ?>
                            <div id="tcvn-left" class="span<?php echo $columnwidth; ?>">
                                <div class="tcvn-module-inner">
                                    <jdoc:include type="modules" name="left" style="style" />
                                </div>
                            </div>
                            <?php endif; ?>
                            <!-- Component Block -->
                            <div id="tcvn-content" class="<?php echo $mainbody; ?>">
                                <?php if($this->countModules('position-11') or $this->countModules('position-12') or $this->countModules('position-13') ) : ?>
                                <div class="tcvn-module-inner">
                                    <jdoc:include type="modules" name="position-11" style="style" />
                                    <jdoc:include type="modules" name="position-12" style="tcvntabs" />
                                    <jdoc:include type="modules" name="position-13" style="xstyle" />
                                </div>
                                <?php endif; ?>
                                <div class="compoment">
                                    <jdoc:include type="component" />
                                </div>
                            </div>
                            <!-- Right Block -->
                            <?php if($this->countModules('right')) : ?>
                            <div id="tcvn-right" class="span<?php echo $columnwidth; ?>">
                                <div class="tcvn-module-inner">
                                    <jdoc:include type="modules" name="right" headerLevel="1" style="right" />
                                    <jdoc:include type="modules" name="right-1" style="xright" />
                                    <jdoc:include type="modules" name="right-2" style="yright" />
                                    <jdoc:include type="modules" name="right-3" style="zright" />
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
    				</div>
    			</div>
            </div>
		</div>
        <!-- tcvn-position-56 Blook -->
        <?php if ($this->countModules('position-5 or position-6')): ?>
            <div id="tcvn-position-56">
                <div class="tcvn-wrapper-inner">
                    <div class="<?php echo $container; ?> main">
                        <div class="main-inner">
                            <div class="<?php echo $row; ?>">
                                <!-- tcvn-position-5 Blook -->
                                <?php if ($this->countModules('position-5')): ?>
                                    <div id="tcvn-position-5" class="<?php echo $position56; ?>">
                                        <div class="tcvn-module-inner">
                                        <jdoc:include type="modules" name="position-5" style="style" />
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- tcvn-position-6 Blook -->
                                <?php if ($this->countModules('position-6')): ?>
                                    <div id="tcvn-position-6" class="<?php echo $position56;?>">
                                        <div class="tcvn-module-inner">
                                        <jdoc:include type="modules" name="position-6" style="style" />
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!-- tcvn-position-7 Blook -->
        <?php if ($this->countModules('position-7')): ?>
            <div id="tcvn-position-7">
                <div class="tcvn-wrapper-inner">
                    <div class="<?php echo $container; ?> main">
                        <div class="tcvn-module-inner">
                        <jdoc:include type="modules" name="position-7" style="style" />
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
		 <!-- tcvn-position-810 Blook -->
		<?php if ($this->countModules('position-8 or position-9 or position-10')): ?>
        <div id="tcvn-position-810">
            <div class="<?php echo $container; ?> main">
                <div class="tcvn-wrapper-inner">
                    <div class="<?php echo $row; ?>">

                        <!-- tcvn-position-8 Blook -->
                        <?php if ($this->countModules('position-8')): ?>
                        <div id="tcvn-position-8" class="<?php echo $position810;?>">
                            <div class="tcvn-module-inner">
                            <jdoc:include type="modules" name="position-8" headerLevel="2" style="style" />
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- tcvn-position-9 Blook -->
                        <?php if ($this->countModules('position-9')): ?>
                            <div id="tcvn-position-9" class="<?php echo $position810;?>">
                                <div class="tcvn-module-inner">
                                <jdoc:include type="modules" name="position-9" headerLevel="2" style="style" />
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- tcvn-position-10 Blook -->
                        <?php if ($this->countModules('position-10')): ?>
                            <div id="tcvn-position-10" class="<?php echo $position810;?>">
                                <div class="tcvn-module-inner">
                                <jdoc:include type="modules" name="position-10" headerLevel="2" style="style" />
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

		<div id="tcvn-footer">

            <!-- footer-menu Blook -->
			<?php if ($this->countModules('footer-menu')): ?>
            <div class="tcvn-wrapper-inner">
                <div id="footer-menu" class="<?php echo $container; ?> main">
				<jdoc:include type="modules" name="footer-menu" style="normal" />
                </div>
			</div>
			<?php endif; ?>

            <!-- copyright blook -->
            <div id="tcvn-copyright" class="<?php echo $container; ?> main">
                <div class="tcvn-copyright-inner">
                	<?php echo $this->params->get('copyright');?>
                    <!-- You can't remove copyright !-->
                    <p>Designed by <a href="http://TheCoders.vn" title="Free Joomla Extensions & Joomla Templates - TheCoders.vn">TheCoders.vn</a> - High quality free Joomla! Templates.</p>
                </div>
            </div>
            <!-- user-3 Blook -->

            <?php if ($this->countModules('user-3')): ?>
            <div id="user-3" class="<?php echo $container; ?> main">
                <div class="tcvn-wrapper-inner">
                <jdoc:include type="modules" name="user-3" style="normal" />
                </div>
            </div>
            <?php endif; ?>

		</div>
    </div>
</div>
<!-- Copyright -->
<div id="free-copyright" style="font-size:0; height:0; width:0; opacity:0; position:absolute">
TheCoders.vn - Free <a target="_blank" href="http://thecoders.vn/joomla-modules.html">Joomla Modules</a>, <a target="_blank" href="http://thecoders.vn/joomla-plugins.html">Joomla Plugins</a> and <a target="_blank" href="http://thecoders.vn/joomla-templates.html">Joomla Templates</a>.
</body>
</html>
