(function($){
  Twexter = {
    modules: {},
    ajax_load: function(url, container, callback){
      $.get(url,
        function(r){
          $('#' + container).html(r);
          if (typeof callback == 'function') callback();
        }
      );
    }
  };

  $(window).load(
    function(){
    
    }
  );
})(jQuery);