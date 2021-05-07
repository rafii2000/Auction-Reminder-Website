var activate_licence_tries = 0;
var previous_server_respond = "";

function error_licence_prompt(server_respond){

   if(previous_server_respond != server_respond){
      activate_licence_tries = 0;
   }

   if(activate_licence_tries > 0){
      $("#licence_code_status").addClass("error_animation");
      $("#licence_code_status").html(server_respond);
      setTimeout(function(){$("#licence_code_status").removeClass("error_animation");}, 350);
   }
   activate_licence_tries += 1;
   previous_server_respond = server_respond;
}


function ajax_active_licence(licence){

   var xhttp = new XMLHttpRequest();
   var server_respond;//
   // console.log(licence);


   xhttp.onreadystatechange = function(){

      if(this.readyState == 4 && this.status == 200){

         server_respond = this.responseText;

         console.log(server_respond);
         if(server_respond == "not exist"){

            $("#licence_code_status").html("Invalid licence");
            $("#activate_licence_input").removeClass("correct");
            $("#activate_licence_input").addClass("error");

            error_licence_prompt(server_respond);

         }
         else if(server_respond == "activated"){

            $("#licence_code_status").html("You've got active licence");
            $("#activate_licence_input").removeClass("correct");
            $("#activate_licence_input").addClass("error");

            error_licence_prompt(server_respond);

         }
         else if(server_respond == "in_usage"){

            $("#licence_code_status").html("This licence is used");
            $("#activate_licence_input").removeClass("correct");
            $("#activate_licence_input").addClass("error");

            error_licence_prompt(server_respond);

         }
         else if(server_respond == "valid"){

            $("#licence_code_status").html("");
            $("#activate_licence_input").removeClass("error");
            $("#activate_licence_input").addClass("correct");

            activate_licence_tries = 0;
            // http://localhost/Auction%20Reminder/user_panel.php

         }

      }
   }

   xhttp.open("POST", "php/activate_licence.php", true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send("licence=" + licence);
}
