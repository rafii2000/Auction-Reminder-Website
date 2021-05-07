<?php
   session_start();

   echo session_id() . " create: " . $_SESSION['timestamp'];


   #SPRAWDZAM STAN BEZCZYNNOSCI UZYTKOWNIKA
   require_once "php/check_user_inactivity.php";


   //Zapobiega przed dostaniem sie do panelu uzytkownia bez logowania
   if (empty($_SESSION['username'])){

      // header("Location: http://localhost/Auction%20Reminder/php/log_out.php");
      header("Location: php/log_out.php");
   }
   else {

      //Jesli uzytkowni zalogowany poprawnie, stworz panel
      require_once "php/db_connection.php";

      $username = $_SESSION['username'];


      // SPRAWDZAM CZY ZALOGOWANY UZYTKOWNIK POSIADA LICENCJE
      $sql = "SELECT licence FROM users WHERE username='$username'";
      $result = mysqli_query($connection, $sql);
      $row = mysqli_fetch_assoc($result);

      $licence = $row['licence'];
      $licence_status = "No licence";
      $_SESSION['licence_status'] = $licence;

      #$licence == "No licence" ? $licence_status=$licence: $licence_status = "Valid";


      if($licence == "No licence"){

         $licence_status = "No licence";
         $activation_date = "";
         $expiry_date = "";
         $length = "";
         $remainig_time = "";
         $auth_key = "";

      }
      else {

         //SPRAWDZAM CZY ZALOGOWANY UZYTKOWANIK MA WAZNA LICENCJE
         $sql = "SELECT licence, activation_date, expiry_date, length FROM licence_informations WHERE licence='$licence'";
         $result = mysqli_query($connection, $sql);
         $row = mysqli_fetch_assoc($result);

         $activation_date = $row['activation_date'];
         $expiry_date = $row['expiry_date'];
         $length = $row['length'];


         // TWORZE ZMIENNE DO WYSWIETLENIA W PANELU W ZALEZNOSCI
         // OD STANU LICENCJI (wazna/wygasla)
         $current_date= date_create(strval(date("Y-m-d H:i:s")));
         $expiry_date = date_create($expiry_date);


         if($current_date > $expiry_date){
            // a) licencja wygasla

            $licence_status = "No licence";
            $activation_date = "";
            $expiry_date = "";
            $length = "";
            $remainig_time = "";
            $auth_key = "";
         }
         else{
            //b) licencja jest wazna
            $licence_status = "Valid";
            $remainig_time = date_diff($expiry_date, $current_date)->format("%d days, %h hours,  %i minutes,  %S seconds");

            //wczytuje auth_key UZYTKOWNIKA

            $sql3 = "SELECT auth_key FROM generated_auth_keys WHERE username='$username'";
            $result3 = mysqli_query($connection, $sql3);
            $row3 = mysqli_fetch_assoc($result3);

            $auth_key = "";
            if(isset($row3['auth_key'])){
               // wczytuje uzywany auth key
               $auth_key = $row3['auth_key'];
            }

         }
      }





      //ZBIERAM DANE NA TEMAT WYKORZYSTANYCH LICENCJI UZYTKOWNIKA (HISTORY)
      $sql4 = "SELECT licence, activation_date, expiry_date, length FROM used_licences WHERE username='$username'";
      $result4 = mysqli_query($connection, $sql4);
      $row4_nums = mysqli_num_rows($result4);

   }

   // TODO:
   # NALEZY JESZCZE DODAC WYSWIETLANIE POSIADANEGO AUTH KEY
   # ORAZ ZABLOKOWAC MOZLIWOS GENEROWANIA AUTH KEY JESLI LICENCJA JEST NIEWAZNA
   #PODCZAS ODSWIEZANIA STRONY TRZEBA TEZ SPRAWDZAC LICENCJE, BO PRZY LOGOWANIU TO CHYBA ZA MALO?






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
         <a href="index.php">
            <div id="navbar_logo">
                  <img id="logo" src="img/logo-80.png" alt="">
                  <?php echo $_SESSION['username']; ?>
            </div>
         </a>

         <div id="navbar_buttons">

            <a href="home.php">
               <div class="nav_button">
                  Home
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


         <div id="top_container">

            <div id="top_current_licence">

               <div class="section_title">CURRENT</div>
               <div class="property_value">  </div>

               <div class="property_name" >Licence status:</div>
               <div class="property_value" <?php echo $licence_status=="Valid" ? "style='color: #6AFF16; font-weight: bold;' >". $licence_status : "style='color: red; font-weight: bold;' >" . $licence_status; ?> </div>


               <div class="property_name">Licence code:</div>
               <div class="property_value"> <?php echo $licence == "No licence" ?  "" :  $licence ?> </div>



               <div class="property_name">Activation date:</div>
               <div class="property_value"><?php echo $activation_date ?></div>

               <div class="property_name">Expiry time:</div>
               <div class="property_value"><?php echo $remainig_time ?></div>
               <?php //echo $activation_date==""?  "" : $f_remainig_time ; ?>

            </div>

            <div id="top_licence_activation">
               <form class="" action="" method="post">

                  <div class="label_and_error_message">
                     <label>Licence Code:</label>
                     <div id="licence_code_status" class="error_message"></div>
                  </div>

                  <div class=""></div>

                  <input id="activate_licence_input" type="text" name="licence" value="">
                  <button type="button" name="button" onclick="ajax_active_licence(this.form[0].value)">Activate</button>
               </form>


               <form class="" action="" method="post">
                  <div class="label_and_error_message">
                     <label>Auth Key:</label>
                     <div id="auth_key_status" class="error_message"></div>
                  </div>
                  <div class=""></div>

                  <!-- <input type="text" name="" value="0re5g4regre5g6" disabled> -->
                  <div id="auth_key_field"> <?php echo $auth_key; ?> </div>

                  <button type="button" name="button" onclick="ajax_generate_auth_key()" <?php echo $licence=="No licence" ? 'disabled': "" ; ?>>Generate</button>
               </form>


            </div>



         </div>

         <div id="bottom_container">



            <div id="bottom_licence_history">


               <div class="section_title">HISTORY</div>
               <div class="property_value"></div>
               <div class="property_value"></div>
               <div class="property_value"></div>
               <div class="property_value"></div>

               <div class="column_header">#</div>
               <div class="column_header">Licence code:</div>
               <div class="column_header">Length</div>
               <div class="column_header">Activation date</div>
               <div class="column_header">Expiry date</div>


               <?php

                  $lp = 1;
                  if($row4_nums > 0){

                     while($row4 = mysqli_fetch_assoc($result4)){

                        echo "<div class='property_value'>". $lp ."</div>";
                        echo "<div class='property_value'>". $row4['licence'] ."</div>";
                        echo "<div class='property_value'>". $row4['length'] ."</div>";
                        echo "<div class='property_value'>". $row4['activation_date'] ."</div>";
                        echo "<div class='property_value'>". $row4['expiry_date'] ."</div>";

                        $lp = $lp+1;
                     }

                  }

               ?>

            </div>


         </div>

      </div>

      <script src="scripts/jquery-min.js" type="text/javascript"></script>
      <script src="scripts/activate_licence.js" type="text/javascript"></script>
      <script src="scripts/generate_auth_key.js" type="text/javascript"></script>


   </body>
</html>
