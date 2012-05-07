<script type='text/javascript' src='/assets/javascript/profile.js'></script>
<div class="span8 offset1 welcome_container">
  <div class="row" id="profile"> 
      <div class="padding page"> 

  <!--breadcrumb-->
  <div class="row"> 
	<ul class="breadcrumb"> 
	  <li class="active"><a href="/dashboard">Dashboard<span class="divider">/</span></li> 
	  <li><a href="">Profile</a></li> 
	</ul> 
    </div> 


	  <div class="page-header">
	  <h1>Your Profile</h1>
	  </div> 
      <div id="phone_number">
      <h3>Phone Number  <small><? echo $phone['phone_number'];?></small></h3>
      </div>
      <div id="phone_number">
      <h3>Email  <small><? echo $email;?></small></h3>
      </div>
      <div>
	<div id="change-email"></div>
	</br>
	<div id="change-password"></div>
	<br/> 
      </div>
      </div>
    </div>
  </div>
</div>

