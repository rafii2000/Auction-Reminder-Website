<?php

   include_once "db_connection.php";

   $input_name = $_GET['input_name'];
   $input_value = $_GET[$input_name];

   // $username = $_POST['username'];
   // $email = $_POST['email'];
   // $password1 = $_POST['password1'];
   // $password2 = $_POST['password2'];

   // $sql = "SELECT username FROM users WHERE username='$username'";

   //Database tables: username password email
   $sql = "SELECT $input_name FROM users WHERE $input_name='$input_value'";
   $result = mysqli_query($connection, $sql);
   $row = mysqli_fetch_assoc($result);

   if(empty($row[$input_name])){
      echo "not_exist";
   }
   else {
      echo "exist";
   }





?>
