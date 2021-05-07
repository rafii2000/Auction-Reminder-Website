<?php

   include_once 'db_connection.php';

   $username = $_POST["username"];
   $password = $_POST["password"];


   $username = htmlentities($username, ENT_QUOTES, "UTF-8");
   $password = htmlentities($password, ENT_QUOTES, "UTF-8");



   //PROBLEM Z DWOMA KONTAMI NA JEDNYM KOMPUTERZE
   //W KTORYM MIEJSCU NASTEPUJE PRZELACZENIE ????
   //CHCE TO ZLOKALIZOWAC BO WYPADALO BY USUNAC JEDNO KONTO Z BAZY DANYCH




   // SQL INJECTION PROTECTION
   $sql = sprintf("SELECT username, password, licence FROM users WHERE username='%s'",
      mysqli_real_escape_string($connection, $username));
   //$sql = "SELECT username, password, licence FROM users WHERE username='$username'";

   $result = mysqli_query($connection, $sql);
   $row = mysqli_fetch_assoc($result);

   // $_SESSION['licence'] = $row['licence'];

   //Walidacja danych logowania
   if($password == $row['password'] && $row['username'] != ""){

      //Sprawdz czy w bazie danych istnieje SID dla logowanego konta
      $sql6 = "SELECT sid FROM login_accounts WHERE username='$username'";
      $result6 = mysqli_query($connection, $sql6);
      $row6 = mysqli_fetch_assoc($result6);


      $sid = $row6['sid'];
      if(isset($sid)){
         session_id($sid);
         session_start();
         session_destroy();

         //echo "account in usage";
         //exit;
      }


      // W tym miejscu nie tworzy mi sie nowa sesja tylko stara
      // Tworze pliki cookie aktywne przez 15min (nie wiem jak to do konca dziala)

      // server should keep session data for AT LEAST 1 hour
      ini_set('session.gc_maxlifetime', 900);
      // each client should remember their session id for EXACTLY 1 hour
      session_set_cookie_params(900);

      session_start();
      session_regenerate_id();

      $_SESSION['username'] = $_POST['username'];
      $_SESSION['timestamp'] = time();

      // Licencja bedzie sprawdzana w panelu uzytkownika
      // $_SESSION['licence'] = $row['licence'];


      // echo "http://localhost/Auction%20Reminder/user_panel.php";
      // header("Location: http://localhost/Auction%20Reminder/user_panel.php");



      //Dodaj SID aktualnie zalogowanego komputera do bazy danych
      if($sid == ""){
         $sid = session_id();
         $sql7 = "INSERT INTO login_accounts (username, sid) VALUES('$username', '$sid')";
         $result7 = mysqli_query($connection, $sql7);
         echo $sid . "<br>";
         echo "insert";
      }
      else{
         $sid = session_id();
         $sql8 = "UPDATE login_accounts SET sid='$sid' WHERE username='$username'";
         $result8 = mysqli_query($connection, $sql8);
         echo $sid . "<br>";
         echo "update";
      }

   }
   else {
      echo "no matches";
      exit;
   }



?>
