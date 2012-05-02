(function($){
  Twexter.modules.Flashcards = {   
    loop: null,
    setloop: function(){
      if ($('#deckselect').val() != ''){
        Twexter.modules.Flashcards.poll();
        Twexter.modules.Flashcards.loop = setInterval(Twexter.modules.Flashcards.poll, 1000);
      }
      else clearInterval(Twexter.modules.Flashcards.loop);
    },
    run: function(){
      Twexter.modules.Flashcards.setloop();
      $('#deckselect').change(
        function(){
          $('#deck').empty();
          Twexter.modules.Flashcards.lastpost = 0;
          Twexter.modules.Flashcards.setloop();
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
              (              
              $(document.createElement('div'))
                .text('test2') 
              ).prependTo($('#deck')).slideDown();
              $(document.createElement('div'))
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


