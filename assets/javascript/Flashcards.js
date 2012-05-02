(function($){
  Twexter.modules.Flashcards = {   
    loop: null,
    setloop: function(){
      if ($('#deckselect').val() != ''){
        Twexter.modules.FlashCards.poll();
        Twexter.modules.FlashCards.loop = setInterval(Twexter.modules.FlashCards.poll, 1000);
      }
      else clearInterval(Twexter.modules.FlashCards.loop);
    },
    run: function(){
      Twexter.modules.FlashCards.setloop();
      $('#deckselect').change(
        function(){
          $('#deck').empty();
          Twexter.modules.FlashCards.lastpost = 0;
          Twexter.modules.FlashCards.setloop();
        }
      );
    },
    poll: function(){
      ($(document.createElement('div'))
                .text('test') 
              ).prependTo($('#deck')).slideDown();
      $.get('/modules/flashcards/poll/' + $('#deckselect').val(),
        function(r){
          $(r).each(
            function(i, e){
              ($(document.createElement('div'))
                .text(e.question)                

              ).prependTo($('#deck')).slideDown();              
              if (e.execute) (new Function(e.execute))();
            }
          );
        }
      );
    }
  };
})(jQuery);


