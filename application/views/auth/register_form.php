<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>
<?php echo form_open($this->uri->uri_string()); ?>
<div>
  <div id="registration-page-1">
    <?php if ($use_username) { ?>
    <div class="registration_field">
      <div><?php echo form_label('Username', $username['id']); ?></div>
      <div><?php echo form_input($username); ?></div>
      <div class="error"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']])?$errors[$username['name']]:''; ?></div>
    </div>
    <?php } ?>
    <div class="registration_field">
      <div><?php echo form_label('Email Address', $email['id']); ?></div>
      <div><?php echo form_input($email); ?></div>
      <div class="error"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']])?$errors[$email['name']]:''; ?></div>
    </div>
    <div class="registration_field">
      <div><?php echo form_label('Password', $password['id']); ?></div>
      <div><?php echo form_password($password); ?></div>
      <div class="error"><?php echo form_error($password['name']); ?></div>
    </div class="registration_field">
    <div class="registration_field">
      <div><?php echo form_label('Confirm Password', $confirm_password['id']); ?></div>
      <div><?php echo form_password($confirm_password); ?></div>
      <div class="error"><?php echo form_error($confirm_password['name']); ?></div>
    </div>
    <?= form_button('next', 'Next ' . "\xC2\xBB", 'class="btn btn-info btn-large big-button pull-right"'); ?>
  </div>
<?php if ($captcha_registration) {?>
  <div id="registration-page-2">
  <?if ($use_recaptcha) { ?>
    <div class="registration_field">
      <div colspan="2">
        <div id="recaptcha_image"></div>
      </div>
      <div>
        <a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
        <div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
        <div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
      </div>
    </div>
    <div class="registration_field">
      <div>
        <div class="recaptcha_only_if_image">Enter the words above</div>
        <div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
      </div>
      <div><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></div>
      <div class="error"><?php echo form_error('recaptcha_response_field'); ?></div>
      <?php echo $recaptcha_html; ?>
    </div>
    <?php } else { ?>
    <div class="registration_field">
      <div colspan="3">
        <p>Enter the code exactly as it appears:</p>
        <?php echo $captcha_html; ?>
      </div>
    </div>
    <div class="registration_field">
      <div><?php echo form_label('Confirmation Code', $captcha['id']); ?></div>
      <div><?php echo form_input($captcha); ?></div>
      <div class="error"><?php  echo form_error($captcha['name']); ?></div>
    </div>
<?php } ?>
  <?
  echo form_button('back', "\xC2\xAB" . 'Back ', 'class="btn btn-info btn-large big-button pull-left"');
  echo form_submit('register', 'Sign up ' . "\xC2\xBB", 'class="btn btn-info btn-large big-button pull-right" style="margin-right: 5px;"');
  ?>
  </div>
<?php } ?>
</div>
<?php echo form_close(); ?>