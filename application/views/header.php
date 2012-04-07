<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Twexter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="/assets/stylesheets/bootstrap.css" rel="stylesheet">
    <link href="/assets/stylesheets/bootstrap-responsive.css" rel="stylesheet">
    <link href="/assets/stylesheets/default.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="/assets/javascript/ajax/prototype.js" type="text/javascript"></script>
    <script src="/assets/javascript/ajax/effects.js" type="text/javascript"></script>
    <script src="/assets/javascript/ajax/dragdrop.js" type="text/javascript"></script>
    <script src="/assets/javascript/ajax/controls.js" type="text/javascript"></script> 
    <script src="/assets/javascript/default.js" type="text/javascript"></script>
  </head>

  <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">		
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/">Twexter</a>
          <div class="nav-collapse">          

            <ul class="nav">
              <li<?= $page == 'home' ? ' class="active"' : '' ?>><a href="/">Home</a></li>		
              <li<?= $page == 'dashboard' ? ' class="active"' : '' ?>><a href="/dashboard">Dashboard</a></li>		
            </ul>			
            
            <ul id="user-control" class="nav pull-right">
              <?php if ($user_id) { ?>
              <li><a href="#">Profile</a></li>
              <li><a href="#" onclick="jQuery.post('/auth/logout', {}, function(){document.location.reload(true);});">Log out</a></li>
              <?php } else { ?>
              <li>
                <?php
                  echo form_open('/auth/login', 'method="POST" class="form-inline login-form"');
                  echo form_input(
                    array(
                          'name'  => 'login',
                          'id'    => 'login',
                          'value' => set_value('login'),
                          'maxlength'     => 80,
                    'class' => 'input-small login-field',
                    'placeholder' => ($login_by_username AND $login_by_email) ? 'Username or Email' : $login_by_username ? 'Username' : 'Email'
                    )
                  );
                  echo form_error('login');
                  echo isset($errors['login'])?$errors['login']:'';
                  echo form_password(
                    array(
                          'name'  => 'password',
                          'id'    => 'password',
                    'class' => 'input-small login-field',
                    'Placeholder' => 'Password'
                    )
                  );
                  echo form_error('password');
                  echo isset($errors['password'])?$errors['password']:'';
                        /*echo form_checkbox($remember);
                        echo form_label('Remember me', $remember['id']);
                        echo anchor('/auth/forgot_password/', 'Forgot password');
                        if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register'); */
                  echo form_submit('submit', 'Login', 'class="btn"');
                  echo form_close();
                  }
                ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
      <div class="container" id="content">
