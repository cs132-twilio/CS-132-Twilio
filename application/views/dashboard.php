<script type='text/javascript' src='/assets/javascript/dashboard.js'></script>
<div class="container-fluid">
  <div class="row-fluid">
<div class="span2">
  <!--Sidebar content-->
  <ul id="classTabs" class="nav nav-pills nav-stacked">
      <li class="nav-header"><h4>Your Classes</h4></li>
      <!--<li class="active"><a onclick="return Twexter.ajax_load('/modules/cList/index/1', 'moduleContent');">Math</a></li>
      <li><a onclick="return Twexter.ajax_load('/modules/cList/index/2', 'moduleContent');">Biology</a></li>
      <li><a onclick="return Twexter.ajax_load('/modules/cList/index/3', 'moduleContent');">Web Applications</a></li>-->
      <?
      foreach ($classlist as $c){
        echo '<li class="class"><a onclick="return Twexter.ajax_load(\'/modules/cList/index/' . $c['id'] . '\', \'moduleContent\');">' . $c['name'] . '</a></li>';
      }
      ?>
  </ul>
</div>

<div id="modules" class="span10">
  <!--Body content-->
    <ul id="moduleTabs" class="nav nav-tabs">
      <li class="active"><a onclick="return Twexter.ajax_load('/modules/cList/index/1', 'moduleContent');">List</a></li>
      <li><a onclick="return Twexter.dashboard.ajax_load_module('Message');">Message</a></li>
      <li><a onclick="return Twexter.dashboard.ajax_load_module('Stream');">Stream</a></li>
    </ul>
    <div id="moduleContent" >
    </div>
</div>
  </div>


</div> <!--class="container-fluid"-->