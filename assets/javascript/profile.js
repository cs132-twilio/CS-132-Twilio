$(document).ready(function(){

  
  $("#change_email_form").submit( 
  
    function(){
        var email=$(this).find("#email").val();
        var password=$(this).find("#password").val();
	var csrf=$(this).find('input[name="csrf_token"]').val();
     $.ajax({
        type: "POST",
        url: "/auth/change_email",
        dataType: "json",
        data: "email="+email+"&password="+password+"&csrf_token="+csrf,
        cache:false,
        success: 
          function(data){
	    if (typeof data.password !== "undefined"){
		$("#change_email_form").after('<div class="span4"><div class="alert alert-error"><button class="close" data-dismiss="alert">x</button><strong>Password error: </strong>'+data.password+'</div></div></br>');
	    }
	    else if (typeof data.email !== "undefined"){
		$("#change_email_form").after('<div class="span4"><div class="alert alert-error"><button class="close" data-dismiss="alert">x</button><strong>Email error: </strong>'+data.email+'</div></div></br>');
	    }
	    else{
	    $("#change_email_form").after('</br><div class="span4"><div class="alert alert-success"><button class="close" data-dismiss="alert">x</button><strong>Success!  </strong>'+data.message+'</div></div>');
	    }
	  },
        failure:
	  function(data){
          }
      });
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

