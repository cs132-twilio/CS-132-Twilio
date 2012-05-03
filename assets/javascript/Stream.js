(function($){
  Twexter.modules.Stream = {
    lastpost: 0,
    loop: null,
    setloop: function(){
      if ($('#streamselect').val() > 0){
        Twexter.modules.Stream.poll();
        clearInterval(Twexter.modules.Stream.loop);
        Twexter.modules.Stream.loop = setInterval(Twexter.modules.Stream.poll, 1000);
      }
      else{
        clearInterval(Twexter.modules.Stream.loop);
        Twexter.modules.Stream.loop = null;
      }
    },
    run: function(){
      $('#newstream').click(
        function(){
        
        }
      );
      Twexter.modules.Stream.setloop();
      $('#streamselect').change(
        function(){
          $('#stream').empty();
          Twexter.modules.Stream.lastpost = 0;
          Twexter.modules.Stream.setloop();
        }
      );
      $('#streamselect').change();
    },
    stop: function(){
      clearInterval(Twexter.modules.Stream.loop);
      Twexter.modules.Stream.loop = null;
    },
    changeClass: function(c){
      clearInterval(Twexter.modules.Stream.loop);
      Twexter.modules.Stream.loop = null;
      Twexter.dashboard.ajax_load_module('stream', c);
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
                        .text(e.timestamp?' (' + $.timeago(new Date(e.timestamp * 1000)) + ')':'')
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