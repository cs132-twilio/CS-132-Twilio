(function($){
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
    }
  );
})(jQuery);