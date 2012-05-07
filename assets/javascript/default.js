(function($){
  Twexter = {
    modules: {},
    ajax_load: function(url, container, callback){
      $('#' + container).load(url, callback);
    }
  };
  $(window).load(
    function(){
      setInterval(
        function(){
          $.get('/inbox/count',
            function(r){
              if (r !== '0' && r !== ''){
                $('#inbox_unread').css('display', 'inline').text(r);
                if (Twexter.inbox) Twexter.inbox.load(0);
              }
              else if (r === '0') $('#inbox_unread').css('display', 'none');
            }
          );
        }, 1000
      );
    }
  );
})(jQuery);