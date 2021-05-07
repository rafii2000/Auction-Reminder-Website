console.log("Register Validation JS file");



var form_id; //must have ??
// zbiór id elementów w HTML ???


var validation_status = {
   "username": "invalid",
   "email": "invalid",
   "password1": "invalid",
   "password2": "invalid"
};


var form_data = {
   "username": undefined,
   "email": undefined,
   "password1": undefined,
   "password2": undefined
};

var errors_types = {
   "username":{
      "short": "Username has to have at least 4 signs",
      "long": "Username can't have more then 50 signs",
      "exist": "This username already exist",
      "empty": "Username is required",
      "specialSigns": "Special signs are not allowed (' ' and ',')"
   },

   "email":{
      "structure": "Please enter complete adress E-mial",
      "exist": "This E-mail already exist",
      "empty": "Adress E-mial is required"
   },

   "password1":{
      "empty": "Password is required",
      "short": "Password has to have at least 4 signs",
      "numbers": "Password has to contain numbers",
      "lowerCase": "Password has to contain lower case letters",
      "upperCase": "Password has to contain upper case letters",
      "specialSigns": "Special signs are not allowed"
   },

   "password2":{
      "diffrent": "Passwords are diffrent",
      "empty": "Password is required"
   }
};




function input_field_error(input_id){
   $("#"+input_id).removeClass("correct");
   $("#"+input_id).addClass("error");
}

function input_field_correct(input_id){
   $("#"+input_id).removeClass("error");
   $("#"+input_id).addClass("correct");
}

function input_field_none(input_id){
   $("#"+input_id).removeClass("error");
   $("#"+input_id).removeClass("correct");
}

//Check are E-mail and Username exist ???
function ajax_validation_request(input_id, input_name, input_value){

   var xhttp = new XMLHttpRequest();
   var server_respond;  //error_type
   var input_error_message_id = "#" + input_name + "_error_message";

   xhttp.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
         // zwraca wartosci z serwera
         server_respond = this.responseText;

         console.log("server_respond:");
         console.log(server_respond);

         if(server_respond == "not_exist"){
            input_field_correct(input_id);
            $(input_error_message_id).html("");

            validation_status[input_name] = "valid";
            form_data[input_name] = input_value;
         }
         else{
            input_field_error(input_id);
            $(input_error_message_id).html(errors_types[input_name][server_respond]);

            validation_status[input_name] = "invalid";
            form_data[input_name] = undefined;
         }

      }
   }

   // puzzle=4x4&user_name=999&time=00:00:13&attemps=1
   var data_to_request = input_name + "=" + input_value;
   xhttp.open("GET", "php/ajax_register_form_validation.php?"+"input_name"+"="+input_name+"&"+input_name+"="+input_value,true);
   xhttp.send();

}


function ajax_register_request(){

   console.log("Register Request:");


   //naciagana metoda tworzenia formatu danych dla zapytania do serwera
   // wzor: "fname=Henry&lname=Ford"
   var post_request_data = JSON.stringify(form_data);

   post_request_data = post_request_data.replace(/"/g,"");
   post_request_data = post_request_data.replace(/:/g,"=");
   post_request_data = post_request_data.replace(/,/g,"&");
   post_request_data = post_request_data.replace(/{|}/g,"");


   var xhttp = new XMLHttpRequest();

   xhttp.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){

         var server_respond = this.responseText;
         console.log(server_respond);

         if(server_respond == "successful"){

            $("#registration_status_container").css("color", "#6AFF16");
            $("#registration_status_container").html("Registriation has been succesfull");

            $("#submit_form_button").css("display", "none");
            // $("#redirect_to_login_page_button").css("display", "block");

         }
         else{

            $("#registration_status_container").css("color", "red");
            $("#registration_status_container").html("Registriation unsuccesfull");

            $("#submit_form_button").css("display", "none");
         }
      }
   }


   xhttp.open("POST", "php/register_form.php", true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send(post_request_data);

}






function validate_username(input_id){

   var username = $('#'+input_id).val(); //username or input_value
   var input_name = $('#'+input_id).attr("name");
   var input_error_message_id = "#" + input_name + "_error_message"; // to powinna byc funkcja

   console.log(username);

   if(username.length == 0){
      $(input_error_message_id).html(errors_types[input_name]["empty"]);
      input_field_error(input_id);
   }
   else if(username.length < 4){
      $(input_error_message_id).html(errors_types[input_name]["short"]);
      input_field_error(input_id);
   }
   else if(username.length > 50){
      $(input_error_message_id).html(errors_types[input_name]["long"]);
      input_field_error(input_id);
   }
   else if(username.includes(" ") == true || username.includes(",") == true ||
            username.includes("'") == true || username.includes('"') == true ||
            username.includes('-') == true){
               $(input_error_message_id).html(errors_types[input_name]["specialSigns"]);
               input_field_error(input_id);
   }
   else if (username.length >= 4 && username.length <=50) {
      //Check Database Registries
      ajax_validation_request(input_id, input_name, username);
   }

}


function validate_email(input_id){

   var email = $('#'+input_id).val(); //email or input_value
   var input_name = $('#'+input_id).attr("name");
   var input_error_message_id = "#" + input_name + "_error_message"; // to powinna byc funkcja ?

   // email pattern:
   // nick + @ + . service_provider + domain
   // istnieje lepszy sposob sprawdzenia e-maila
   var point = email.indexOf(".");
   var at = email.indexOf("@");
   var nick = email.substring(0, at);
   var service_provider = email.substring(at+1, point);
   var domain = email.substring(point+1);


   var i = 0;
   if(email.length == 0){

      $(input_error_message_id).html(errors_types[input_name]["empty"]);
      input_field_error(input_id);
   }
   else if(email.includes("@") == false){

      $(input_error_message_id).html(errors_types[input_name]["structure"]);
      input_field_error(input_id);
   }
   else if(email.includes(".") == false){

      $(input_error_message_id).html(errors_types[input_name]["structure"]);
      input_field_error(input_id);
   }
   else if(point < at){

      $(input_error_message_id).html(errors_types[input_name]["structure"]);
      input_field_error(input_id);
   }
   else if(nick.length == 0 || service_provider.length == 0 || domain.length == 0){

      $(input_error_message_id).html(errors_types[input_name]["structure"]);
      input_field_error(input_id);
   }
   else{
      ajax_validation_request(input_id, input_name, email);

   }

}


var pass2_input_state = "not clicked"; // hujowe

function validate_password(input_id_1, input_id_2){

   var password1 = $("#"+input_id_1).val();
   var password2 = $("#"+input_id_2).val();

   var input_name_1 = $("#"+input_id_1).attr('name');
   var input_name_2 = $("#"+input_id_2).attr('name');

   var input_1_error_message_id = "#" + input_name_1 + "_error_message"; //
   var input_2_error_message_id = "#" + input_name_2 + "_error_message"; // to powinna byc funkcja ?


   validation_status[input_name_1] = "invalid";
   validation_status[input_name_2] = "invalid";
   console.log("pass2_input:");
   console.log(pass2_input_state);

   //VALIDATE PSSWORD1
   if(password1.length == 0){
      $(input_1_error_message_id).html(errors_types[input_name_1]["empty"]);
      input_field_error(input_id_1);
   }
   else if(password1.includes(" ") == true || password1.includes(",") == true ||
            password1.includes("'") == true || password1.includes('"') == true ||
            password1.includes('-') == true){
               $(input_1_error_message_id).html(errors_types[input_name_1]["specialSigns"]);
               input_field_error(input_id_1);
   }
   else if(password1.length < 4){

      $(input_1_error_message_id).html(errors_types[input_name_1]["short"]);
      input_field_error(input_id_1);
   }
   else if(/[0-9]/.test(password1) == false){

      $(input_1_error_message_id).html(errors_types[input_name_1]["numbers"]);
      input_field_error(input_id_1);
   }
   else if(/[a-z]/.test(password1) == false ){

      $(input_1_error_message_id).html(errors_types[input_name_1]["lowerCase"]);
      input_field_error(input_id_1);
   }
   else if(/[A-Z]/.test(password1) == false){

      $(input_1_error_message_id).html(errors_types[input_name_1]["upperCase"]);
      input_field_error(input_id_1);
   }
   else{

      $(input_1_error_message_id).html("");
      input_field_correct(input_id_1);

      validation_status[input_name_1] = "valid";
      form_data[input_name_1] = password1;
   }

   //VALIDATE PSSWORD2 are the same ?
   if (password1.length == 0 && password2.length == 0) {

      $(input_2_error_message_id).html("");
      input_field_none(input_id_2);
      pass2_input_state = "not clicked";
   }
   else if(password1 != password2 && pass2_input_state=="not clicked"){

      $(input_2_error_message_id).html("");
      input_field_none(input_id_2);
      // pass2_input_state = "clicked";
   }
   else if(password1 != password2 && pass2_input_state=="clicked"){

      $(input_2_error_message_id).html(errors_types[input_name_2]["diffrent"]);
      input_field_error(input_id_2);
      // pass2_input_state = "clicked";
   }
   else if(password1 != password2){

      $(input_2_error_message_id).html(errors_types[input_name_2]["diffrent"]);
      input_field_error(input_id_2);
   }
   else{

      $(input_2_error_message_id).html("");
      input_field_correct(input_id_2);

      validation_status[input_name_2] = "valid";
      form_data[input_name_2] = password2;

      console.log(form_data);
   }

}





function check_if_inputs_are_valid(username_input_id, email_input_id, password1_input_id, password2_input_id){

   console.log("change_button");
   console.log(validation_status);

   if(validation_status["username"] == "valid" &&
      validation_status["email"] == "valid" &&
      validation_status["password1"] == "valid" &&
      validation_status["password2"] == "valid"){

         console.log("Dane sa poprawne");
         ajax_register_request();
   }
   else{
      console.log("Dane sa niepoprawne");
      $("#registration_status_container").html("");

      //Pokazuje co jest niepoprawne
      validate_username(username_input_id);
      validate_email(email_input_id);
      validate_password(password1_input_id, password2_input_id);

   }

}
