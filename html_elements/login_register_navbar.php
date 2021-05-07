
<?php
   session_start();
   //echo session_id();

   require_once "php/check_user_inactivity.php";

?>



<div id="navbar">
   <a href="index.php">
      <div id="navbar_logo">
            <img id="logo" src="img/logo-80.png" alt="">
            Auction Reminder
      </div>
   </a>



<div id="navbar_buttons">

   <a href="register.php">
      <div class="nav_button">
         Register
      </div>
   </a>


   <?php

      if(empty($_SESSION['username'])){

         echo
         "<a href='login.php'>
            <div class='nav_button'>
               Log in
            </div>
         </a>";

      }
      else{


         echo
         "<a href='user_panel.php'>
            <div id='logged_user'>"
               . $_SESSION['username'] .
            "</div>
         </a>";
      }

   ?>

   </div>


</div>
