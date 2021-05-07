<?php

   require_once 'db_connection.php';

   session_start();

   $username = $_SESSION['username'];

   # Jakies dwie metody tworzenia kluczy aktywacyjnych
   # $token = bin2hex(random_bytes(12));
   $auth_key = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 20), 4));


   #SPRAWDZAM CZY UZYTKOWNIK MA WAZNA LICENCJE
   if($_SESSION['licence_status'] == "No licence"){
      // ta czesc kodu nigdy nie powinna sie wywolac
      // jesli uzytkownik nie bedzie modyfikowal front-endu
      echo "no_licence";

   }
   else{
      # KROK1
      # To zapytanie sprawdza czy w bazie istnieje wygenerowany auth_key
      $a = 0;
      while ($a < 10) {
         // code...
         $sql = "SELECT auth_key FROM generated_auth_keys WHERE auth_key='$auth_key'";
         $result = mysqli_query($connection, $sql);
         $row = mysqli_fetch_assoc($result);

         # Jesli zapytanie zwraca pusty wynik oznacza to, ze
         # wygenerowany auth_key jest unikalny
         if(isset($row['auth_key']) == False){
            break;
         }

         # Sprobuj wygenerowac inny klucz
         $auth_key = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 20), 4));
         $a++;

         # Zabezpieczenie przed nieskonczona petla (malo prawdopodobne)
         if($a == 10){
            #echo "Sorry something went wrong, try again later";
            echo "error";
            exit;

         }
      }


      #KROK2
      # Jesli wygenerowany klucz jest unikalny musze sprawdzic, czy uzytkownik ma juz wygenerowany klucz
      # a) jesli tak: to go podmieniam
      # b) jesli nie: to musze dodac nowy wpis do bazy danych


      $sql2 = "SELECT auth_key FROM generated_auth_keys WHERE username='$username'";
      $result2 = mysqli_query($connection, $sql2);
      $row2 = mysqli_fetch_assoc($result2);

      if(isset($row2['auth_key'])){
         # wariant a)
         $sql3 = "UPDATE generated_auth_keys SET auth_key='$auth_key' WHERE username='$username'";
         $result3 = mysqli_query($connection, $sql3);
      }
      else {
         # awariant b)
         $sql4 = "INSERT INTO generated_auth_keys (username, auth_key, status) VALUES ('$username', '$auth_key', 'not_used') ";
         $result4 = mysqli_query($connection, $sql4);
      }

      # Zwroc wartosc dla uzytkownika
      echo $auth_key;
   }






?>
