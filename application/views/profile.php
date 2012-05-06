<script type='text/javascript' src='/assets/javascript/profile.js'></script>
<div class="hero-unit span8 offset1 welcome_container">
<div class="row" id="profile"> 
    <div class="main span12 columns"> 
        <div class="padding page"> 
            <h3>Edit your Profile</h3> 
           </br>
	   </br>             
	   <?php  echo form_open("auth/change_email", ' id="change_email_form" method="POST"');  ?>
                    <div class="clearfix"> 
                        <label for="id_username">Username</label> 
                        <div class="input"> 
                            <?php echo form_input(
			      array(
				    'name'  => 'username',
				    'id'    => 'id_username',
				    'value' => $users[0]['username'],
				    'maxlength'  => 30
			      )
			    ); ?>
                            <span class="help-block"></span> 
                        </div>
                    </div>
                    <div class="clearfix"> 
                        <label for="id_email">Email</label> 
                        <div class="input"> 
			    <?php echo form_input(
			      array(
				    'name'  => 'email',
				    'id'    => 'email',
				    'value' => $users[0]['email'],
				    'size' => 30
			      )
			    ); ?>
                <td style="color: red;"><?php echo form_error('email'); ?><?php echo isset($errors['email'])?$errors['email']:''; ?></td>
                            <span class="help-block"></span> 
                        </div> 
                    </div> 



                   <div class="clearfix">
                        <label for="password">Current password</label>
                        <div class="input">
                            <?php echo form_password(
                              array(
                                    'name'  => 'password',
                                    'id'    => 'password',
                                    'size' => 30
                              )
                            ); ?>
                <td style="color: red;"><?php echo form_error('password'); ?><?php echo isset($errors['password'])?$errors['password']:''; ?></td>

                            <span class="help-block"></span>
                        </div>
                    </div>

                <div class="actions"> 
                    <input type="submit" value="Change Email" class="btn" name="settings_form" id="change_email"> 
                </div> 
		<?php echo form_close(); ?>
            <br/> 


          <?php  echo form_open("/auth/change_password", ' id="change_password_form" method="POST"');  ?>

              <!--  <div class="clearfix"> 
                        <label for="display_name">Display Name</label> 
                        <div class="input"> 
                            <?php echo form_input(
			      array(
				    'name'  => 'name',
				    'id'    => 'display_name',
				    'value' => $display_name[0]['display_name'],
				    'maxlength'  => 20
			      )
			    ); ?>
                            <span class="help-block"></span> 
                        </div> 
                    </div> 
		-->

                    <div class="clearfix"> 
                        <label for="id_current_password">Current password</label> 
                        <div class="input"> 
			    <?php echo form_password(
			      array(
				    'name'  => 'old_password',
				    'id'    => 'old_password',
				    'size' => 30
			      )
			    ); ?>
                        <td style="color: red;"><?php echo form_error('old_password'); ?><?php echo isset($errors['old_password'])?$errors['old_password']:''; ?></td>

                            <span class="help-block"></span> 
                        </div> 
                    </div> 

                    <div class="clearfix"> 
                        <label for="id_password1">New password</label> 
                        <div class="input"> 
			    <?php echo form_password(
			      array(
                                    'name'  => 'new_password',
                                    'id'    => 'new_password',
                                    'size' => 30
			      )
			    ); ?>
                <td style="color: red;"><?php echo form_error('new_password'); ?><?php echo isset($errors['new_password'])?$errors['new_password']:''; ?></td>

                            <span class="help-block"></span> 
                        </div> 
                    </div> 

                    <div class="clearfix"> 
                        <label for="id_password2">Confirm new password</label> 
                        <div class="input"> 
			    <?php echo form_password(
			      array(
				    'name'  => 'confirm_new_password',
				    'id'    => 'confirm_new_password',
				    'size' => 30
			      )
			    ); ?>
                <td style="color: red;"><?php echo form_error('confirm_new_password'); ?><?php echo isset($errors['confirm_new_password'])?$errors['confirm_new_password']:''; ?></td>
                            <span class="help-block"></span> 
                        </div> 
                   </div> 
                   
                <div class="actions"> 
                    <input type="submit" value="Change Password" class="btn" name="settings_form" id = "change_password"> 
                </div> 
                
             <?php echo form_close(); ?>
            <br/> 
</div>
        </div> 
       </div>
       </div>
       </div>

