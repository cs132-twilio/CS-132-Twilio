<link rel="Stylesheet" type="text/css" href="/assets/stylesheets/tokeninput.facebook.css">
<?= form_open('/modules/message/send', 'method="POST" id="messageform" class="well" onsubmit="return Twexter.Message.submit(this)"') ?>
	<label>Message to:
    <input type="text" name="n" class="span5">
  </label>
	<label>Message:
    <textarea name="m" class="span5" rows="10"></textarea>
  </label>
	<br />
	<button type="submit" class="btn">Send</button><span id="message_sent"></span>
<?= form_close() ?>
