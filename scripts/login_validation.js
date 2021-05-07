

var login_tries = 0;

function ajax_login_validation_request(form_id){

   console.log("Login Validation:");

   var username = form_id.username.value;
   var password = form_id.password.value;
   var post_request_data = "username="+username+"&"+"password="+password;


   xhttp = new XMLHttpRequest();

   xhttp.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){

         var server_respond = this.responseText;
         // console.log(server_respond);
         if(server_respond == "no matches"){

            $("#login_status_container").html("Invalid Username or Password");

            if(login_tries > 0){
               $("#login_status_container").addClass("error_animation");
               setTimeout(function(){$("#login_status_container").removeClass("error_animation");}, 350);
            }
            login_tries += 1;
         }
         else if(server_respond == "account in usage"){

            $("#login_status_container").html("Account in usage");

            if(login_tries > 0){
               $("#login_status_container").addClass("error_animation");
               setTimeout(function(){$("#login_status_container").removeClass("error_animation");}, 350);
            }
            login_tries += 1;
         }
         else{

            console.log(server_respond);
            login_tries = 0;
            window.location.href = "user_panel.php";
            // window.location.replace("user_panel.php");
         }
      }
   }

   xhttp.open("POST", "php/login_form.php", true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send(post_request_data);

}
