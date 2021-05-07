<!DOCTYPE html>
<html lang="en" dir="ltr">

   <head>
      <meta charset="utf-8">
      <title>Auction Reminder - Home</title>
      <link rel="stylesheet" href="css/home.css">
      <link rel="stylesheet" href="css/home_shop_navbar.css">
      <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;1,300&display=swap" rel="stylesheet">
   </head>

   <body>

      <div id="wrapper">

         <?php
            include_once 'html_elements/index_left_container.php';
         ?>

         <div id="right_container">

            <?php include_once 'html_elements/index_navbar.php'; ?>


            <div id="licence_baner">
               <h1>1$ for licence</h1>
            </div>

            <div>
               <div id="licence_buy">
                  <h6>Warranty the lowest price.</h6>

                  <a href="shop.php">
                     <div id="home_buy_button" class="radius_button"> Buy </div>
                  </a>
               </div>

               <div id="app_screnshots">
                  <div id="screen1" onclick="change_app_screenshot('screen1')">
                     <img src="img/app.png" alt="">
                  </div>

                  <div id="screen2" onclick="change_app_screenshot('screen2')">
                     <img src="img/app.png" alt="">
                  </div>

                  <div id="screen3" onclick="change_app_screenshot('screen3')">
                     <img src="img/app.png" alt="">
                  </div>

                  <div id="screenshots_pointer">

                     <div id="pointer1" class="circle current_screen"></div>
                     <div id="pointer2" class="circle"></div>
                     <div id="pointer3" class="circle"></div>

                  </div>

               </div>
            </div>

         </div>
      </div>


      <script src="scripts/jquery-min.js" type="text/javascript"></script>
      <script src="scripts/home.js" type="text/javascript"></script>


   </body>
</html>
