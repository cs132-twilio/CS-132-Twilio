<?php
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
);
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
?>
<?php echo form_open($this->uri->uri_string()); ?>

	<div class="clearfix">
                <label for="password">Current Password</label>
		<?php echo form_password($password); ?>
		<td style="color: red;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?></td>
	 </div>

	<div class="clearfix">
                <label for="password">New Email</label>
		<?php echo form_input($email); ?>
		<td style="color: red;"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?></td>
	</div>
</table>
<?php echo form_submit('change', 'Update Your Email', 'class="btn btn-primary"'); ?>
<?php echo form_close(); ?>