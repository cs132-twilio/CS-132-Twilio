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
		      $('<td>').html('<input type="checkbox" name="deletecard[]" value="' + e.position + '"></input>')
		      )
		
		);  
	      
	      
              if (e.execute) (new Function(e.execute))();
            }
          );
	  
	  $tbl.attr('class', 'table table-striped');	
	  $('#delete-card-deckname').attr('value', $('#deckselect').val());
	     
	  $('#deck-form-div').append($tbl); 
        }
      );
    },
    submit: function(e){
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
	  if (error) $(this).find('#deck_added').removeClass('success').addClass('error').text(error.message);
          else{
            $(this).find('[name=deckname]').clearFields();
            $(this).find('#deck_added').removeClass('error').addClass('success').text(r.message);
	  }
        }, e)
      );
    },
    submitCard: function(e){
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
	  if (error) $(this).find('#card_added').removeClass('success').addClass('error').text(error.message);
          else{
            $(this).find('[name=question]').clearFields();
	    $(this).find('[name=answer]').clearFields();
            $(this).find('#card_added').removeClass('error').addClass('success').text(r.message);
	  }
        }, e)
      );
    },
    submitDelete: function(e){
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
	  if (error) $(this).find('#card_deleted').removeClass('success').addClass('error').text(error.message);
          else{
            $(this).find('[name=deletecard]').clearFields();
            $(this).find('#card_deleted').removeClass('error').addClass('success').text(r.message);
	    Twexter.modules.Flashcards.poll();
	    
	  }
        }, e)
      );
    }
  };
})(jQuery);


