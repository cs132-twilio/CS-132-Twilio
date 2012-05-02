(function($){
  Twexter.modules.FlashCards = {   
    loop: null,
    setloop: function(){
      if ($('#flashselect').val() != '0'){
        Twexter.modules.FlashCards.poll();
        Twexter.modules.FlashCards.loop = setInterval(Twexter.modules.FlashCards.poll, 500000);
      }
      else clearInterval(Twexter.modules.FlashCards.loop);
    },
    run: function(){
      Twexter.modules.FlashCards.setloop();
      $('#flashselect').change(
        function(){
          $('#flash').empty();
          Twexter.modules.FlashCards.lastpost = 0;
          Twexter.modules.FlashCards.setloop();
        }
      );
    },
    poll: function(){
      $.get('/modules/flashcards/poll/' + $('#flashselect').val(),
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
              ).prependTo($('#flash')).slideDown();              
              if (e.execute) (new Function(e.execute))();
            }
          );
        }
      );
    }
  };
})(jQuery);