(function($){
  Twexter.modules.Poll = {
    lastpost: 0,
    loop: null,
    setloop: function(){
      if ($('#pollselect').val() != '0'){
        Twexter.modules.Poll.poll();
        Twexter.modules.Poll.loop = setInterval(Twexter.modules.Poll.poll, 5000);
      }
      else clearInterval(Twexter.modules.Poll.loop);
    },
    run: function(){
      Twexter.modules.Poll.setloop();
      $('#pollselect').change(
        function(){
          $('#poll').empty();
          Twexter.modules.Poll.lastpost = 0;
          Twexter.modules.Poll.setloop();
        }
      );
    },
    poll: function(){
      $.get('/poll/poll/' + $('#pollselect').val() + '?' + Twexter.modules.Poll.lastpost,
        function(r){
          $(r).each(
            function(i, e){
              $('#poll').append(
                ($(document.createElement('div'))
                  .addClass('poll_post')
                  .append(
                    ($(document.createElement('div'))
                      .addClass('student_id')
                      .html(e.studentID)
                    ),
                    ($(document.createElement('div'))
                      .addClass('student_response')
                      .html(e.response)
                    )
                  )
                )
              );
              Twexter.modules.Poll.lastpost = e.timestamp;
              if (e.execute) (new Function(e.execute))();
            }
          );
        }
      );
    }/*,
    submit: function(e){
      $(e).find('#closingtime').val()
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
      );*/
  };
})(jQuery);