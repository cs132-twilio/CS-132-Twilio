$(document).ready(function(){

  
  $("#change_email").click( 
  
    function(){
    
        var email=$("#email").val();
        var password=$("#password").val();
      	document.write(email);
	document.write(password); 
     /*   $.ajax({
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
*/
      return false;

    });
   $("#change_password").click(
  
    function(){

        var old_password=$("#old_password").val();
        var old_password=$("#old_password").val();
        var old_password=$("#old_password").val();
  /*      $.ajax({
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
*/
      return false;

    });


});

