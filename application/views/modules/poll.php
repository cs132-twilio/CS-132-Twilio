<div id="contact-content-wrapper" class="content-wrapper">
	<?php echo form_open("/modules/poll/addPoll", 'class="new-poll" method="post" onsubmit="return submit(this);"') ?>
		<fieldset>
			<legend>Create a new poll</legend>
				<dl>
					<dt><label for="teacherID">Teacher ID</label></dt>
					<dd><input type="text" name="teacherID" id="teacherID"></dd>
					<dt><label for="classID">Class ID</label></dt>
					<dd><input type="text" name="classID" id="classID"></dd>
					<dt><label for="name">Poll Name</label></dt>
					<dd><input type="text" name="name" id="name"></dd>					
					<dt><label for="closingtime">Closing Time</label></dt>
					<dd><input type="datetime" name="closingtime" id="closingtime" value="<?php echo date("M j, Y - g:i"); ?>"></dd>					
				</dl>
			<input type="submit" value="Send" id="send">
		</fieldset>
	<?php echo form_close() ?> 
</div>

<select id="pollselect">
  <option value="0"></option>
  <option value="1">Poll 1</option>
</select>
<div id="poll">
</div>