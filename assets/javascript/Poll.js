(function($){
  Twexter.modules.Poll = {
    run: function(){
      /*$.getScript('https://www.google.com/jsapi',
	function(){debugger;
	  //google.load("visualization", "1", {packages:["corechart"]});
	}
      );*/
    },
    /*drawChart: function(name, d) {
      var data = google.visualization.arrayToDataTable(data);

      var options = {
	title: 'Responses for poll: ' + name
      };

      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(d, options);
    },*/
    submit: function(form){
      
	  switch($(form).find('button[type=submit]').val()){
	    case 'create':
	      $(form).attr('action', '/modules/poll/addPoll/' + Twexter.dashboard.getClass());
	      return $(form).ajaxSubmit(
		function(r){
		  $('#message_create').text(r).slideDown(500);
		}
	      );
	      break;
	    case 'delete':
	      $(form).attr('action', '/modules/poll/deletePoll/' + Twexter.dashboard.getClass());
	      return $(form).ajaxSubmit(
		function(r){
		  $('#message_delete').text(r).slideDown(500);
		}
	      );
	      break;
	    case 'view':
// 	       $('#message_view').text(r).slideDown(500);
	      //drawChart(r.name, r.data);
	      $(form).attr('action', '/modules/poll/analyzePoll/' + Twexter.dashboard.getClass());
	      return $(form).ajaxSubmit(
		function(r){
		 
		  $('#chart_div').empty();
		  $(
		    $('<iframe src="about:blank" style="width: 800px; height: 550px; border: 0; overflow: hidden;" scrolling="no"></iframe>')
		      .appendTo('#chart_div')[0].contentWindow.document.body
		  ).append($(form).clone(false).hide())
		    .find('#pollselect').val($('#pollselect').val())
		    .parentsUntil('form').parent().attr('onsubmit', '').submit();
		}
	      );
	      break;
	  }
	},
      
    
    changeClass: function(c){
      Twexter.dashboard.ajax_load_module('Poll');
    }
  };
  
})(jQuery);