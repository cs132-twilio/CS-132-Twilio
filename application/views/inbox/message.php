<? $messages = $messages[0]; ?>
<div class="message_view_from">From: <?= $messages['from'] ?></div>
<div class="message_view_timestamp">Date: <?= $messages['timestamp'] ?></div>
<div class="message_view_message"><?= $messages['message'] ?></div>
<div>
  <?= form_open('/inbox/reply', 'class="message_view_reply" onsubmit="return Twexter.inbox.submit(this);"') ?>
    <div><textarea name="m"></textarea></div>
    <input type="hidden" name="to" value="<?= $messages['fromid'] ?>">
    <?= form_submit(null, 'Reply', 'class="btn btn-primary"') ?>
  <?= form_close() ?>
</div>