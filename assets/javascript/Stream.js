(function($){
  Twexter.Stream = {
    lastpost: 0,
    loop: null,
    setloop: function(){
      if ($('#streamselect').val() != '0'){
        Twexter.Stream.poll();
        Twexter.Stream.loop = setInterval(Twexter.Stream.poll, 5000);
      }
      else clearInterval(Twexter.Stream.loop);
    },
    run: function(){
      Twexter.Stream.setloop();
      $('#streamselect').change(Twexter.Stream.setloop);
    },
    poll: function(){
      $.get('/stream/poll/' + $('#streamselect').val() + '?' + Twexter.Stream.lastpost,
        function(r){
          $(r).each(
            function(i, e){
              $('#stream').append(
                ($(document.createElement('div'))
                  .addClass('stream_post')
                  .append(
                    ($(document.createElement('div'))
                      .addClass('stream_post_title')
                      .text(e.username)
                    ),
                    ($(document.createElement('div'))
                      .addClass('stream_post_message')
                      .text(e.message)
                    )
                  )
                )
              );
              Twexter.Stream.lastpost = e.timestamp;
            }
          );
        }
      );
    }
  };
})(jQuery);