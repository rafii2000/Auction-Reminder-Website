<?php


   function generate_license_key($length = 25, $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ") {
      return join('', str_split(substr(str_shuffle($chars), 0, $length), 5));
   }

   require_once 'db_connection.php';

   $email = "none";
   $date = date("Y-m-d H:i:s");
   $licence_key = generate_license_key();
   echo $licence_key;

   $sql = "INSERT INTO generated_licences (licence, date, email) VALUES( '$licence_key', '$date', '$email')";
   $result = mysqli_query($connection, $sql);


?>
