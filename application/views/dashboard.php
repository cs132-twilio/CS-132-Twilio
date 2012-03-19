<script type='text/javascript' src='/assets/javascript/dashboard.js'></script>
<div class="container-fluid">
  <div class="row-fluid">
<div class="span2">
  <!--Sidebar content-->
  <ul id="classTabs" class="nav nav-pills nav-stacked">
      <li class="nav-header"><h4>Your Classes</h4></li>
      <li class="active"><?php echo $this->ajax->link_to_remote("Math", array('url' => '/welcome/ajax/list.php', 'update' => 'moduleContent')); ?></li>
      <li onclick="this.className='active'"><?php echo $this->ajax->link_to_remote("Biology", array('url' => '/welcome/ajax/list.php', 'update' => 'moduleContent')); ?></li>
      <li onclick="this.className='active'"><?php echo $this->ajax->link_to_remote("Web Applications", array('url' => '/welcome/ajax/list.php', 'update' => 'moduleContent')); ?></li>
  </ul>
</div>

<div id="modules" class="span10">
  <!--Body content-->
    <ul id="moduleTabs" class="nav nav-tabs">
      <li class="active"><?php echo $this->ajax->link_to_remote("List", array('url' => '/welcome/ajax/list.php', 'update' => 'moduleContent')); ?></li>
      <li><?php echo $this->ajax->link_to_remote("Message", array('url' => '/welcome/ajax/message.php', 'update' => 'moduleContent')); ?></li>
    </ul>
    <div id="moduleContent" >
<!--       LIST!!! (redundant) -->
	<table class="table table-striped">
	  <thead>
	    <tr>
	      <th>First Name</th>
	      <th>Last Name</th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr>
	      <td>Angela</td>
	      <td>Santin</td>
	    </tr>
	    <tr>
	      <td>Siffat</td>
	      <td>Hingorani</td>
	    </tr>
	    <tr>
	      <td>Peter</td>
	      <td>Ciullo</td>
	    </tr>
	    <tr>
	      <td>Ryan</td>
	      <td>Chan</td>
	    </tr>
	  </tbody>
	</table>
    </div>
</div>
  </div>


</div> <!--class="container-fluid"-->