

var licences = {
   "1_month": 1,
   "6_months": 5,
   "12_months": 10
};

var currencies = {
   "usd": "$",
   "euro": "€",
   "zloty": "zł"
};

var payment_methods = {
   "PayPal": "link",
   "CreditCard": "link",
   "BankTransfer": "link"
};

var sessions = 1;
var licence_price = 0;
var choosen_licence = undefined;
var choosen_currency = "usd";

var choosen_payment_method = undefined;



function chose_licence_price(licence){
   licence_price = licences[licence];
   display_total_price()
   highlight_choosen_licence(licence);
}

function highlight_choosen_licence(licence){
   if(choosen_licence != licence ){
      $("#"+choosen_licence).removeClass("choosen_licence");
      $("#"+licence).addClass("choosen_licence");
   }

   choosen_licence = licence;
}

function set_sessions_amount(){
   sessions = document.getElementById("sessions_amount").value;
   display_total_price()
}

function display_total_price(){

   $('#total_cost_price').html(sessions*licence_price + currencies[choosen_currency]);
}


function chose_payments_method(pay_method){
   choosen_payment_method == pay_method;
   highlight_payments_method(pay_method);
}

function highlight_payments_method(pay_method){
   if(choosen_payment_method != pay_method ){
      $("#"+choosen_payment_method).removeClass("choosen_payment_method");
      $("#"+pay_method).addClass("choosen_payment_method");
   }

   choosen_payment_method = pay_method;
}

var get_licence_tries = 0
var trial_licence


function show_trial_licence(){
   var licence;

   if(get_licence_tries == 0){
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function(){

         if(this.readyState==4 && this.status==200){

            trial_licence = this.responseText;

            $('#trial_licence_container').html("Your trial licene:  " + trial_licence + "  will be valid for 4hours");
            get_licence_tries += 1;



         }
      }

      xhttp.open("POST", "php/generate_licence.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send();
   }
   else{

      //$("#login_status_container").addClass("error_animation");
      //setTimeout(function(){$("#login_status_container").removeClass("error_animation");}, 350);

      //$('#trial_licence_container').html("Your trial licene:  " + trial_licence + "  will be valid for 4hours");

      $("#trial_licence_container").addClass("error_animation");
      setTimeout(function(){$("#trial_licence_container").removeClass("error_animation");}, 350);
   }



}
