<div class="hero-unit span8 offset1 welcome_container">
<div class="row" id="profile"> 
    <div class="main span12 columns"> 
        <div class="padding page"> 
            <h3>Edit your Profile</h3> 
            <hr /> 
            <!-- change this token! -->
            
	   <?php  echo form_open("/auth/profile", 'method="POST"');  ?>
 <?php var_dump($old_password); ?>

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
                            <span class="help-block"></span> 
                        </div> 
                    </div> 

                <div class="clearfix"> 
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
<!--                <td style="color: red;"><?php echo form_error('old_password'); ?><?php echo isset($errors['old_password'])?$errors['old_password']:''; ?></td>
-->
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
                            <span class="help-block"></span> 
                        </div> 
                   </div> 
                   
                <div class="actions"> 
                    <input type="submit" value="Save changes" class="btn" name="settings_form"> 
                </div> 
                
             <?php echo form_close(); ?>
            <br/> 

        </div> 
       </div>
       </div>
       </div>
