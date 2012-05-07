<link rel="Stylesheet" type="text/css" href="/assets/stylesheets/modules/message.css">
<link rel="Stylesheet" type="text/css" href="/assets/stylesheets/tokeninput.facebook.css">
<div>
<?= form_open('/modules/message/send', 'method="POST" id="messageform" class="well" onsubmit="return Twexter.modules.Message.submit(this)"') ?>
  <div id="message_input">
    <label>Message to:
      <input type="text" name="n" class="span6">
    </label>
    <label>Message:
      <textarea name="m" rows="10"></textarea>
    </label>
    <br />
    <button type="submit" class="btn">Send</button>
  </div>
  <div id="message_log"></div>
<?= form_close() ?>