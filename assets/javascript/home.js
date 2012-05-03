<<<<<<< HEAD

!function ($) {
  $(function(){
    $('#myCarousel').carousel()
  })
}(window.jQuery)


=======
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
>>>>>>> 1fe90e1f5af548285be33671841705c17b621945
