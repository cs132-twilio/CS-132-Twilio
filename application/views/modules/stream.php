<link rel="Stylesheet" type="text/css" href="/assets/stylesheets/modules/stream.css">
<script type="text/javascript" src="/assets/javascript/jquery.timeago.js"></script>
<select id="streamselect">
  <?
    if (!count($stream)) echo '<option value="0">No Streams available</option>';
    foreach($stream as $s){
      echo '<option value="' . $s['id'] . '"' . ($s['id'] == $sel ?' selected="selected"':'') . '>' . (empty($s['name'])? 'Stream ' . $s['id'] : $s['name']) . '</option>';
    }
  ?>
</select>
<input id="newstream_name" style="display:none;">
<span class="btn btn-primary" id="newstream" style="margin-bottom: 9px;">Add New...</span>
<div id="stream">
</div>