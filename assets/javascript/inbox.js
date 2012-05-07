(function($){
  Twexter.inbox = {
    run: function(){
      $('.inbox_message').click(
        function(){
          var m = $(this).data('id');
          var n = $(this).find('.inbox_from').text();
          var d = $('#messageTabs > li[data-name="' + n + '"]').length;
          $('#messageTabs > li.active').removeClass('active');
          Twexter.inbox.load(m);
          if (!($('#messageTabs > li[data-id=' + m + ']').addClass('active').length)){
            $('#messageTabs').append(
              ($(document.createElement('li'))
                .addClass('active')
                .attr('data-id', m)
                .attr('data-name', n)
                .append(
                  ($(document.createElement('a'))
                    .text(n + (d?' ('+(d+1)+')':''))
                    .click(
                      function(){
                        return Twexter.inbox.load(m);
                      }
                    )
                  )
                )
              )
            );
          }
        }
      );
      $('.timeago').timeago();
    },
    load: function(m){
      if (m) $('#inboxContent').load('/inbox/messages/' + m);
      else{
        $('#inboxContent').load('/inbox/messages', Twexter.inbox.run);
      }
      $('#messageTabs > li.active').removeClass('active');
      $('#messageTabs > li[data-id=' + m + ']').addClass('active');
    }
  }

  $(window).load(
    function(){
      $('#inboxContent').load('/inbox/messages', Twexter.inbox.run);
    }
  );
})(jQuery);

