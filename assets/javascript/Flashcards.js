(function($){
  Twexter.modules.Flashcards = {   
    loop: null,
 /*
    setloop: function(){
      if ($('#deckselect').val() != ''){
        Twexter.modules.Flashcards.poll();
        Twexter.modules.Flashcards.loop = setInterval(Twexter.modules.Flashcards.poll, 1000);
      }
      else clearInterval(Twexter.modules.Flashcards.loop);
    },*/
    run: function(){
      //Twexter.modules.Flashcards.setloop();
      $('#deckselect').change(
        function(){
          $('#deck-form-div').empty();
          //Twexter.modules.Flashcards.lastpost = 0;
          Twexter.modules.Flashcards.poll();
        }
      );
      $('#deckselect').change();
    },
    poll: function(){ 
      $('#deck-form-div').empty();
      $.ajax('/modules/flashcards/poll/' + $('#deckselect').val(),
	{
	  success: function(r){
	    var $tbl = $('<table>').attr('id', 'cardsTable');
	    $tbl.append(
		    $('<tr>')
			.append($('<th>').text('#'),
			$('<th>').text('Question'),
			$('<th>').text('Answer'),
			$('<th>').text('Delete')
			)
		  
		  );  
	    $(r).each(
	      function(i, e){              
		  $tbl.append(
		    $('<tr>')
			.append($('<td>').text(e.position),
			$('<td>').text(e.question),
			$('<td>').text(e.answer),
			$('<td>').html('<input type="checkbox" name="deletecard[]" value="' + e.position + '"></input>')
			)
		  
		  );  
		
		
		if (e.execute) (new Function(e.execute))();
	      }
	    );
	    
	    $tbl.attr('class', 'table table-striped');	
	    $('#delete-card-deckname').attr('value', $('#deckselect').val());
	      
	    $('#deck-form-div').append($tbl); 
	    $('#delete-button').show();
	  },
	  cache: false
	}
      );
    },
    submitAddDeck: function(e){
      
      return !$(e).ajaxSubmit(     
        $.proxy(function(r){
          var error = r.success === 0 ? r[0] : undefined;
          if (!error){
            $(r).each(
              function(i, e){
                if (!e.success){
                  error = e;
                  return false;
                }
              }
            );
          }
          $('.flashcard-msg').empty();
	  $('.flashcard-msg').removeClass('success');
	  $('.flashcard-msg').removeClass('error');
	  if (error) $(this).find('#deck_added').removeClass('success').addClass('error').text(error.message);
          else{
            $(this).find('[name=deckname]').clearFields();
            $(this).find('#deck_added').removeClass('error').addClass('success').text(r.message);
	    Twexter.modules.Flashcards.listDecks();
	  }
        }, e)
      );
    },
    submitAddCard: function(e){
      
      return !$(e).ajaxSubmit(      
        $.proxy(function(r){
          var error = r.success === 0 ? r[0] : undefined;
          if (!error){
            $(r).each(
              function(i, e){
                if (!e.success){
                  error = e;
                  return false;
                }
              }
            );
          }
          $('.flashcard-msg').empty();
	  $('.flashcard-msg').removeClass('success');
	  $('.flashcard-msg').removeClass('error');	 
	  if (error) $(this).find('#card_added').removeClass('success').addClass('error').text(error.message);
          else{
            $(this).find('[name=question]').clearFields();
	    $(this).find('[name=answer]').clearFields();
            $(this).find('#card_added').removeClass('error').addClass('success').text(r.message);
	    Twexter.modules.Flashcards.listDecks();
	  }
        }, e)
      );
    },
    submitDeleteCard: function(e){      
      return !$(e).ajaxSubmit(      
        $.proxy(function(r){	  
          var error = r.success === 0 ? r[0] : undefined;
          if (!error){
            $(r).each(
              function(i, e){
                if (!e.success){
                  error = e;
                  return false;
                }
              }
            );
          }
          $('.flashcard-msg').empty();
	  $('.flashcard-msg').removeClass('success');
	  $('.flashcard-msg').removeClass('error');
	  if (error) $(this).find('#card_deleted').removeClass('success').addClass('error').text(error.message);
          else{
            $(this).find('[name=deletecard]').clearFields();
            $(this).find('#card_deleted').removeClass('error').addClass('success').text(r.message);
	    Twexter.modules.Flashcards.listDecks();
	    
	  }
        }, e)
      );
    },
    submitDeleteDeck: function(e){      
      return !$(e).ajaxSubmit(
        $.proxy(function(r){	  
          var error = r.success === 0 ? r[0] : undefined;
          if (!error){
            $(r).each(
              function(i, e){
                if (!e.success){
                  error = e;
                  return false;
                }
              }
            );
          }
          $('.flashcard-msg').empty();
	  $('.flashcard-msg').removeClass('success');
	  $('.flashcard-msg').removeClass('error');
	  if (error) $(this).find('#deck_deleted').removeClass('success').addClass('error').text(error.message);
          else{
            $(this).find('#deck_deleted').removeClass('error').addClass('success').text(r.message);
	    Twexter.modules.Flashcards.listDecks();	    
	  }
        }, e)
      );
    },
    listDecks: function() {
      var old_main_val = $('#deckselect').val();
      var old_del_val = $('#deckselect-deletedeck').val();
      var old_add_val = $('#deckselect-addcard').val();
      $('#deckselect').empty();
      $('#deckselect-deletedeck').empty();
      $('#deckselect-addcard').empty();
      $.ajaxSetup({
	  async: false,
	  cache:false
	});
      
      $.get('/modules/flashcards/listdecks',
        function(r){
	  if(r.length<1) {
	    $('#deckselect').append('<option>-Select a Deck-</option>');
	    $('#deckselect-addcard').append('<option>-Select a Deck-</option>');
	  }	  
	  $('#deckselect-deletedeck').append('<option>-Select a Deck-</option>');	  
          $(r).each(
            function(i, e){              
		$('#deckselect').append('<option value="' + e.deck_name + '">' + e.deck_name + '</option>');
		$('#deckselect-deletedeck').append('<option value="' + e.deck_name + '">' + e.deck_name + '</option>');
		$('#deckselect-addcard').append('<option value="' + e.deck_name + '">' + e.deck_name + '</option>');
              if (e.execute) (new Function(e.execute))();
            }
          );
        }
      );      
      $.ajaxSetup({
	  async: true,
	  cache: true
	});
      $('#deckselect').val(String(old_main_val));
      $('#deckselect-deletedeck').val(String(old_del_val));
      $('#deckselect-addcard').val(String(old_add_val));
      Twexter.modules.Flashcards.poll();
      
    },
    confirmSubmit: function()
    {
    var agree=confirm("Are you sure you wish to continue?");
    if (agree)
	    return true ;
    else
	    return false ;
    }
    ,
    switchInteractionPane: function(type)
    {    
     switch(type) {
       case 'delete-deck':
	  $('#add-new-deck').hide();
	  $('#add-new-card').hide();
	  $('#delete-deck').show();
	  break;
       case 'add-deck':	  
	  $('#add-new-card').hide();
	  $('#delete-deck').hide();
	  $('#add-new-deck').show();
	  break;
       case 'add-card':
	  $('#add-new-deck').hide();	  
	  $('#delete-deck').hide();
	  $('#add-new-card').show();
	 break;
     }
    }
 
  };
})(jQuery);


