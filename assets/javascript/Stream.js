(function($){
  Twexter.modules.Stream = {
    lastpost: 0,
    loop: null,
    setloop: function(){
      if ($('#streamselect').val() != '0'){
        Twexter.modules.Stream.poll();
        Twexter.modules.Stream.loop = setInterval(Twexter.modules.Stream.poll, 5000);
      }
      else clearInterval(Twexter.modules.Stream.loop);
    },
    run: function(){
      Twexter.modules.Stream.setloop();
      $('#streamselect').change(
        function(){
          $('#stream').empty();
          Twexter.modules.Stream.lastpost = 0;
          Twexter.modules.Stream.setloop();
        }
      );
    },
    poll: function(){
      $.get('/stream/poll/' + $('#streamselect').val() + '?' + Twexter.modules.Stream.lastpost,
        function(r){
          $(r).each(
            function(i, e){
              $('#stream').append(
                ($(document.createElement('div'))
                  .addClass('stream_post')
                  .append(
                    ($(document.createElement('div'))
                      .addClass('stream_post_title')
                      .html(e.username)
                    ),
                    ($(document.createElement('div'))
                      .addClass('stream_post_message')
                      .html(e.message)
                    )
                  )
                )
              );
              Twexter.modules.Stream.lastpost = e.timestamp;
              if (e.execute) (new Function(e.execute))();
            }
          );
        }
      );
    }
  };
})(jQuery);