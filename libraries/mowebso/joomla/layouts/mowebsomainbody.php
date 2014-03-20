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


class MowebsoMainbody {

	/* instance */
	protected static $_instance;

	/**
	 * Create An Instance of MoWebSo Class
	 * @return Mowebso
	 */
	public static function getInstance() {

		// Only Create The Object If It Doesn't Exist.
		if (!isset(self::$_instance)) {
			self::$_instance = new MowebsoMainbody();
		}
		return self::$_instance;

	}

	/**
	 * Output: Mainbody
	 *
	 * This Method Outputs The Modules With The Right Grid
	 *
	 * @param $gridSize
	 * @return string
	 */
	function displayMainbody($gridSize) {

		// @TODO Settings For Message / Error Output
		// Lets Start Fetching The Output
		ob_start (); ?>
			
			<section class="span<?php echo $gridSize ?>">
				<!-- 
				<jdoc:include type="message" />
				 -->
				<jdoc:include type="component" />
			</section>
			
		
		<?php // Return The Fetched Output
		return ob_get_clean ();
	
	}	
}