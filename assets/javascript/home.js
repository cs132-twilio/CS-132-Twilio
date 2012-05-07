(function($){
  $(window).load(
    function(){
      var callback = function(){
        $('#registration > form button[name=next]').click(
          function(){
            $('#registration-page-1').animate({'margin-left':'-100%'}, function(){$('#recaptcha_response_field').focus();});
          }
        );
        $('#registration > form button[name=back]').click(
          function(){
            $('#registration-page-1').animate({'margin-left':'0%'});
          }
        );
        $('#registration > form').submit(
          function(){
            if ($('#registration-page-1').css('margin-left') != '-100%') $('#registration > form button[name=next]').click();
            else {
              $(this).ajaxSubmit(
                function (r){
                  $('#registration').html(r=='You have successfully registered. Check your email address to activate your account.'?'<p /><p>You have successfully registered.<br/>Check your email address to<br />activateyour account.</p>':r);
                  callback();
                }
              );
            }
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

