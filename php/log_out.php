<?php

   session_start();

   $username = $_SESSION['username'];

   include_once 'db_connection.php';
   $sql = "DELETE FROM login_accounts WHERE username='$username'";
   $result = mysqli_query($connection, $sql);


   session_destroy();
   session_unset();
   
   header("Location: ../index.php");
   exit;

?>
