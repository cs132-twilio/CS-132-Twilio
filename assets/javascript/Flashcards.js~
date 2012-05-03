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
                .html('<form action="flashcards/add/deck" method="post" target="_blank">Name of Deck: <input type="text" name="deckname" /><input type="submit" value="Submit" /></form>')
              ).prependTo($('#deck')).slideDown();        
      
    }
    
    
    
    
  };
})(jQuery);


