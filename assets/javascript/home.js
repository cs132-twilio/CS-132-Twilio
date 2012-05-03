(function($){
  $(window).load(
    function(){
      var callback = function(){
        $('#registration > form').submit(
          function(){
            !$(this).ajaxSubmit(
              function (r){
                $('#registration').html(r);
                callback();
              }
            );
            return false;
          }
        );
      }
      Twexter.ajax_load('/auth/register', 'registration', callback);
      // carousel demo
      $('#myCarousel').carousel();
    }
  );
})(jQuery);
