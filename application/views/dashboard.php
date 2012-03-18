<!-- Dashboard for Twexter site -->



<!--<div class="hero-unit">
  <h1>Hello, world!</h1>
  <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
  <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
</div>-->

<!-- Example row of columns -->
<!--<div class="row">
  <div class="span4">
    <h2>Heading</h2>
     <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
    <p><a class="btn" href="#">View details &raquo;</a></p>
  </div>
  <div class="span4">
    <h2>Heading</h2>
     <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
    <p><a class="btn" href="#">View details &raquo;</a></p>
 </div>
  <div class="span4">
    <h2>Heading</h2>
    <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
    <p><a class="btn" href="#">View details &raquo;</a></p>
  </div>
</div>

<hr>

<footer>
  <p>&copy; Company 2012</p>
</footer>-->
<div class="container-fluid">
  <div class="row-fluid">
<div class="span2">
  <!--Sidebar content-->
  <ul class="nav nav-pills nav-stacked">
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
      <li onclick="this.className='active'"><?php echo $this->ajax->link_to_remote("Message", array('url' => '/welcome/ajax/message.php', 'update' => 'moduleContent')); ?></li>
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