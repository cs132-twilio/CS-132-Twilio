(function($){
$(window).load(
	function(){
    
	}
);})(jQuery);

var Twexter = {
  //Place core app stuff here
}

ajax_load = function(url, container){
  $.get(url,
    function(r){
      $('#' + container).html(r);
    }
  );
}