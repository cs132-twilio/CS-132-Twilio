<?= form_open('/modules/classes/add', 'method="POST" id="messageform" class="well" onsubmit="return Twexter.modules.Classes.submit_add(this)"') ?>
  <h2>Add a class here</h2>
      <div class="clearfix">
	<input type="text" name="new-class" id="new-class" maxlength="20" size="30">
      </div>
	<br />
	<button type="submit" class="btn btn-success">Add Class</button>
	<span id="add_class"></span>
<?= form_close() ?>

<?= form_open('/modules/classes/delete', 'method="POST" id="messageform" class="well" onsubmit="return Twexter.modules.Classes.submit_delete(this)"') ?>
<h2>Delete classes here</h2>
      <div class="control-group"> 
	  <div class="controls"> 
	    <?foreach ($classlist as $c){
		echo '<label class="checkbox" data-cid="' . $c['id'] . '"><input type="checkbox" name="delete_' . $c['id'] . '" value="option1">'
		      . $c['name'] . '</label>';
	    }?>
	    <p class="help-block"><strong>Note:</strong> Deletion is permanent, you cannot undo this.</p> 
	  </div> 
       </div>
	<br />
	<button type="submit" class="btn btn-danger">Delete Classes</button>
	<span id="delete_class"></span>
<?= form_close() ?>



