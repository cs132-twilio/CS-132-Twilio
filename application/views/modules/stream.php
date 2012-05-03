<link rel="Stylesheet" type="text/css" href="/assets/stylesheets/modules/stream.css">
<script type="text/javascript" src="/assets/javascript/jquery.timeago.js"></script>
<select id="streamselect">
  <?
    if (!count($stream)) echo '<option value="0">No Streams available</option>';
    foreach($stream as $s){
      echo '<option value="' . $s['id'] . '">Stream ' . $s['id'] . '</option>';
    }
  ?>
</select>
<div id="stream">
</div>