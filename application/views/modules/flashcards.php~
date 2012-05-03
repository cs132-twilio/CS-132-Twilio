<select id="deckselect">
  <option value="">-Select a Deck</option>
  <option value="test">test</option>
  <option value="biology">biology</option>
</select>
<a onclick="return Twexter.modules.Flashcards.addNewDeck();">Add a new Deck</a>

<div id="deck">
</div>

<div id="add-new-deck">
Add new Deck
<?= form_open('/modules/flashcards/adddeck', 'method="POST" id="adddeckform" class="well" onsubmit="return Twexter.modules.Flashcards.submit(this)"') ?>
	<label>Deck Name:
    <input type="text" name="deckname" class="span5">
  </label>	
	<br />
	<button type="submit" class="btn">Add</button><span id="deck_added"></span>
<?= form_close() ?>
</div>

<div id="add-new-card">
Add new Card
<?= form_open('/modules/flashcards/addcard', 'method="POST" id="addcardform" class="well" onsubmit="return Twexter.modules.Flashcards.submit(this)"') ?>
	<label>Question:
    <input type="text" name="question" class="span5">
  </label>
  <label>Answer:
    <input type="text" name="answer" class="span5">
  </label>
	<br />
	<button type="submit" class="btn">Add</button><span id="card_added"></span>
<?= form_close() ?>
</div>


