<select id="deckselect">
  <option value="">-Select a Deck</option>
  <option value="test">test</option>
  <option value="biology">biology</option>
</select>
<a onclick="return Twexter.modules.Flashcards.addNewDeck();">Add a new Deck</a>

<?= form_open('/modules/flashcards/adddeck', 'method="POST" id="adddeckform2" class="well" onsubmit="return Twexter.modules.Flashcards.submit(this)"') ?>
	<label>Deck Name:
    <input type="text" name="deckname" class="span5">
  </label>	
	<br />
	<button type="submit" class="btn">Add</button><span id="deck_added"></span>
<?= form_close() ?>

<div id="deck">
</div>