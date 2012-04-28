(function($){
  Twexter.modules.Message = {
    submit: function(e){
      return !$(e).ajaxSubmit(
        $.proxy(function(r){
          var error = r.success === 0 ? r[0] : undefined;
          if (!error){
            $(r).each(
              function(i, e){
                if (!e.success){
                  error = e;
                  return false;
                }
              }
            );
          }
          if (error) $(this).find('#message_sent').removeClass('success').addClass('error').text(error.message);
          else{
            $(this).find('[name=n],[name=m]').clearFields();
            $(this).find('#message_sent').removeClass('error').addClass('success').text('Your message was sent successfully!');
          }
        }, e)
      );
    }
  };
})(jQuery);