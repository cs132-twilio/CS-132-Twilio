(function($){
  Twexter.dashboard = {
    ajax_load_module: function(module, c){
      Twexter.ajax_load('/modules/' + module.toLowerCase() + '/index/' + (c ? c : $('#classTabs > li.active').data('cid')), 'moduleContent',
        function(){
          var f = Twexter.modules[module.charAt(0).toUpperCase() + module.slice(1).toLowerCase()].run;
          if(typeof f == 'function') f();
        }
      );
    },
    changeClass: function(c){
      if (typeof Twexter.modules[$('#moduleTabs .active').text()].changeClass === 'function') return Twexter.modules[$('#moduleTabs .active').text()].changeClass(c);
      else return false;
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
      $('#classTabs > li.class:first').addClass('active');
      Twexter.dashboard.ajax_load_module('clist');
    }
  );
})(jQuery);