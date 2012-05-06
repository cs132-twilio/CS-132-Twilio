<script type='text/javascript' src='/assets/javascript/jquery.bbq.js'></script>
<script type='text/javascript' src='/assets/javascript/dashboard.js'></script>
<div class="container-fluid">
  <div class="row-fluid">
<div class="span2">
  <!--Sidebar content-->
  <ul id="classTabs" class="nav nav-pills nav-stacked">
      <li class="nav-header"><h2>Classes</h2></li>
  <a href="/classes"><center><button id="add-new-classroom" class="btn btn-small btn-primary">Add a new Class</button></center></a>
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
