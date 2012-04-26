<script type='text/javascript' src='/assets/javascript/dashboard.js'></script>
<div class="container-fluid">
  <div class="row-fluid">
<div class="span2">
  <!--Sidebar content-->
  <ul id="classTabs" class="nav nav-pills nav-stacked">
      <li class="nav-header"><h4>Your Classes</h4></li>
      <li class="active"><a onclick="return ajax_load('/welcome/ajax/list.php', 'moduleContent');">Math</a></li>
      <li onclick="this.className='active'"><a onclick="return ajax_load('/welcome/ajax/list.php', 'moduleContent');">Biology</a></li>
      <li onclick="this.className='active'"><a onclick="return ajax_load('/welcome/ajax/list.php', 'moduleContent');">Web Applications</a></li>
  </ul>
</div>

<div id="modules" class="span10">
  <!--Body content-->
    <ul id="moduleTabs" class="nav nav-tabs">
      <li class="active"><a onclick="return ajax_load_module('List');">List</a></li>
      <li><a onclick="return ajax_load_module('Message');">Message</a></li>
      <li><a onclick="return ajax_load_module('Stream');">Stream</a></li>
    </ul>
    <div id="moduleContent" >
    <?php include 'application/views/modules/list.php'; ?>
    </div>
</div>
  </div>


</div> <!--class="container-fluid"-->