(function($){
  $(window).load(
    function(){
      var callback_email = function(){
        $('#change-email > form').submit(
          function(){
            !$(this).ajaxSubmit(
              function (r){
                $('#change-email').html(r);
                callback();
              }
            );
            return false;
          }
        );
      }
      var callback_password = function(){
        $('#change-password > form').submit(
          function(){
            !$(this).ajaxSubmit(
              function (r){
                $('#change-password').html(r);
                callback();
              }
            );
            return false;
          }
        );
      }
      Twexter.ajax_load('/auth/change_email', 'change-email', callback_email);
      Twexter.ajax_load('/auth/change_password', 'change-password', callback_password);
    }
  );
})(jQuery);