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
          if (error) $(this).find('#add_class').after('<div id="added-message" class="alert alert-error">error.message</div>');
          else{
            $(this).find('[name=new-class]').clearFields();
            $(this).remove('#deleted-message');
            $(this).remove('#added-message');
            $(this).find('#add_class').after('<div id="added-message" class="alert alert-success"><strong>'+r.name+' was added successfully!</strong> If you want  students to join, ask them to text "JOIN '+r.class_id+'" at your Twexter number.</div>');
	    $('#delete-form').find('#list_of_classes').after('<label class="checkbox" id="delete_class_'+r.class_id+'"><input type="checkbox" name="delete_'+r.class_id+'" value="'+r.class_id+'">'+r.name+'</label>');
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
          if (error) $(this).find('#delete_class').after('<div id="deleted-message" class="alert alert-error">'+error.message+'</div>'); 
          else{
            $(this).remove('#deleted-message');
            $(this).remove('#added-message');
            $(this).find('#delete_class').after('<div id="deleted-message" class="alert alert-success"><strong>Your classes were deleted successfully!</strong>');
	    $('#addform').find('#list_of_classes').remove('delete_class_'+r.class_id);
          }
        }, e)
      );
    }
  };
})(jQuery);