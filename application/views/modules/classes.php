<?= form_open('/modules/classes/add', 'method="POST" id="messageform" class="well" onsubmit="return Twexter.modules.Classes.submit_add(this)"') ?>
  <h2>Add a class</h2>
      <div class="clearfix">
	<input type="text" name="new-class" id="new-class" maxlength="20" size="30" placeholder="Type the name of your class">
        </div>
	<br />
	<button type="submit" class="btn btn-success">Add a new class</button>
	<span id="add_class"></span>
<?= form_close() ?>

<?= form_open('/modules/classes/delete', 'method="POST" id="messageform" class="well" onsubmit="return Twexter.modules.Classes.submit_delete(this)"') ?>
<h2>Delete classes</h2>
      <div class="clearfix">
      <div class="control-group"> 
	  <div class="controls"> 
	    <?foreach ($classlist as $c){
		echo '<label class="checkbox" data-cid="' . $c['id'] . '"><input type="checkbox" name="delete_' . $c['id'] . '" value="'. $c['id'] .'">'
		      . $c['name'] . '</label>';
	    }?>
	    </div>
	  </div> 
       </div>
       <div class="alert alert-block alert-error">
		  <h4 class="alert-heading">Warning!</h4> 
		  <p>Deletion cannot be undone.</p> 
	</div>
	<button type="submit" class="btn btn-danger">Delete Classes</button>
	<span id="delete_class"></span>
<?= form_close() ?>



