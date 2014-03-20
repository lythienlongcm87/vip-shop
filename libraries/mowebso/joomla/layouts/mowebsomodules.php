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
jimport ( 'mowebso.joomla.mowebso' );


class MowebsoModules extends Mowebso {

	/* instance */
	protected static $_instance;

	var $activeModules;


	/**
	 * Create An Instance of MoWebSo Modules Class
	 * @return Mowebso
	 */
	public static function getInstance() {

		// Only Create The Object If It Doesn't Exist.
		if (!isset(self::$_instance)) {
			self::$_instance = new MowebsoModules();
		}
		return self::$_instance;

	}

	/**
	 * Output: Module
	 *
	 * This Method Outputs The Modules With The Right Grid
	 * @param $activeModules
	 * @param string $style
	 * @param string $type
	 * @return string
	 */
	function displayModules($activeModules,$style='standard',$type='modules') {

		// Save The Active Modules To An Class Variable
		$this->activeModules = $activeModules;
		$countActiveModules = count($this->activeModules);
		
		// Get The Short Version Of The Module Position
		// feature-a => feature
		$activeModuleShort = substr($activeModules[0], 0,-2);
		
		// Get The Grid Structure For This Module Position Row
		// Save it As Array And Proove If The Array Isnt Empty
		// Else Define Predefine Grid Structures
		// Get The Prepared Array With Module Grid Settings

		if($type =='modules') {
			
			$gridStructure = $this->prepareArrayForModuleGridSettings($this->document->params->get( $activeModuleShort ));
			if(empty($gridStructure[1])) {
				$gridStructure = '';
				$gridStructure = $this->predefinedStructure();
			}
			
			// Lets Start Fetching The Output
			ob_start (); ?>
	
				<div class="row">
			
					<?php // Output The Module
					$iModuleCount = 0;
					foreach ($activeModules as $activeModule) { ?>
					<div class="span<?php echo $gridStructure[$countActiveModules][$iModuleCount] ?>">
						<jdoc:include type="modules" name="<?php echo $activeModule ?>" style="<?php echo $style ?>" />
					</div>
					<?php 
						$iModuleCount++;
					} ?>
	
				</div>
			
			<?php // Return The Fetched Output
			return ob_get_clean ();
			
		} else if($type =='mainbody') {
			
			$gridStructure = $this->prepareArrayForModuleGridSettings($this->document->params->get( $type ));
			if(empty($gridStructure[1])) {
				$gridStructure = '';
				$gridStructure = $this->predefinedStructure();
			}

			// Lets Start Fetching The Output
			ob_start (); 
			$iModuleCount = 0;
			
			// If We Show The Mainbody Increase The CountActiveModules Value
			// And Add Mainbody To The ActiveModules Array
			if($this->document->params->get('showmainbody', 1)) {

				$mainbodyPos = $this->document->params->get('mainbodypos', 1);
				$countActiveModules = $countActiveModules + 1;
			
				// Lets Add Mainbody To The Array
				array_splice($activeModules, $mainbodyPos, 0, "mainbody");
			} else {
				$mainbodyPos = 99;
			} ?>
		
			<?php // Output The Module		
			foreach ($activeModules as $activeModule) { 
				
				if($iModuleCount != $mainbodyPos) { ?>
				<section class="span<?php echo $gridStructure[$countActiveModules][$iModuleCount] ?>">
					<jdoc:include type="modules" name="<?php echo $activeModule ?>" style="<?php echo $style ?>" />
				</section>
				<?php 
					$iModuleCount++;
				} elseif ($iModuleCount == $mainbodyPos) {
					
					// Include The MoWebSo Mainbody Class
					jimport ('mowebso.joomla.layouts.mowebsomainbody');

					$displayMainbody = MowebsoMainbody::getInstance();
					echo $displayMainbody->displayMainbody($gridStructure[$countActiveModules][$iModuleCount]);

					$iModuleCount++;
				}
			} ?>	

			<?php // Return The Fetched Output
			return ob_get_clean ();
		}
			
	}
	
	/**
	 * Predefined Grid Structure
	 * Gives the right array back for grid output
	 * @param integer $countActiveModules
	 * @return array for right grid structure
	 */
	function predefinedStructure() {
	
		// Predefined Structure Grids
		$predefinedStructure = array(	1 	=> array(12),
										2 	=> array(6,6),
										3 	=> array(4,4,4),
										4 	=> array(3,3,3,3),
										5 	=> array(2,3,2,3,2),
										6 	=> array(2,2,2,2,2,2),
										7 	=> array(2,2,2,1,1,2,2),
										8 	=> array(2,2,1,1,1,1,2,2),
										9 	=> array(2,1,1,1,2,1,1,1,2),
										10 	=> array(2,1,1,1,1,1,1,1,1,2),
										11 	=> array(2,1,1,1,1,1,1,1,1,1,1),
										12 	=> array(1,1,1,1,1,1,1,1,1,1,1,1)
									);
		return $predefinedStructure;
	}

}