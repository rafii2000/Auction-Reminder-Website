<?php

   include_once 'db_connection.php';

   $username = $_POST['username'];
   $email = $_POST['email'];
   $password1 = $_POST['password1'];
   $password2 = $_POST['password2'];


   // echo $username . "<br>";
   // echo $email . "<br>";
   // echo $password1 . "<br>";
   // echo $password2 . "<br>";

   // TODO: w tym miejscu nalezy jeszcze zrobic sprawdzanie danych przez serwer
   //       oraz ochorne przed SQL injection

   if(empty($username) or empty($email) or empty($password1) or empty($password2)){
      echo "error message";
   }
   else {
      echo "successful";
      $sql = "INSERT INTO users (username, password, email) VALUES('$username', '$password1', '$email')";

      mysqli_query($connection, $sql);
   }





 ?>
