<?php

 /**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');
 if (isset($this->error)) : ?>
	<div class="contact-error">
		<?php echo $this->error; ?>
	</div>
<?php endif; ?>

<div class="contact-form">
	<form id="contact-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate">
		<fieldset>
			<legend><?php echo JText::_('COM_CONTACT_FORM_LABEL'); ?></legend>
            <div>
			    <div class="row-fluid">
                    <div class="span3"><?php echo $this->form->getLabel('contact_name'); ?></div>
                    <div class="span9"><?php echo $this->form->getInput('contact_name'); ?></div>
                </div>
                <div class="row-fluid">
                    <div class="span3"><?php echo $this->form->getLabel('contact_email'); ?></div>
                    <div class="span9"><?php echo $this->form->getInput('contact_email'); ?></div>
                </div>
                <div class="row-fluid">
                    <div class="span3"><?php echo $this->form->getLabel('contact_subject'); ?></div>
                    <div class="span9"><?php echo $this->form->getInput('contact_subject'); ?></div>
                </div>
                <div class="row-fluid">
                    <div class="span3"><?php echo $this->form->getLabel('contact_message'); ?></div>
                    <div class="span9"><?php echo $this->form->getInput('contact_message'); ?></div>
                </div>
				<?php 	if ($this->params->get('show_email_copy')){ ?>
                    <div class="row-fluid">
						<div class="span3"><?php echo $this->form->getLabel('contact_email_copy'); ?></div>
                        <div class="span9"><?php echo $this->form->getInput('contact_email_copy'); ?></div>
                    </div>
				<?php 	} ?>
			<?php //Dynamically load any additional fields from plugins. ?>
			     <?php foreach ($this->form->getFieldsets() as $fieldset): ?>
			          <?php if ($fieldset->name != 'contact'):?>
			               <?php $fields = $this->form->getFieldset($fieldset->name);?>
			               <?php foreach($fields as $field): ?>
			                    <?php if ($field->hidden): ?>
			                         <?php echo $field->input;?>
			                    <?php else:?>
			                         <div>
			                            <?php echo $field->label; ?>
			                            <?php if (!$field->required && $field->type != "Spacer"): ?>
			                               <span class="optional"><?php echo JText::_('COM_CONTACT_OPTIONAL');?></span>
			                            <?php endif; ?>
			                         </div>
			                         <div><?php echo $field->input;?></div>
			                    <?php endif;?>
			               <?php endforeach;?>
			          <?php endif ?>
			     <?php endforeach;?>
				<div style="text-align: center"><button class="button validate btn btn-primary" type="submit"><?php echo JText::_('COM_CONTACT_CONTACT_SEND'); ?></button>
					<input type="hidden" name="option" value="com_contact" />
					<input type="hidden" name="task" value="contact.submit" />
					<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
					<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />
					<?php echo JHtml::_( 'form.token' ); ?>
				</div>
			</div>
		</fieldset>
	</form>
</div>
