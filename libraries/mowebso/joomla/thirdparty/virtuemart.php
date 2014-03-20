<?php // no direct access
defined('_JEXEC') or die;

/**
 * MoWebSo Library
 *
 * The MoWebSo Is The Foundation For All MoWebSo Extensions
 *
 * @package 	    Backend / Library
 * @author 		    MoWebSo.com / Eugen Stranz
 * @copyright       (C) 2009 - 2013 ENYtheme e.K.
 * @license		    GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */


// Include The MoWebSo Library
jimport('mowebso.joomla.mowebso');

class MoWebSoVirtuemart extends Mowebso {

	// VirtueMart 2 Specific
	var $cssPath;
	var $cssFileName;

	/**
	 * Create An Instance of MoWebSo Class
	 *
	 * @return Mowebso
	 */
	public static function getInstance() {

		// Only Create The Object If It Doesn't Exist.
		if (!isset(self::$_instance)) {
			self::$_instance = new MoWebSoVirtuemart();
		}
		return self::$_instance;

	}

	/**
	 * Construct Method
	 *
	 * Is Called Automatically After Class Was Initialised
	 */
	function __construct() {

		// Execute The "__construct"
		// Function Of Parent Class
		parent::__construct();

		// Load General CSS For The Theme
		$this->loadGeneralCSS();

		// Load A Custom Language File
		// @TODO Add Language File To XML File
		$lang = JFactory::getLanguage();
		$lang->load('tpl_theme_virtuemart');
	}

	/**
	 * Load General CSS
	 *
	 * Method To Load General CSS
	 */
	function loadGeneralCSS() {

		// Should We Load The General CSS File From The Theme
		// Or Will The Template Care About This CSS
		if(!$this->supportedTemplate) {
			$this->addStyleSheet('default.css','templates/'.$this->templateName.'/html/com_virtuemart/themes/'.$this->themeName.'/assets/css/general/', true);
		}

	}

	/**
	 * Load Template CSS
	 *
	 * @param $template
	 * @param string $fileName
	 * @param string $path
	 */
	function loadTemplateCSS($template,$fileName='default.css',$path='') {

		// Build The Path
		if(empty($path)) {
			$path = 'templates/'.$this->templateName.'/html/com_virtuemart/themes/'.$this->themeName.'/assets/css/' .$template. '/';
		}

		// Include CSS File
		$this->addStyleSheet($fileName,$path);

	}

	/**
	 * Load Template JavaScript
	 *
	 * @param $template
	 * @param string $fileName
	 * @param string $path
	 */
	function loadTemplateJS($template,$fileName='default.js',$path='') {

		// Build The Path
		if(empty($path)) {
			$path = 'templates/'.$this->templateName.'/html/com_virtuemart/themes/'.$this->themeName.'/assets/js/' .$template. '/';
		}

		// Include JS File
		$this->addScript($fileName,$path);

	}

	/**
	 * Builds A grid Structure And Loads The Items Through A Template
	 *
	 * @param object $objectItems
	 * @param array $attributes
	 * @return string
	 */
	function gridStructure($objectItems, $attributes = array(), $extensionType = 'vmtheme') {

		// Define The Component (which must be 'com_virtuemart' in this class ;-) )
		(array_key_exists ( 'component', $attributes )) ? $component = $attributes ['component'] : $component = 'com_virtuemart';
		
		// Define The Grid Style
		(array_key_exists ( 'grid_style', $attributes )) ? $grid_style = $attributes ['grid_style'] : $grid_style = 'ns';
		
		// Define The Grid Style
		(array_key_exists ( 'equal_height', $attributes )) ? $equal_height = $attributes ['equal_height'] : $equal_height = true;

		// Define The Template
		(array_key_exists ( 'template', $attributes )) ? $template = $attributes ['template'] : $template = 'default';
		
		// Define The Module
		(array_key_exists ( 'module_name', $attributes )) ? $module = $attributes ['module_name'] : $module = 'default';

		// Define The Items To Show
		(array_key_exists ( 'show', $attributes )) ? $show = $attributes ['show'] : $show = 'products';
		
		// Define The Theme
		(array_key_exists ( 'theme', $attributes )) ? $theme = $attributes ['theme'] : $theme = 'centered';
		
		// Define Products Per Row
		(array_key_exists ( 'items_per_row', $attributes )) ? $itemsPerRow = $attributes ['items_per_row'] : $itemsPerRow = 3;
		
		// Define Number Of Items To Show
		(array_key_exists ( 'numb_of_items', $attributes )) ? $numbOfItems = $attributes ['numb_of_items'] : $numbOfItems = count($objectItems);
		
		// Define Products Per Row
		(array_key_exists ( 'vertical_separator', $attributes )) ? $showVerticalSeparator = $attributes ['vertical_separator'] : $showVerticalSeparator = true;
		
		// Define Products Per Row
		(array_key_exists ( 'horizontal_separator', $attributes )) ? $showHorizontalSeparator = $attributes ['horizontal_separator'] : $showHorizontalSeparator = true;

		// Define The Container Class
		(array_key_exists ( 'container_class', $attributes )) ? $containerClass = $attributes ['container_class'] : $containerClass = 'mowebso';
		
		// Define The Item Class
		(array_key_exists ( 'item_class', $attributes )) ? $itemClass = '' . $attributes ['item_class'].'-'.$theme : $itemClass = 'item-class';
		
		// Define The Custom Settings
		(array_key_exists ( 'custom_settings', $attributes )) ? $customSettings = $attributes ['custom_settings'] : $customSettings = '';

		// Define The Template Path For The Output
// 		$templatePath = JPATH_SITE . '/templates/' . $this->templatename . '/html/com_virtuemart/templates/' . $template . '/' . $show . '/';
		
		// Include The Right Files For Our Virtuemart Theme
		if ($extensionType == 'vmtheme') {
		
			// Define The CSS Path And Set It As Constant Variable
			$cssPath = 'templates/' . $this->templateName . '/html/'.$component.'/themes/'.$this->themeName.'/assets/css/' . $show . '/grids/';
			$cssFileName = $theme.'.css';
			$this->addStyleSheet($cssFileName,$cssPath);
			
			// Include The Item Template For Output
			$templateInstance = JPATH_SITE . '/templates/' . $this->templateName . '/html/com_virtuemart/themes/grids/' . $show . '/'.$theme.'.php';

		} elseif ($extensionType == 'module') {
			
			// Define The CSS Path And Set It As Constant Variable
			$this->cssPath = 'modules/' . $module . '/assets/css/' . $show . '/grids/';
			$this->cssFileName = $theme.'.css';
				
			// Include The Item Template For Output
			$templateInstance = JPATH_SITE . '/modules/' . $module .  '/' . $show . '/grids/'.$theme.'.php';

		}

		include_once $templateInstance;

		// Customziation
		// Lets Save The Amount Of Products Per Category
		if ($show == 'categories') {
			$virtueMartModelCategory = new VirtueMartModelCategory();
		}

		// Lets Start Fetching The Output
		ob_start();

		// Counter For Categories and Columns
		$iColumns = 1;
		$iItems = 1;
		// Calculating Categories Per Row
		if ($itemsPerRow != 1 && $equal_height) {
			$columnWidth = ' span' . floor ( 100 / $itemsPerRow );
			
			// Create An Individual String For Same Height Columns If The We Use
			// More Than 1 Product Per Row
			$uniqueKey = substr ( str_shuffle ( str_repeat ( 'abcdefghijklmnopqrstuvwxyz', 5 ) ), 0, 5 );
			
			$css = '';
			if ($this->name == 'ie' && $this->shortVersion == '6') {
				$css .= '* html .' . $uniqueKey . ' { /*IE6 only*/overflow: visible;height: 1px;} ';
			} else {
				$css .= '.' . $uniqueKey . ' {overflow: hidden;} ';
			}
			$css .= '.' . $uniqueKey . ' [class*="span"] {padding-bottom: 16000px;margin-bottom: -16000px;}';
			mowebso::addInlineStyle ( $css );
			$uniqueKey = ' ' . $uniqueKey;
		} else {
			$columnWidth = '';
			$float = '';
			$uniqueKey = '';
		}
		
		// Separator
		($showVerticalSeparator) ? $verticalSeparator = ' vertical-separator' : $verticalSeparator = '';
		($showHorizontalSeparator) ? $horizontalSeparator = '<div class="horizontal-separator"></div>' : $horizontalSeparator = '';
		?>

		<?php // Output Products
		if (! empty ( $objectItems )) { ?>

			<div id="<?php echo $containerClass ?>" class="<?php echo $containerClass ?>">
		
			<?php // Output The Categories
			$i = 1;
			foreach ( $objectItems as $item ) {

				if($i <= $numbOfItems) {

					// Customziation
					// Lets Save The Amount Of Products Per Category
					if ($show == 'categories') {
						$item->count_products = $virtueMartModelCategory->countProducts($item->virtuemart_category_id);

						$subcategorytree = $virtueMartModelCategory->getCategories(true,$item->virtuemart_category_id);
						$item->subcategories_tree = $subcategorytree;
					}
					
					// Show The Horizontal Seperator
					if ($iColumns == 1 && $iItems > $itemsPerRow) {
						echo $horizontalSeparator;
					}

					// This Is An Indicator Wether A Row Needs To Be Opened Or Not
					if ($iColumns == 1) {
						?>
					<div class="row-fluid-<?php echo $grid_style.$uniqueKey ?>">
					<?php
					}
					
					// Show The Vertical Seperator
					if ($iItems == $itemsPerRow or $iItems % $itemsPerRow == 0) {
						$showVerticalSeparator = '';
					} else {
						$showVerticalSeparator = $verticalSeparator;
					}


					// Modify The Width Of The Last Column If We Have 3, 6, 9
					// Products Per Row
					if($grid_style == 'ns') {
						if ($itemsPerRow == 3 && $iColumns == $itemsPerRow) {
							$columnWidth = ' span34';
						}
						if ($itemsPerRow == 3 && $iColumns != $itemsPerRow) {
							$columnWidth = ' span33';
						}
						if ($itemsPerRow == 6 && $iColumns >= 5) {
							$columnWidth = ' span18';
						}
						if ($itemsPerRow == 6 && $iColumns <= 4) {
							$columnWidth = ' span16';
						}
					} else {
						if ($itemsPerRow == 1) {
							$columnWidth = ' span1';
						}
						if ($itemsPerRow == 2) {
							$columnWidth = ' span2';
						}
						if ($itemsPerRow == 3) {
							$columnWidth = ' span3';
						}
						if ($itemsPerRow == 4) {
							$columnWidth = ' span4';
						}
						if ($itemsPerRow == 5) {
							$columnWidth = ' span5';
						}
						if ($itemsPerRow == 6) {
							$columnWidth = ' span6';
						}
					}
					?>
						
						<?php // Output Product Column ?>
						<div class="<?php echo $itemClass . $columnWidth . $showVerticalSeparator ?>">
							
							<?php // Output The Item Template
							call_user_func('output'.$show.$theme,$item,$customSettings); ?>
						
						</div>
						
					<?php
					$iItems ++;
					
					// Do We Need To Close The Current Row Now?
					if ($iColumns == $itemsPerRow) {
						?>
					<div class="clear"></div></div>
						<?php
						$iColumns = 1;
					} else {
						$iColumns ++;
					}
				}
				$i++;
			}
						
			// Do We Need A Final Closing Row Tag?
			if ($iColumns != 1) {
				echo '<div class="clear"></div></div>';
			}
			?>
		</div>
		<?php } ?>	

		<?php
		// Return The Fetched Output
		ob_end_flush();
		return;
	}

	/**
	 * Builds A UL List And Loads The Items Through A Template
	 *
	 * @param object $objectItems
	 * @param array $attributes
	 * @return string
	 */
	function ulList($objectItems, $attributes = array(), $extensionType = 'vmtheme') {
	
		// Define The Component (which must be 'com_virtuemart' in this class ;-) )
		(array_key_exists ( 'component', $attributes )) ? $component = $attributes ['component'] : $component = 'com_virtuemart';
	
		// Define The Template
		(array_key_exists ( 'template', $attributes )) ? $template = $attributes ['template'] : $template = 'default';
	
		// Define The Module
		(array_key_exists ( 'module_name', $attributes )) ? $module = $attributes ['module_name'] : $module = 'default';
	
		// Define The Items To Show
		(array_key_exists ( 'show', $attributes )) ? $show = $attributes ['show'] : $show = 'products';
	
		// Define The Theme
		(array_key_exists ( 'theme', $attributes )) ? $theme = $attributes ['theme'] : $theme = 'centered';
	
		// Define Products Per Row
		(array_key_exists ( 'items_per_row', $attributes )) ? $itemsPerRow = $attributes ['items_per_row'] : $itemsPerRow = 3;
	
		// Define Number Of Items To Show
		(array_key_exists ( 'numb_of_items', $attributes )) ? $numbOfItems = $attributes ['numb_of_items'] : $numbOfItems = count($objectItems);

		// Define The Container Class
		(array_key_exists ( 'container_class', $attributes )) ? $containerClass = $attributes ['container_class'] : $containerClass = 'mowebso';
	
		// Define The Item Class
		(array_key_exists ( 'item_class', $attributes )) ? $itemClass = ' ' . $attributes ['item_class'].'-'.$theme : $itemClass = ' item-class';
	
		// Define The Custom Settings
		(array_key_exists ( 'custom_settings', $attributes )) ? $customSettings = $attributes ['custom_settings'] : $customSettings = '';
	
		// Define The Template Path For The Output
		// 		$templatePath = JPATH_SITE . '/templates/' . $this->templatename . '/html/com_virtuemart/templates/' . $template . '/' . $show . '/';
	
	
		// Include The Right Files For Our Virtuemart Theme
		if ($extensionType == 'vmtheme') {
	
			// Define The CSS Path And Set It As Constant Variable
			$this->cssPath = 'templates/' . $this->templateName . '/html/'.$component.'/templates/assets/css/' . $show . '/grid/';
			$this->cssFileName = $theme.'.css';
				
			// Include The Item Template For Output
			$templateInstance = JPATH_SITE . '/templates/' . $this->templateName . '/html/com_virtuemart/templates/' . $show . '/grid/'.$theme.'.php';
				
		} elseif ($extensionType == 'module') {
				
			// Define The CSS Path And Set It As Constant Variable
			$this->cssPath = 'modules/' . $module . '/assets/css/' . $show . '/grid/';
			$this->cssFileName = $theme.'.css';
	
			// Include The Item Template For Output
			$templateInstance = JPATH_SITE . '/modules/' . $module .  '/' . $show . '/grid/'.$theme.'.php';
	
		}
	
		include_once $templateInstance;

		// Lets Start Fetching The Output
		ob_start ();
	
		// Items
		$iItems = 1; ?>
	
			<?php // Output Products
			if (! empty ( $objectItems )) { ?>
	
				<ul id="<?php echo $containerClass ?>" class="<?php echo $containerClass ?>">
			
				<?php // Output The Categories
				$i = 1;
				foreach ( $objectItems as $item ) {
				
					if($i <= $numbOfItems) { ?>
								
						<?php // Output The Item Template 
						call_user_func('output'.$show.$theme,$item,$customSettings); ?>
							
						<?php
						$iItems ++;
						
					}
					$i++;
				}

				?>
			</ul>
			<?php } ?>	
	
			<?php
			// Return The Fetched Output
			return ob_get_clean ();
		}
	
	/**
	 * Builds The Head Divs For A Section
	 *
	 * @return bool|void
	 */
	function buildSectionStart($title=false,$suffix='',$id='') {

		// Include The Item Template For Output
		$templateInstance = JPATH_SITE . '/templates/' . $this->templateName . '/html/com_virtuemart/themes/'.$this->themeName.'/buildsection/buildsectionstart.php';
		include_once $templateInstance;
		
		// Output The Item Template
		echo call_user_func('buildsectionstart',$title,$suffix,$id);

		return true;
		
	}
	
	/**
	 * Builds The Bottom Divs For A Section
	 *
	 * @return bool|void
	 */
	function buildSectionEnd() {

		// Include The Item Template For Output
		$templateInstance = JPATH_SITE . '/templates/' . $this->templateName . '/html/com_virtuemart/themes/'.$this->themeName.'/buildsection/buildsectionend.php';
		include_once $templateInstance;

		// Output The Item Template
		echo call_user_func('buildsectionend');

		return true;
	}
	
	/**
	 * Get The Related Categories Of A Product
	 *
	 * @author Max Milbers enchanced by Eugen Stranz
	 * @param unknown_type $productID
	 * @return Object
	 */
	function getRelatedCategories($productID) {

		$db = JFactory::getDBO ();
		$query = $db->getQuery(true);

		$query->from        ('`#__virtuemart_customs` AS C');
		$query->select      ('C.`virtuemart_custom_id` , `custom_parent_id` , `admin_only` , `custom_title` , `custom_tip` , C.`custom_value` AS value, `custom_field_desc` , `field_type` , `is_list` , `is_hidden` , C.`published` , field.`virtuemart_customfield_id` , field.`custom_value`, field.`custom_param`, field.`custom_price`, field.`ordering`');
		$query->leftJoin    ('`#__virtuemart_product_customfields` AS field ON C.`virtuemart_custom_id` = field.`virtuemart_custom_id`');
		$query->where       ('`virtuemart_product_id` ='.$productID.' and `field_type` = "Z"');

		$db->setQuery ( $query );
		$results = $db->loadObjectList ();
	
		// Load The Product Model
		$categoryModel = VmModel::getModel('Category');
	
		$relatedCategoriesObject = array();
		$i = 0;
		foreach ($results as $result) {
			$relatedCategoriesObject[$i] = $categoryModel->getCategory($result->custom_value);
			$i++;
		}
	
		// Load The Images For The Categories
		$categoryModel->addImages($relatedCategoriesObject);
	
		return $relatedCategoriesObject;
	}
	
	/**
	 * Get The Related Products Of A Product
	 *
	 * @author Max Milbers enchanced by Eugen Stranz
	 * @param string $productID
	 * @return Object
	 */
	function getRelatedProducts($productID) {

		$db = JFactory::getDBO ();
		$query = $db->getQuery(true);

		$query->from        ('`#__virtuemart_customs` AS C');
		$query->select      ('C.`virtuemart_custom_id` , `custom_parent_id` , `admin_only` , `custom_title` , `custom_tip` , C.`custom_value` AS value, `custom_field_desc` , `field_type` , `is_list` , `is_hidden` , C.`published` , field.`virtuemart_customfield_id` , field.`custom_value`, field.`custom_param`, field.`custom_price`, field.`ordering`');
		$query->leftJoin    ('`#__virtuemart_product_customfields` AS field ON C.`virtuemart_custom_id` = field.`virtuemart_custom_id`');
		$query->where       ('`virtuemart_product_id` = '.$productID.' and `field_type` = "R"');

		$db->setQuery ( $query );
		$results = $db->loadObjectList ();
	
		$relatedProductsIDs = array();
		foreach ($results as $result) {
			$relatedProductsIDs[] .= $result->custom_value;
		}

		// Load The Product Model
		$productModel = VmModel::getModel('Product');
	
		$relatedProductsObject = $productModel->getProducts($relatedProductsIDs,true,true,true);
	
		// Load The Images For The Products
		$productModel->addImages($relatedProductsObject);
	
		return $relatedProductsObject;
	}

}