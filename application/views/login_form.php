<?php
/*$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);*/
?>
<li>
<?php echo form_open($this->uri->uri_string(), 'method="POST" class="form-inline login-form"'); ?>
<?php echo form_input(
  array(
        'name'  => 'login',
        'id'    => 'login',
        'value' => set_value('login'),
        'maxlength'     => 80,
	'class' => 'input-small login-field',
	'placeholder' => ($login_by_username AND $login_by_email) ? 'Username or Email' : $login_by_username ? 'Username' : 'Email'
  )
); ?>
<?php echo form_error('login'); ?><?php echo isset($errors['login'])?$errors['login']:''; ?>
<?php echo form_password(
  array(
        'name'  => 'password',
        'id'    => 'password',
	'class' => 'input-small login-field',
	'Placeholder' => 'Password'
  )
); ?>
<?php echo form_error('password'); ?><?php echo isset($errors['password'])?$errors['password']:''; ?>
			<?php /*echo form_checkbox($remember); ?>
			<?php echo form_label('Remember me', $remember['id']); ?>
			<?php echo anchor('/auth/forgot_password/', 'Forgot password'); ?>
			<?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register'); */?>
<?php echo form_submit('submit', 'Login', 'class="btn"'); ?>
<?php echo form_close(); ?>
</li>
