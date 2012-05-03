$(document).ready(function(){

  
  $("#login_submit").click( 
  
    function(){
    
        var username=$("#username").val();
        var password=$("#password").val();
      
        $.ajax({
        type: "POST",
        url: "http://demos.ryantetek.com/codeigniter_samples/index.php/ajax_post/post_action",
        dataType: "json",
        data: "username="+username+"&password="+password,
        cache:false,
        success: 
          function(data){
            $("#form_message").html(data.message).css({'background-color' : data.bg_color}).fadeIn('slow'); 
          }
        
        });

      return false;

    });
  

});

