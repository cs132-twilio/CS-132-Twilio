(function($){
  Twexter = {
    modules: {},
    ajax_load: function(url, container, callback){
      $('#' + container).load(url, callback);
    }
  };
})(jQuery);