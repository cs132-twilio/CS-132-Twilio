(function($){
  Twexter.Classes = {
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
          if (error) $(this).find('#add_class').after('<div class="alert alert-error temp-message">error.message</div>');
          else{
            $(this).find('[name=new-class]').clearFields();
            $('.temp-message').remove();
            $('#add_class').after('<div class="alert alert-success temp-message"><strong>'+r.name+' was added successfully!</strong> If you want  students to join, ask them to text "JOIN '+r.class_id+'" at your Twexter number.</div>');
	    $('#list_of_classes').append('<label class="checkbox" id="delete_class_'+r.class_id+'"><input type="checkbox" name="delete_'+r.class_id+'" value="'+r.class_id+'">'+r.name+'</label>');
          }
        }, e)
      );
    },
    submit_delete: function(e){
      if(!confirm("Are you sure you want to delete the selected classes?")) return false;
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
          if (error) $(this).find('#delete_class').after('<div class="alert alert-error temp-message">'+error.message+'</div>'); 
          else{
            $('.temp-message').remove();
	    for(x in r.classes){
	      var to_be_deleted = '#delete_class_'+x;
	      $(to_be_deleted).remove();
	    }
	    $('#delete_class').after('<div class="alert alert-success temp-message"><strong>Your classes were deleted successfully!</strong>');
	    
          }
        }, e)
      );
    }
  };
})(jQuery);