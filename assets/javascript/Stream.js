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
      $.get('/modules/stream/poll/' + $('#streamselect').val() + '?' + Twexter.modules.Stream.lastpost,
        function(r){
          $(r).each(
            function(i, e){
              ($(document.createElement('div'))
                .addClass('stream_post')
                .css('display', 'none')
                .append(
                  ($(document.createElement('div'))
                    .append(
                      ($(document.createElement('span'))
                        .addClass('stream_post_title')
                        .text(e.name)
                      ),
                      ($(document.createElement('span'))
                        .addClass('stream_post_timestamp')
                        .text(' (' + $.timeago(new Date(e.timestamp * 1000)) + ')')
                      )
                    )
                  ),
                  ($(document.createElement('div'))
                    .addClass('stream_post_message')
                    .html(e.message)
                  )
                )
              ).prependTo($('#stream')).slideDown();
              Twexter.modules.Stream.lastpost = e.timestamp;
              if (e.execute) (new Function(e.execute))();
            }
          );
        }
      );
    }
  };
})(jQuery);