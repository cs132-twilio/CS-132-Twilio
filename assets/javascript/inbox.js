(function($){
  Twexter.inbox = {
    run: function(){
      $('.inbox_message').click(
        function(){
          $(this).addClass('inbox_read');
          var m = $(this).data('id');
          var n = $(this).find('.inbox_from').text();
          var d = $('#messageTabs > li[data-name="' + n + '"]').length;
          $('#messageTabs > li.active').not('#inbox_refresh').removeClass('active');
          Twexter.inbox.load(m);
          if (!($('#messageTabs > li[data-id=' + m + ']').addClass('active').length)){
            $('#messageTabs').append(
              ($(document.createElement('li'))
                .addClass('active')
                .attr('data-id', m)
                .attr('data-name', n)
                .append(
                  ($(document.createElement('a'))
                    .click(
                      function(){
                        return Twexter.inbox.load(m);
                      }
                    )
                    .append(
                      $(document.createElement('span')).text(n + (d?' ('+(d+1)+') ':' ')),
                      ($(document.createElement('span'))
                        .addClass('close')
                        .addClass('inbox_tab_close')
                        .html('&times;')
                        .click(
                          function(){
                            $(this).parent().parent().remove();
                            Twexter.inbox.load(0);
                          }
                        )
                      )
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
      $('#inbox_refresh').css('display', m?'none':'inline');
      if (m) $('#inboxContent').load('/inbox/messages/' + m);
      else{
        $('#inboxContent').load('/inbox/messages', Twexter.inbox.run);
      }
      $('#messageTabs > li.active').not('#inbox_refresh').removeClass('active');
      $('#messageTabs > li[data-id=' + m + ']').addClass('active');
    },
    submit: function(e){
      return !$(e).ajaxSubmit(
        function(r){
          if (r.success) $(e).find('textarea').val('');
        }
      );
    }
  }

  $(window).load(
    function(){
      $('#inboxContent').load('/inbox/messages', Twexter.inbox.run);
      $('#inbox_refresh').click(
        function(){
          Twexter.inbox.load(0);
        }
      );
    }
  );
})(jQuery);

