<link rel="Stylesheet" type="text/css" href="/assets/stylesheets/modules/stream.css">
<script type="text/javascript" src="/assets/javascript/jquery.timeago.js"></script>
<?= form_open('/modules/stream/delete/' . $c, 'id="deletestream_form" style="display: inline"') ?>
  <select id="streamselect" name="stream">
    <?
      if (!count($stream)) echo '<option value="0">No Streams available</option>';
      foreach($stream as $s){
        echo '<option value="' . $s['id'] . '"' . ($s['id'] == $sel ?' selected="selected"':'') . '>' . (empty($s['name'])? 'Stream ' . $s['id'] : $s['name']) . '</option>';
      }
    ?>
  </select>
<?= form_close() ?>
<?= form_open('/modules/stream/create/' . $c, 'id="newstream_form" style="display: inline"') ?>
  <span id="newstream_container"><input id="newstream_name" name="name" placeholder="Enter stream name"></span>
  <span class="btn btn-primary" id="newstream" style="margin-bottom: 9px;">Add New</span>
<?= form_close() ?>
<span class="btn btn-primary" id="deletestream" style="margin-bottom: 9px;">Delete stream</span>
<div id="streamid"<?= count($stream)?'':' style="display:none"'?>>Stream id: <span></span></div>
<div id="stream">
</div>