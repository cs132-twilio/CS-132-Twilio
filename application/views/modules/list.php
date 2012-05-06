<link rel="Stylesheet" type="text/css" href="/assets/stylesheets/modules/list.css">
<script type="text/javascript" src="/assets/javascript/List.js"></script>





<div class="alert alert-info">
   <strong>Hey there!</strong> If you want more students to join this classroom, ask them to text "JOIN <?php echo $class_id; ?>" at +1....   
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Student Name</th>
    </tr>
  </thead>
  <tbody>
    <?
    foreach($students as $s){
      echo '<tr data-sid="' . $s['id'] . '"><td>' . htmlentities($s['name']) . '</td><td><img class="list_removestudent" src="/assets/images/glyphicons_207_remove_2.png"</td></tr>';
    }
    ?>
  </tbody>
</table>