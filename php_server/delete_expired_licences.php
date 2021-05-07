

<?php

   #session_start();

   // Tworze plik do zapisywania rejestrow usunietych licencji
   $logs = fopen("../logs/removed_licences.txt", "a") or exit("Unable to open file!");
   $header = "\n\n" . strval(date("Y-m-d H:i:s")) . "\n" . "EXPIRED LICENCES: " . "\n";
   fwrite($logs, $header);





// KROK1: sprawdzam czy licencja wygasła
// KROK2: zmieniam status licencji w tabeli (users) przy odpowiednim (username)
// KROK3: dodaje informacje o licencji do tabeli (expiried_licences)
// KROK4: usuwam  licencje z tabeli (licene_informations) oraz z tabeli(generated_licences)



   include_once '../php/db_connection.php';


   // KROK1: sprawdzam jakie licencje wygasły
   $today_date = date("Y-m-d H:i:s");
   $sql = "SELECT * FROM licence_informations WHERE expiry_date < '$today_date'";
   $result = mysqli_query($connection, $sql);

   if(mysqli_num_rows($result) > 0){


      $_SESSION['licence'] = "No licence"; // NIE wiem czy to jest dobre???; po co to jest???

      while($row = mysqli_fetch_assoc($result)){

         $licence = $row['licence'];
         $username = $row['username'];
         $activation_date = $row['activation_date'];
         $expiry_date = $row['expiry_date'];
         $length = $row['length'];


         // KROK2: zmieniam status licencji w tabeli (users) przy odpowiednim (username)
         $sql2 = "UPDATE users SET licence = 'No licence' WHERE licence='$licence' ";
         $result2 = mysqli_query($connection, $sql2);


         // KROK3: dodaje informacje o licencji do tabeli (expiried_licences)
         $sql3 = "INSERT INTO used_licences (licence, username, activation_date, expiry_date, length) VALUES('$licence', '$username', '$activation_date', '$expiry_date', '$length')";
         $result3 = mysqli_query($connection, $sql3);


         // KROK4:
         // usuwam dane z tabeli (licene_informations)
         $sql4 = "DELETE FROM licence_informations WHERE licence='$licence'";
         $result4 = mysqli_query($connection, $sql4);

         // usuwam dane z tabeli(generated_licences)
         $sql5 = "DELETE FROM generated_licences WHERE licence='$licence'";
         $result5 = mysqli_query($connection, $sql5);

         // usuwam dane z tabeli (generated_auth_keys)
         $sql6 = "DELETE FROM generated_auth_keys WHERE username='$username'";
         $result6 = mysqli_query($connection, $sql6);


         // KORK5:
         // Dodaje licence do rejestru usunietych licencji
         $removed_licence = "username: " . $username . "  licence: " . $licence . "\n";
         fwrite($logs, $removed_licence);




      }
   }

   fclose($logs);

?>
