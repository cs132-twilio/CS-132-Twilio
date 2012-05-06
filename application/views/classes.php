<div class="span8 offset1 welcome_container">
<div class="row" id="classes">
<div class="padding page">

<div class="page-header">
	  <h1>Manage your classes</h1>
</div> 
<?= form_open('/classes/add', 'method="POST" id="addform" class="well" onsubmit="return Twexter.Classes.submit_add(this)"') ?>
  <div class="page-header">
  <h2>Add a new class</h2>
  </div>
      <div class="clearfix">
	<input type="text" name="new-class" id="new-class" maxlength="20" size="30" placeholder="Type the name of your class">
        </div>
	<br />
	<button type="submit" class="btn btn-success">Add a new class</button>
	</br>
	<span id="add_class"></span>
<?= form_close() ?>



<?= form_open('/classes/delete', 'method="POST" id="deleteform"  class="well" onsubmit="return Twexter.Classes.submit_delete(this)"') ?>
  <div class="page-header">
  <h2>Delete classes</h2>
  </div>

  <div class="clearfix">
      <div class="control-group"> 
	  <div class="controls" id="list_of_classes"> 
	    <?foreach ($classlist as $c){
		echo '<label class="checkbox" id="delete_class_' . $c['id'] . '"><input type="checkbox" name="delete_class_' . $c['id'] . '" value="'. $c['id'] .'">'
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
	</br>
	<span id="delete_class"></span>
<?= form_close() ?>

<!--</div>-->
<!--</div>-->
</div>


