<? foreach($messages as $m){ ?>
  <div class="inbox_message alert" data-id="<?= $m['id'] ?>">
    <div class="inbox_title">
      <span class="inbox_from"><?= $m['from'] ?></span>
      <span class="inbox_raquo">&raquo;</span>
      <span class="inbox_excerpt"><?= $m['message'] ?></span>
      <span class="inbox_timestamp timeago" title="<? $dt = (new DateTime($m['timestamp'])); echo $dt->format(DateTime::ISO8601) ?>"></span>
    </div>
  </div>
<? } ?>