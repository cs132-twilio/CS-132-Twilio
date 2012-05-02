
/*(function($){
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
})(jQuery);*/


(function($){
  Twexter.modules.FlashCards = {
    run: function(){
      $.get('/modules/message/targets',
        function(r){
          $.ajax({
            type: "GET",
            url: "/assets/javascript/jquery.tokeninput.js",
            success: function(){
              $("#messageform input[name=n]").tokenInput(r,
                {
                  theme: "facebook",
                  hintText: "Enter a student or class name",
                  preventDuplicates: true
                }
              );
            },
            dataType: "script",
            cache: true
          });
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
          if (error) $(this).find('#message_sent').removeClass('success').addClass('error').text(error.message);
          else{
            $(this).find('[name=n],[name=m]').clearFields();
            $(this).find('#message_sent').removeClass('error').addClass('success').text('Your message was sent successfully!');
          }
        }, e)
      );
    }
  };
})(jQuery);