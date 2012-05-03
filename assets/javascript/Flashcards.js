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
          $('#deck').empty();
          //Twexter.modules.Flashcards.lastpost = 0;
          Twexter.modules.Flashcards.poll();
        }
      );
    },
    poll: function(){      
      $.get('/modules/flashcards/poll/' + $('#deckselect').val(),
        function(r){
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
		      $('<td>').text('[delete]')
		      )
		
		);  
	      
	      
              if (e.execute) (new Function(e.execute))();
            }
          );
	  
	  $tbl.attr('class', 'table table-striped');
	     
	  $('#deck').append($tbl); 
	  ($(document.createElement('div'))
	    .html('<a onclick="return Twexter.modules.Flashcards.addNewCard();">Add a new Card</a>')
	  ).appendTo($('#deck')).slideDown(); 
        }
      );
    },
    addNewDeck: function(){
      $('#deck').empty();
      ($(document.createElement('div'))
                .html('<form action="/modules/flashcards/adddeck" method="POST" id="adddeckform" class="well" onsubmit="return Twexter.modules.Flashcards.submit(this)"/><label>Deck Name:<input type="text" name="deckname" class="span5"></label><br /><button type="submit" class="btn">Add</button><span id="deck_added"></span></form>')
              ).prependTo($('#deck')).slideDown();        
      
    },
    submit: function(e){
      return !$(e).ajaxSubmit(
        $.proxy(function(r){
	 console.log(r);
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
	  if (error) $(this).find('#deck_added').removeClass('success').addClass('error').text(error.message);
          else{
            $(this).find('[name=deckname]').clearFields();
            $(this).find('#deck_added').removeClass('error').addClass('success').text(r.message);
	  }
        }, e)
      );
    }
  };
})(jQuery);


