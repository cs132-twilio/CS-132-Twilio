(function($){
  Twexter.modules.FlashCards = {   
    loop: null,
    setloop: function(){
      if ($('#deckselect').val() != ''){
        Twexter.modules.FlashCards.poll();
        Twexter.modules.FlashCards.loop = setInterval(Twexter.modules.FlashCards.poll, 500000);
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
      $.get('/modules/flashcards/poll/' + $('#deckselect').val(),
        function(r){
          $(r).each(
            function(i, e){
              ($(document.createElement('div'))
                .addClass('flash_post')
                .css('display', 'none')
                .append(
                  ($(document.createElement('div'))
                    .append(
                      ($(document.createElement('span'))
                        .addClass('flash_post_title')
                        .text(e.question)
                      )
                    )
                  ),
                  ($(document.createElement('div'))
                    .addClass('flash_post_message')
                    .html(e.answer)
                  )
                )
              ).prependTo($('#deck')).slideDown();              
              if (e.execute) (new Function(e.execute))();
            }
          );
        }
      );
    }
  };
})(jQuery);


