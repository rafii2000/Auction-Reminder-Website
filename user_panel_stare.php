<?php
   session_start();

   echo session_id();

   //zapobiega przed dostaniem sie do panelu uzytkownia bez logowania
   if (empty($_SESSION['username'])){

      header("Location: http://localhost/Auction%20Reminder/php/log_out.php");
   }
   else {


      $licence = $_SESSION['licence'];


      $licence == "No licence" ? $licence_status=$licence: $licence_status = "Valid";

      // TODO: zbierz informacje na temat licencji i je wyswietl

      require_once "php/db_connection.php";

      $sql = "SELECT activation_date, expiry_date, length FROM licence_informations WHERE licence='$licence'";
      $result = mysqli_query($connection, $sql);
      $row = mysqli_fetch_assoc($result);

      $activation_date = $row['activation_date'];
      $expiry_date = $row['expiry_date'];
      $length = $row['length'];


      $current_date= date_create(strval(date("Y-m-d H:i:s")));
      $expiry_date = date_create($expiry_date);

      if($current_date > $expiry_date){
         //$f_remainig_time = "0 days, 0 hours,  0 minutes,  0 seconds";
         $f_remainig_time = "";
      }
      else{
         $remainig_time = date_diff($expiry_date, $current_date);
         $f_remainig_time = $remainig_time->format("%d days, %h hours,  %i minutes,  %S seconds");
      }

      //$remainig_time = date_diff($expiry_date, $current_date);
      //$f_remainig_time = $remainig_time->format("%D days, %h hours,  %I minutes,  %S seconds");
      // format("Days: %D hours: %H. minutes: %I. seconds: %S");
   }




?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

   <head>
      <meta charset="utf-8">
      <title>Auction Reminder - User Panel</title>
      <link rel="stylesheet" href="css/user_panel.css">
      <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;1,300&display=swap" rel="stylesheet">
      <link rel="shortcut icon" href="#" />
   </head>

   <body>
      <div id="navbar">
         <a href="home.php">
            <div id="navbar_logo">
                  <img id="logo" src="img/logo-80.png" alt="">
                  User Panel: <?php echo $_SESSION['username']; ?>
            </div>
         </a>

         <div id="navbar_buttons">

            <a href="">
               <div class="nav_button">
                  Shop
               </div>
            </a>

            <a href="">
               <div class="nav_button">
                  Settings
               </div>
            </a>

            <a href="php/log_out.php">
               <div class="nav_button last">
                  Log out
               </div>
            </a>
         </div>

      </div>

      <div id="container">
         <div id="left_container">

            <div id="left_current_licence">

               <div class="section_title">CURRENT</div>
               <div class="property_value">  </div>

               <div class="property_name" >Licence status:</div>
               <div class="property_value" <?php echo $licence_status=="Valid" ? "style='color: #6AFF16' >". $licence_status : "style='color: red' >" . $licence_status; ?> </div>


               <div class="property_name">Licence code:</div>
               <div class="property_value"> <?php echo $licence == "No licence" ?  "" :  $licence ?> </div>



               <div class="property_name">Activation date:</div>
               <div class="property_value"><?php echo $activation_date ?></div>

               <div class="property_name">Expiry time:</div>
               <div class="property_value"><?php echo $activation_date==""?  "" : $f_remainig_time ; ?></div>

            </div>

            <div id="left_licence_history">

               <div class="section_title">HISTORY</div>
               <div class="property_value"></div>

               <div class="property_name">Licence code:</div>
               <div class="property_value">dmLjMV*K2K@49??^3_@grB%9v3CUK^Jt</div>

               <div class="property_name">Licence code:</div>
               <div class="property_value">u5wr68xD#Z3HXtY9S6zQXaJ_*JV#D6yp</div>

               <div class="property_name">Licence code:</div>
               <div class="property_value">3SyhpRqf2X2jVgjVa2msX5$2R^nm4LJ8</div>

               <div class="property_name">Licence code:</div>
               <div class="property_value">cGv@Y-tUUrF4=%+@Jah3YZ-^ZwzmPW=Y</div>

            </div>

         </div>

         <div id="right_container">

            <div id="right_licence_activation">
               <form class="" action="" method="post">

                  <div class="label_and_error_message">
                     <label>Licence Code:</label>
                     <div id="licence_code_status" class="error_message"></div>
                  </div>

                  <div class=""></div>

                  <input id="activate_licence_input" type="text" name="licence" value="">
                  <button type="button" name="button" onclick="ajax_active_licence(this.form[0].value)">Activate</button>
               </form>

               <form class="" action="#" method="post">
                  <div class="label_and_error_message">
                     <label>Aplication Key:</label>
                     <div class="error_message"></div>
                  </div>
                  <div class=""></div>

                  <input type="text" name="" value="">
                  <button type="button" name="button">Generate</button>
               </form>
            </div>

            <div id="right_change_password">
               <form class="" action="#" method="post">

                  <label>New Password:</label>
                  <div class=""></div>


                  <input type="email" name="" value="">
                  <div class=""></div>

                  <label>Repeate New Password:</label>
                  <div class=""></div>

                  <input type="password" name="" value="">
                  <button type="button" name="button">Change</button>
               </form>
            </div>

         </div>

      </div>

      <script src="scripts/jquery-min.js" type="text/javascript"></script>
      <script src="scripts/activate_licence.js" type="text/javascript"></script>
   </body>
</html>
