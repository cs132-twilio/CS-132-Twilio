(function($){
  Twexter.modules.Clist = Twexter.modules.List = {
    run: function(){},
    changeClass: function(c){
      Twexter.dashboard.ajax_load_module('clist', c);
    }
  };
})(jQuery);