<!DOCTYPE html>
<html lang="en" dir="ltr">

   <head>
      <meta charset="utf-8">
      <title>Auction Reminder - Registration</title>
      <link rel="stylesheet" href="css/login_register.css">
      <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;1,300&display=swap" rel="stylesheet">
   </head>

   <body>

      <?php
         include_once 'html_elements/login_register_navbar.php';
      ?>

      <img id="background_logo"src="img/timer.png" alt="">


      <form id="registration_form" action="#" method="post">

         <div id="registration_status_container"></div>


         <!-- USERNAME INPUT -->
         <div class="label_and_error_message">
            <label>Username:</label>
            <div id="username_error_message" class="error_message"></div>
         </div>
         <input id="register_username" type="text" name="username" value="" onblur="validate_username(this.id)">


         <!-- E-MAIL INPUT -->
         <div class="label_and_error_message">
            <label>E-mial:</label>
            <div id="email_error_message" class="error_message"></div>
         </div>
         <input id="register_email" type="email" name="email" value="" onblur="validate_email(this.id)">


         <!-- PASSWORD1 INPUT -->
         <div class="label_and_error_message">
            <label>Password:</label>
            <div id="password1_error_message" class="error_message"></div>
         </div>
         <input id="register_password1" type="password" name="password1" value="" onblur="validate_password('register_password1','register_password2')">

         <!-- onblur="validate_password('register_password1','register_password2')" -->


         <!-- PASSWORD2 INPUT -->
         <div class="label_and_error_message">
            <label>Repeat Password:</label>
            <div id="password2_error_message" class="error_message"></div>
         </div>
         <input id="register_password2" type="password" name="password2" value="" onclick="pass2_input_state='clicked'" onblur="validate_password('register_password1','register_password2')">

         <!-- SUBMIT BUTTON -->
         <!-- <button id="submit_server_validation" type="submit" name="button">Register</button> -->
         <button id="submit_form_button" type="button" name="button" onclick="check_if_inputs_are_valid('register_username','register_email','register_password1','register_password2')">Register</button>


         <!-- <button id="redirect_to_login_page_button" type="button" name="button" onclick="location.href='login.html'">Log in</button> -->

         <!-- <button type="button" name="button" onclick="form_information(this.form)">Form info</button> -->

      </form>

      <script src="scripts/jquery-min.js" type="text/javascript"></script>
      <script src="scripts/register_validation.js" type="text/javascript"></script>



   </body>
</html>
