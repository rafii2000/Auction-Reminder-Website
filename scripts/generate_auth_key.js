var generate_auth_key_tries = 0;

function error_auth_key_prompt(){
   if(generate_auth_key_tries > 0){
      $("#auth_key_status").addClass("error_animation");
      setTimeout(function(){$("#auth_key_status").removeClass("error_animation");}, 350);
   }
   generate_auth_key_tries += 1;
}

function ajax_generate_auth_key(){
   xhttp = new XMLHttpRequest();

   xhttp.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){

         var server_respond = this.responseText;
         console.log(server_respond);

         if(server_respond == "error"){
            //Sorry something went wrong, try again later

            $('#auth_key_status').html('Something went wrong, try again later');
            $('#auth_key_field').html('');

            error_auth_key_prompt();
         }
         else if(server_respond == "no_licence"){
            $('#auth_key_status').html("You don't have valid licence");
            $('#auth_key_field').html('');
         }
         else{
            $('#auth_key_field').html(server_respond);

         }

      }
   }

   xhttp.open("GET", "php/generate_auth_key.php", true);
   xhttp.send();
}
