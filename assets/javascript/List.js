(function($){
  Twexter.modules.Clist = Twexter.modules.List = {
    run: function(){
      $('.list_removestudent').click(
	function(){
	  if(confirm('Are you sure you wish to remove ' + $(this).parent().parent().find('td:first').text() + ' from ' + $('li.class.active').text() + '?')){
	    $.get('/modules/clist/delete/' + $('li.class.active').data('cid') + '/' + $(this).parent().parent().data('sid'),
	      $.proxy(
		function(r){
		  if(r.success) $(this).parent().parent().slideUp(null, function(){ $(this).remove(); });
		},
		this
	      )
	    );
	  }
	}
      );
    },
    changeClass: function(c){
      Twexter.dashboard.ajax_load_module('clist', c);
    }
  };
})(jQuery);