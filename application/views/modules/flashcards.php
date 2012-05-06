<script type="text/javascript" src="assets/javascript/Flashcards.js"></script>
<? $this->load->helper('form'); ?>
<select id="deckselect">
  <option value="-1">-Select a Deck-</option>
  <?
    if (!count($decks)) echo '<option value="0">No Decks available</option>';
      foreach($decks as $d){
	echo '<option value="' . $d['deck_name'] . '">' . $d['deck_name'] . '</option>';
      }
  ?>
</select>


<div id="deck">
  <?= form_open('/modules/flashcards/deletecard', 'method="POST" id="deck-form" onsubmit="return Twexter.modules.Flashcards.submitDeleteCard(this)"') ?>
    <div id="deck-form-div">
    </div>
    <input type="hidden" id="delete-card-deckname" name="deckname" value=""></input>
    <button type="submit" class="btn btn-danger" style="display : none;" id="delete-button" onClick="return Twexter.modules.Flashcards.confirmSubmit()">Delete Selected Cards</button>
    <span id="card_deleted"></span>
  <?= form_close() ?>  
</div>

<a onclick="return Twexter.modules.Flashcards.switchInteractionPane('add-deck');" class="btn btn-small btn-primary">Add a new Deck</a>
<a onclick="return Twexter.modules.Flashcards.switchInteractionPane('add-card');;" class="btn btn-small btn-primary">Add a new Card</a>
<a onclick="return Twexter.modules.Flashcards.switchInteractionPane('delete-deck');;" class="btn btn-small btn-primary">Delete a Deck</a>

<div id="add-new-deck" style="display : none;">
  <h3>Add new Deck</h3>
  <?= form_open('/modules/flashcards/adddeck', 'method="POST" id="adddeckform" class="well" onsubmit="return Twexter.modules.Flashcards.submitAddDeck(this)"') ?>
    <label>Deck Name:
      <input type="text" name="deckname" class="span5">
    </label>	
    <br />
    <button type="submit" class="btn">Add</button>
    <span id="deck_added"></span>
  <?= form_close() ?>
  <a onclick="return $('#add-new-deck').hide();">Hide</a>
</div>


<div id="add-new-card" style="display : none;">
  <h3>Add new Card</h3>
  <?= form_open('/modules/flashcards/addcard', 'method="POST" id="addcardform" class="well" onsubmit="return Twexter.modules.Flashcards.submitAddCard(this)"') ?>
    <label>Add to:
      <select id="deckselect-addcard" name="deckname">
	<option value='-1'>-Select a Deck-</option>
	<?
	  if (!count($decks)) echo '<option value="0">No Decks available</option>';
	  foreach($decks as $d){
	    echo '<option value="' . $d['deck_name'] . '">' . $d['deck_name'] . '</option>';
	  }
	?>
      </select>
    </label>
    <label>Question:
      <input type="text" name="question" class="span5">
    </label>
    <label>Answer:
      <input type="text" name="answer" class="span5">
    </label>
    <br />
    <button type="submit" class="btn">Add</button>
    <span id="card_added"></span>
  <?= form_close() ?>
  <a onclick="return $('#add-new-card').hide();">Hide</a>
</div>


<div id="delete-deck" style="display : none;">
  <h3>Delete Deck</h3>
  <?= form_open('/modules/flashcards/deletedeck', 'method="POST" id="deletedeckform" class="well" onsubmit="return Twexter.modules.Flashcards.submitDeleteDeck(this)"') ?>
    <label>Delete:
      <select id="deckselect-deletedeck" name="deckname">
	<option value='-1'>-Select a Deck-</option>
	<?
	  if (!count($decks)) echo '<option value="0">No Decks available</option>';
	  foreach($decks as $d){
	    echo '<option value="' . $d['deck_name'] . '">' . $d['deck_name'] . '</option>';
	  }
	?>
      </select>
    </label>
    <br />
    <button type="submit" class="btn btn-danger" onClick="return Twexter.modules.Flashcards.confirmSubmit()">Delete</button><span id="deck_deleted"></span>
  <?= form_close() ?>
  <a onclick="return $('#delete-deck').hide();">Hide</a>
</div>






