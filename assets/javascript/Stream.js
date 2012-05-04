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
	  if (!$('#newstream_name').val()){
	    $('#newstream_container').animate({width: 220});
	    $('#newstream_container').focus();
	  } else {
	      $('#newstream_form').ajaxSubmit(
		function(r){
		  if (r.success){
		    $('#streamselect').append(
		      ($(document.createElement('option'))
			.val(r.id)
			.text(r.name)
		      )
		    );
		    $('#streamselect').val(r.id);
		    $('#streamselect').change();
		    $('#newstream_name').val('');
		    $('#newstream_container').animate({width: 0});
		  }
		}
	      );
	  }
        }
      );
      $('#deletestream').click(
        function(){
	  if (!confirm('Are you sure you wish to delete this stream?')) return false;
	  $('#deletestream_form').ajaxSubmit(
	    function(r){
	      if (r.success){
		$('#streamselect > option:selected').remove();
		$('#streamselect').change();
	      }
	    }
	  );
        }
      );
      Twexter.modules.Stream.setloop();
      $('#streamselect').change(
        function(){
          $('#stream').empty();
          Twexter.modules.Stream.lastpost = 0;
          Twexter.modules.Stream.setloop();
	  $('#streamid').text($('#streamselect').val());
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