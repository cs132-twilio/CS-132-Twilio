(function($){
  Twexter.modules.Classes = {
    submit_add: function(e){
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
          if (error) $(this).find('#add_class').removeClass('success').addClass('error').text(error.message);
          else{
            //$(this).find('[name=n],[name=m]').clearFields();
            $(this).find('#add_class').removeClass('error').addClass('success').text('Your class was added successfully!');
// 	    $(this).find('#add_class').after(
// 	    
// 		  +r.class_id+
// 		  
// 		);
          }
        }, e)
      );
    },
    submit_delete: function(e){
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
          if (error) $(this).find('#delete_class').removeClass('success').addClass('error').text(error.message);
          else{
            //$(this).find('[name=n],[name=m]').clearFields();
            $(this).find('#delete_class').removeClass('error').addClass('success').text('Deletion was successful!');
          }
        }, e)
      );
    }
  };
})(jQuery);