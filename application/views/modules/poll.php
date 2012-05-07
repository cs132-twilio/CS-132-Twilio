<link rel="Stylesheet" type="text/css" href="/assets/stylesheets/modules/poll.css">
<script type="text/javascript" src="/assets/javascript/Poll.js"></script>

<div class="container-fluid">
  <div class="row-fluid">
      <div id="contact-content-wrapper" class="span6">
	      <?php echo form_open("/modules/poll/addPoll", 'id="new-poll-form" class="well" method="post" onsubmit="return !Twexter.modules.Poll.submit(this);"') ?>
		      <fieldset>
			  <legend>Create a new poll</legend>
			  <label for="name">Poll Name</label>
			  <input type="text" name="name" class="">
			  <label for="type">Poll Type</label>
			  <select name="polltype" class="">
			    <option value="">Select a type</option>
			    <option value="mc">Multiple Choice (A-D)</option>
			    <option value="fr">Free Response</option>
			  </select>
        <label for ="closingtime">Poll Duration</label>
        <select name="closingtime" class="">
          <option value="">Select a duration</option>
          <option value="1">1 hour</option>
          <option value="2">2 hours</option>
          <option value="5">5 hours</option>
          <option value="24">24 hours</option>
        </select>
			  <dl><button type="submit" value="create" class="btn btn-primary">Create</button></dl>
			  <span id="message_create"></span>
		      </fieldset>
	      <?php echo form_close() ?> 
      </div>
      <div id="select-poll-wrapper" class="span6">
	      <?php echo form_open('/modules/poll/analyzePoll/' . $c, 'class="well" id="poll_form_view" method="post" onsubmit="Twexter.modules.Poll.submit(this); return false"') ?>
		      <fieldset>
			<legend>View data for a poll</legend>
			  <label for="type">Poll Name</label>
			  <select id="pollselect" name="pollselect">
			      <option value="">Select a poll</option>
			      <?php
				  foreach ($results as $j => $currpoll) {
				    $id = $results[$j]['pollID'];
				    $name = $results[$j]['name'];
			      ?>
				    <option value="<?php echo $id ?>"><?php echo $name ?></option>
			      <?php
				  }
			      ?>
			  </select>
			  <dl><button type="submit" value="view" class="btn btn-primary">View</button></dl>
			  <span id="message_view"></span>	
		      </fieldset>
	      <?php echo form_close() ?> 
      </div>
  </div>
  <div class="row-fluid">
      <div id="delete-poll" class="span6">
	<?php echo form_open("/modules/poll/deletePoll", 'class="well" method="post" onsubmit="return !Twexter.modules.Poll.submit(this);"') ?>
	      <fieldset>
		  <legend>Delete a poll</legend>
		  <label for="type">Poll Name</label>
		  <select id="pollselect" name="pollselect">
		      <option value="">Select a poll</option>
		      <?php
			  foreach ($results as $j => $currpoll) {
			    $id = $results[$j]['pollID'];
			    $name = $results[$j]['name'];
		      ?>
			    <option value="<?php echo $id ?>"><?php echo $name ?></option>
		      <?php
			  }
		      ?>
		  </select>
		  <dl><button type="submit" value="delete" class="btn btn-primary">Delete</button></dl>
		  <span id="message_delete"></span>
	      </fieldset>
	  <?php echo form_close() ?> 
      </div>
      
  </div>

  <div class="row-fluid">
      <div id="chart_div" class="span6"></div>
  </div>
</div>

