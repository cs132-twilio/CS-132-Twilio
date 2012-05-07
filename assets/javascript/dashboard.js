(function($){
  Twexter.dashboard = {
    ajax_load_module: function(module, c, args){
      var m = Twexter.dashboard.getModule();
      m = Twexter.modules[m.charAt(0).toUpperCase() + m.slice(1).toLowerCase()];
      var f = m ? m.stop : undefined;
      if(typeof f == 'function') f();
      Twexter.ajax_load('/modules/' + module.toLowerCase() + '/index/' + (c ? c : Twexter.dashboard.getClass()) + (args || ''), 'moduleContent',
        function(){
          $.bbq.pushState({m: module, m_args: args});
          m = Twexter.modules[module.charAt(0).toUpperCase() + module.slice(1).toLowerCase()];
          var f = m ? m.run : undefined;
          if(typeof f == 'function') f();
        }
      );
    },
    changeClass: function(c){
      $.bbq.pushState({'c': c});
      if (typeof Twexter.modules[$('#moduleTabs .active').text()].changeClass === 'function') return Twexter.modules[$('#moduleTabs .active').text()].changeClass(c);
      else return false;
    },
    getClass: function(){
      return $.bbq.getState('c');
    },
    getModule: function(){
      return $.bbq.getState('m');
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
      var c = $('#classTabs > li.class[data-cid=' + $.bbq.getState('c') + ']');
      c = c.length ? c : $('#classTabs > li.class:first');
      $(c).addClass('active');
      $.bbq.pushState({'c': $('#classTabs > li.active').data('cid')});
      $.bbq.pushState({m: $.bbq.getState('m') || 'clist'});
      Twexter.dashboard.ajax_load_module($.bbq.getState('m'), 0, $.bbq.getState('m_args'));
      $('#moduleTabs li:contains(' + $.bbq.getState('m').charAt(0).toUpperCase() + $.bbq.getState('m').slice(1).toLowerCase() + ')').click();
    }
  );
})(jQuery);