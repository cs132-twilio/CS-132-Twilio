<?php
$old_password = array(
	'name'	=> 'old_password',
	'id'	=> 'old_password',
	'value' => set_value('old_password'),
	'size' 	=> 30,
);
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
);
?>
<?php echo form_open($this->uri->uri_string()); ?>

	  <div class="clearfix">
                <label for="password">Current Password</label>
		<?php echo form_password($old_password); ?>
		<td style="color: red;"><?php echo form_error($old_password['name']); ?><?php echo isset($errors[$old_password['name']])?$errors[$old_password['name']]:''; ?></td>
	 </div>
         <div class="clearfix">
		<label for="password">New Password</label>
		<?php echo form_password($new_password); ?>
		<td style="color: red;"><?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?></td>
        </div>
	<div class="clearfix">
                <label for="password">Confirm New Password</label>
		<?php echo form_password($confirm_new_password); ?>
		<td style="color: red;"><?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?></td>
	</div>
	<div class="actions"> 
	  <?php echo form_submit('change', 'Change Your Password', 'class="btn btn-primary"'); ?>
	</div> 
<?php echo form_close(); ?>