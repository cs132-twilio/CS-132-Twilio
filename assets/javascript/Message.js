(function($){
  Twexter.modules.Message = {
    run: function(){
      $.get('/modules/message/targets',
        function(r){
          $.ajax({
            type: 'GET',
            url: '/assets/javascript/jquery.tokeninput.js',
            success: function(){
              $('#messageform input[name=n]').tokenInput(r,
                {
                  theme: 'facebook',
                  hintText: 'Enter a student or class name',
                  preventDuplicates: true
                }
              );
            },
            dataType: 'script',
            cache: true
          });
        }
      );
    },
    submit: function(e){
      return !$(e).ajaxSubmit(
        $.proxy(function(r){
            $(r).each(
              $.proxy(function(i, e){
                $(this).find('#message_log').empty();
                ($(document.createElement('div'))
                  .addClass('alert')
                  .addClass(e.success ? 'alert-success' : 'alert-error')
                  .css('display', 'none')
                  .append($(document.createElement('span')).text(e.message))
                  .append(
                    ($(document.createElement('span'))
                      .addClass('close')
                      .html('&times;')
                      .click(
                        function(){
                          $(this).parent().slideUp(function(){$(this).remove();});
                        }
                      )
                    )
                  )
                ).appendTo($(this).find('#message_log')).slideDown(500);
                if (!e.success){
                  error = e;
                  return false;
                }
              }, this)
            );
          if (!error){
            $(this).find('[name=n],[name=m]').clearFields();
            $('#messageform input[name=n]').tokenInput('clear');
          }
        }, e)
      );
    }
  };
})(jQuery);