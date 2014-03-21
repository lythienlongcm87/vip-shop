<?php

/**
 *
 * Modify user form view, User info
 *
 * @package	VirtueMart
 * @subpackage User
 * @author Oscar van Eijk, Eugen Stranz
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: edit_address_userfields.php 6349 2012-08-14 16:56:24Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Status Of Delimiter
$closeDelimiter = false;
$openTable = true;
$hiddenFields = '';

// Output: Userfields
foreach($this->userFields['fields'] as $field) {

	if($field['type'] == 'delimiter') {

		// For Every New Delimiter
		// We need to close the previous
		// table and delimiter

		if($closeDelimiter) { ?>
			</div>
		</fieldset>
		<?php
		} ?>

		<fieldset class="userfields">
			<span class="userfields_info"><?php echo $field['title'] ?></span>
		<?php
		$closeDelimiter = true;
		$openTable = true;

	} elseif ($field['hidden'] == true) {

		// We collect all hidden fields
		// and output them at the end
		$hiddenFields .= $field['formcode'] . "\n";

	} else {

		// If we have a new delimiter
		// we have to start a new table
		if($openTable) {
			$openTable = false;
			?>

			<div  class="adminForm user-details">

		<?php
		}

		// Output: Userfields
		//mod by Eddy
		if($field['name']=='county'  || $field['name']=='district' || $field['name']=='virtuemart_country_id' || $field['name']=='shipto_county'  || $field['name']=='shipto_district' || $field['name']=='shipto_virtuemart_country_id'){
		?>
				<div class="row-fluid" style="display:none">
					<div  class="key span4" title="<?php echo $field['description'] ?>" >
						<label class="<?php echo $field['name'] ?>" for="<?php echo $field['name'] ?>_field">
							<?php echo $field['title'] . ($field['required'] ? ' *' : '') ?>
						</label>
					</div>
					<div class="span8">
						<?php echo $field['formcode'] ?>
					</div>
				</div>
	    <?php
	    }else if($field['name']=='zip' || $field['name']=='shipto_zip'){
		?>
				<div class="row-fluid" >
					<div  class="key span4" title="<?php echo $field['description'] ?>" >
						<label class="<?php echo $field['name'] ?>" for="<?php echo $field['name'] ?>_field">
							<?php echo $field['title'] . ($field['required'] ? ' *' : '') ?>
						</label>
					</div>
					<div class="span8">
						<div style="display:none"><?php echo $field['formcode'] ?></div>
						<div id="twzipcode">
                          <div data-role="county" data-style="county"></div> 
                          <div data-role="district" data-style="district"></div> 
                          <div data-role="zipcode" data-style="zipcode"></div>  
                        </div>
					</div>
				</div>
				<?php
	    }else{
		?>
				<div class="row-fluid">
					<div  class="key span4" title="<?php echo $field['description'] ?>" >
						<label class="<?php echo $field['name'] ?>" for="<?php echo $field['name'] ?>_field">
							<?php echo $field['title'] . ($field['required'] ? ' *' : '') ?>
						</label>
					</div>
					<div class="span8">
						<?php echo $field['formcode'] ?>
					</div>
		</div>
	<?php
        }
	
	}

}

// At the end we have to close the current
// table and delimiter ?>

			</div>
    </fieldset>

<?php // Output: Hidden Fields
echo $hiddenFields
?>
