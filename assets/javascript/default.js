(function($){
$(window).load(
	function(){
    
	}
);})(jQuery);

var Twexter = {
  //Place core app stuff here
}

ajax_load = function(url, container, callback){
  $.get(url,
    function(r){
      $('#' + container).html(r);
      if (typeof callback == 'function') callback();
    }
  );
};

ajax_load_module = function(module){
  ajax_load('/welcome/modules/' + module.toLowerCase() + '.php', 'moduleContent',
    function(){
      var f = Twexter[module.charAt(0).toUpperCase() + module.slice(1).toLowerCase()].run;
      if(typeof f == 'function') f();
    }
  );
};