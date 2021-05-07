<!DOCTYPE html>
<html lang="en" dir="ltr">

   <head>
      <meta charset="utf-8">
      <title>Auction Reminder - Log in </title>
      <link rel="stylesheet" href="css/login_register.css">
      <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;1,300&display=swap" rel="stylesheet">
   </head>


   <body>



      <?php
         include_once 'html_elements/login_register_navbar.php';
      ?>


      <img id="background_logo"src="img/timer.png" alt="">


      <!-- php/login_form.php -->
      <form id="login_form" action="#" method="post">

         <div id="login_status_container"></div>

         <label>Username:</label>
         <input id="login_username" type="text" name="username" value="">

         <label>Password:</label>
         <input id="login_poassword" type="password" name="password" value="">

         <!-- <button type="submit" name="button">Login</button> -->
         <button type="button" name="button" onclick="ajax_login_validation_request(this.form)">Login</button>

      </form>




      <script src="scripts/jquery-min.js" type="text/javascript"></script>
      <script src="scripts/login_validation.js" type="text/javascript"></script>


   </body>
</html>
