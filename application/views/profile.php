<div class="hero-unit span8 offset1 welcome_container">
<div class="row" id="profile"> 

    <div class="main span12 columns"> 
        <div class="padding page"> 
            <h2>Your Profile</h2> 
            <hr /> 
            <!-- change this token! -->
            <form action="." method="POST"><div style='display:none'><input type='hidden' name='csrfmiddlewaretoken' value='d0212a418e8676310f5a87cdb952582a' /></div> 
 
                    <div class="clearfix"> 
                        <label for="id_username">Username</label> 
                        <div class="input"> 
                            <input id="id_username" type="text" name="username" value="<?php echo $users['username']; ?>" maxlength="30" /> 
                            <span class="help-block"></span> 
                        </div>
                    </div>
                     
                    <div class="clearfix"> 
                        <label for="id_email">Email</label> 
                        <div class="input"> 
                            <input id="id_email" type="text" name="email" value="<?php echo $users['email']; ?>" maxlength="75" /> 
                            
                            <span class="help-block"></span> 
                        </div> 
                    </div> 
                
                <div class="clearfix"> 
                        <label for="display_name">Display Name</label> 
                        <div class="input"> 
                            <input id="id_email" type="text" name="email" value="<?php echo  $display_name; ?>" maxlength="75" /> 
                            <span class="help-block"></span> 
                        </div> 
                    </div> 
                
                    <div class="clearfix"> 
                        <label for="id_current_password">Current password</label> 
                        <div class="input"> 
                            <input type="password" name="current_password" id="id_current_password" /> 
                            
                            <span class="help-block"></span> 
                        </div> 
                    </div> 
                
                    <div class="clearfix"> 
                        <label for="id_password1">New password</label> 
                        <div class="input"> 
                            <input type="password" name="password1" id="id_password1" /> 
                            
                            <span class="help-block"></span> 
                        </div> 
                    </div> 
                
                    <div class="clearfix"> 
                        <label for="id_password2">Password confirmation</label> 
                        <div class="input"> 
                            <input type="password" name="password2" id="id_password2" /> 
                            
                            <span class="help-block"></span> 
                        </div> 
                    </div> 
                
                <div class="actions"> 
                    <input type="submit" value="Save changes" class="btn" name="settings_form"> 
                </div> 
            </form> 
            <br/> 
            
        </div> 
       </div>
       </div>
       </div>
