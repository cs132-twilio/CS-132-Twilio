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
      echo '<tr><td>' . htmlentities($s['name']) . '</td><td>' . htmlentities($s['number']) . '</td></tr>';
    }
    ?>
  </tbody>
</table>