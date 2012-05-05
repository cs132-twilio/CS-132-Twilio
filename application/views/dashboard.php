<script type='text/javascript' src='/assets/javascript/jquery.bbq.js'></script>
<script type='text/javascript' src='/assets/javascript/dashboard.js'></script>
<div class="container-fluid">
  <div class="row-fluid">
<div class="span2">
  <!--Sidebar content-->
  <ul id="classTabs" class="nav nav-pills nav-stacked">
    </br>
      <div class="btn-group"> 
          <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Edit Your Classes <span class="caret"></span></button> 
          <ul class="dropdown-menu"> 
            <li><a href="#">Add a class</a></li> 
            <li class="divider"></li> 
            <li><a href="#">Remove class</a></li> 
          </ul> 
        </div><!-- /btn-group --> 
    </br>

      <li class="nav-header"><h4>Your Classes</h4></li>
      <?
      foreach ($classlist as $c){
        echo '<li class="class" data-cid="' . $c['id'] . '">
	      <a onclick="return Twexter.dashboard.changeClass(' . $c['id'] . ');">' . $c['name'] . '</a>
	      </li>';
      }
      ?>
  </ul>
</div>

<div id="modules" class="span10">
  <!--Body content-->
    <ul id="moduleTabs" class="nav nav-tabs">
      <li class="active"><a onclick="return Twexter.dashboard.ajax_load_module('clist');">List</a></li>
      <li><a onclick="return Twexter.dashboard.ajax_load_module('message');">Message</a></li>
      <li><a onclick="return Twexter.dashboard.ajax_load_module('stream');">Stream</a></li>
      <li><a onclick="return Twexter.dashboard.ajax_load_module('Poll');">Poll</a></li>
    </ul>
    <div id="moduleContent" >
    </div>
</div>
  </div>


</div> <!--class="container-fluid"-->
