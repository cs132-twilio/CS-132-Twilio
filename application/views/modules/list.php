<script type="text/javascript" src="/assets/javascript/List.js"></script>



<table class="table table-striped">
  <thead>
    <tr>
      <th>Student Name</th>
    </tr>
  </thead>
  <tbody>
    <?
    foreach($students as $s){
      echo '<tr data-sid="' . $s['id'] . '"><td>' . htmlentities($s['name']) . '</td><td>' . htmlentities($s['number']) . '</td><td><a href="#" class="list_removestudent close">&times;</a></td></tr>';
    }
    ?>
  </tbody>
</table>

<div class="alert alert-info">
   Students can <strong>join <?php echo $class_name['name']; ?> </strong> by texting "JOIN <?php echo $class_id; ?>"</strong> to <?php echo $phone["phone_number"] ?>.</strong>  
</div>
