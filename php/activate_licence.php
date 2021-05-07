<?php

   session_start();


   include_once 'db_connection.php';

   $licence = $_POST["licence"];
   $session_username = $_SESSION['username'];

   //Information about licence
   $activation_date = date("Y/m/d H:i:s");
   #$expiry_date = date("Y/m/d H:i:s", strtotime("+1 month"));
   $expiry_date = date("Y/m/d H:i:s", strtotime("+2 minute"));
   $length = 30;




   //KROK 1
   //sprawdzam czy uzytkownik ma aktywna licencje
   $sql1 = "SELECT licence FROM users WHERE username='$session_username'";
   $result1 = mysqli_query($connection, $sql1);
   $row1 = mysqli_fetch_assoc($result1);

   if($row1["licence"] != "No licence"){
      // uzytkownik ma aktywna licence, wiec nie moze aktywowac kolejnej
      echo "activated";
   }
   else{
      //uzytkownik nie ma aktywnej licencji, moze aktywowac licencje

      //KROK 2
      //sprawdzam czy podana licencja jest wygenerowana(kupiona)
      $sql2 = "SELECT licence FROM generated_licences WHERE licence='$licence'";
      $result2 = mysqli_query($connection, $sql2);
      $row2 = mysqli_fetch_assoc($result2);

      if(empty($row2)){
         // taka licencja nie zostala kupiona(wygenerowana)
         echo "not exist";
      }
      else{
         // taka licencja zostala kupiona(wygenerowana)

         // //KROK 3
         // //jesli kupiona licencja nie jest uzywana to wtedy ja akceptujemy
         $sql3 = "SELECT licence FROM licence_informations WHERE licence='$licence'";
         $result3 = mysqli_query($connection, $sql3);
         $row3 = mysqli_fetch_assoc($result3);

         if(empty($row3['licence'])){
            // kupiona licencja NIE JEST jeszcze uzywana


            // KROK4
            // nalezy dopisacj ja do konta uzytkownika(users)
            $sql4 = "UPDATE users SET licence='$licence' WHERE username='$session_username'";

               if (mysqli_query($connection, $sql4)) {
                  //echo "Record updated successfully";
               }
               else{
                  echo "Error updating record: " . mysqli_error($connection);
               }

            // KROK5
            //nalezy zmodyfikowac baze informacji o licencjach(licence_informations)

            $sql5 = "INSERT INTO licence_informations (licence, username, activation_date, expiry_date, length) VALUES('$licence','$session_username','$activation_date', '$expiry_date', '$length')";

               if (mysqli_query($connection, $sql5)) {
                  //echo "Record updated successfully";
               }
               else{
                  echo "Error updating record: " . mysqli_error($connection);
               }


            $_SESSION['licence'] = $licence;
            echo "valid";
         }
         else{

            //KROK4
            // kupiona licencja JEST juz uzywana()
            echo "in_usage";
         }

      }
   }

?>
