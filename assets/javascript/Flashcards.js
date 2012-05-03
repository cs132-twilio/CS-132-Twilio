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
          $(r).each(
            function(i, e){   
              ($(document.createElement('div'))
                .text(e.position + ' | Q: ' + e.question + ' A: ' + e.answer)
              ).prependTo($('#deck')).slideDown();              
              if (e.execute) (new Function(e.execute))();
            }
          );
        }
      );
    },
    addNewDeck: function(){
      $('#deck').empty();
      ($(document.createElement('div'))
                .html('<form action="modules/flashcards/adddeck" method="post" target="_blank">Name of Deck: <input type="text" name="deckname" /><input type="submit" value="Submit" /></form>')
              ).prependTo($('#deck')).slideDown();        
      
    },
    submit: function(e){
      return !$(e).ajaxSubmit(
        $.proxy(function(r){
	 console.log(e);
          var error = r.success === 0 ? r[0] : undefined;
          if (!error){
            $(r).each(
              function(i, e){
		console.log(e);
                if (!e.success){
		  console.log(e);
                  error = e;
                  return false;
                }
              }
            );
          }
          if (error) $(this).find('#message_sent').removeClass('success').addClass('error').text(error.message);
          else{
	    console.log(e);
            console.log('submit was hit lol');
          }
        }, e)
      );
    }
    
    
    
    
  };
})(jQuery);


