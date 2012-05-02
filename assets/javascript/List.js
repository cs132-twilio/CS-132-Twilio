(function($){
  Twexter.modules.List = {
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
      $('#streamselect').change(
        function(){
          $('#stream').empty();
          Twexter.Stream.lastpost = 0;
          Twexter.Stream.setloop();
        }
      );
    },
    classchange: function(c){
      ajax_load('/list/' + c, 'moduleContent');
    }
  };
})(jQuery);