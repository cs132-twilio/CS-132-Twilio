(function($){
  Twexter.dashboard = {
    ajax_load_module: function(module){
      Twexter.ajax_load('/welcome/modules/' + module.toLowerCase() + '.php', 'moduleContent',
        function(){
          var f = Twexter.modules[module.charAt(0).toUpperCase() + module.slice(1).toLowerCase()].run;
          if(typeof f == 'function') f();
        }
      );
    },

    setClass: function(c){
      
    },
    setModule: function(m){

    }
  }
  
  var activeTabs = function(c){
    $('#' + c + ' > li').click(
      function(){
        $('#' + c + ' > li.active').removeClass('active');
        $(this).addClass('active');
      }
    );
  }

  $(window).load(
    function(){
      activeTabs('moduleTabs');
      activeTabs('classTabs');
      Twexter.dashboard.setClass(1);
      Twexter.dashboard.setModule('List');
    }
  );
})(jQuery);