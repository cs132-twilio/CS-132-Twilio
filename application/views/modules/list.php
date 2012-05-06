<script type="text/javascript" src="/assets/javascript/List.js"></script>
Class ID: <?= $class_id ?>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th>Number</th>
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