(function($){
  Twexter.modules.Poll = {
    currentview: null,
    viewloop: null,
    run: function(){

    },
    submit: function(form){
      
    switch($(form).find('button[type=submit]').val()){
      case 'create':
        $(form).attr('action', '/modules/poll/addPoll/' + Twexter.dashboard.getClass());
        return $(form).ajaxSubmit(
          function(r){
            //$('#message_create').text(r).slideDown(500);
            $('#contact-content-wrapper').find('[name=name], [name=polltype], [name=closingtime]').clearFields();
            $('.temp-message').remove();
            $('#message_create').after('<div class="alert alert-success temp-message">'+r+'</div>');
          }
        );
        break;
      case 'delete':
        $(form).attr('action', '/modules/poll/deletePoll/' + Twexter.dashboard.getClass());
        return $(form).ajaxSubmit(
          function(r){
//             $('#message_delete').text(r).slideDown(500);
            $('#delete-poll').find('[name=pollselect]').clearFields();
            $('.temp-message').remove();
            $('#message_delete').after('<div class="alert alert-error temp-message">'+r+'</div>');
          }
        );
        break;
      case 'view':
        //$('#message_view').text(r).slideDown(500);
        //drawChart(r.name, r.data);
        $(form).attr('action', '/modules/poll/analyzePoll/' + Twexter.dashboard.getClass());
        //return $(form).ajaxSubmit(
        //function(r){
        Twexter.modules.Poll.currentview = $('#pollselect').val();
        $('#chart_div').empty();
        $(
          $('<iframe src="about:blank" style="width: 800px; height: 550px; border: 0; overflow: hidden;" scrolling="no"></iframe>')
            .appendTo('#chart_div')[0].contentWindow.document.body
        ).append($(form).clone(false).hide())
          .find('#pollselect').val(Twexter.modules.Poll.currentview)
          .parentsUntil('form').parent().attr('onsubmit', '').submit();
        Twexter.modules.Poll.viewloop = setInterval(
          function(){
            $.post($('#select-poll-wrapper').find('form').attr('action'),
              {
                pollselect:$('#pollselect').val(),
                'csrf_token': $('#select-poll-wrapper').find('input[name=csrf_token]').val(),
                raw: 1
              },
              function(r){
            //Twexter.modules.Poll.chart.draw(data, options);
                if ($('#chart_div iframe')[0].contentWindow.google) Twexter.modules.Poll.chart.draw($('#chart_div iframe')[0].contentWindow.google.visualization.arrayToDataTable(r.data), r.options);
              }
            );
          }, 1000
        );
        //}
        //);
        break;
    }
  },
      
    
    changeClass: function(c){
      Twexter.dashboard.ajax_load_module('Poll');
    }
  };
  
})(jQuery);