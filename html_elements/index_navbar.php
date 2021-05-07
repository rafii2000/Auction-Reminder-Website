<?php

   // echo $_SERVER['REQUEST_URI'] . "<br>";
   // echo $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] . "<br>";
   // echo $actual_link = $_SERVER['SCRIPT_FILENAME'] . "<br>";
   // echo __FILE__ . "<br>";
   // echo basename("http://domain/fotografo/admin/gallery_bg.php");
   // echo basename($_SERVER['SCRIPT_FILENAME']). "<br>";

   //on pageload
   session_start();

   require_once "php/check_user_inactivity.php";

?>

<div id="navbar">

   <?php

   if( basename($_SERVER['SCRIPT_FILENAME']) == "index.php" ){

      echo
      "<a href='shop.php'>
         <div class='nav_button'>
            Shop
         </div>
      </a>";
   }
   else {

      echo
      "<a href='index.php'>
         <div class='nav_button'>
            Home
         </div>
      </a>";
   }

   ?>


   <a href="">
      <div class="nav_button">
         Download
      </div>
   </a>

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
