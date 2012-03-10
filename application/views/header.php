<?php

$user_id = 1;

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bootstrap, from Twitter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/stylesheets/bootstrap.css" rel="stylesheet">
    <link href="assets/stylesheets/bootstrap-responsive.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
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
          <a class="brand" href="#">Twexter</a>
          <div class="nav-collapse">          

            <ul class="nav">
            
	      <?php if ($user_id) { ?>
		<li><a href="#Profile">Profile</a></li>
		<li><a href="#Log out">Log out</a></li>
	      <?php } else { ?>
		<li><a href="#Profile">Log in</a></li>
	      <?php } ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
        <div class="container">
