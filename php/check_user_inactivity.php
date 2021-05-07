<?php

   #SPRAWDZAM STAN BEZCZYNNOSCI (to musi byc w osobnym pliku)
   $idletime=900;//after 60 seconds the user gets logged out

   if(isset($_SESSION['timestamp'])){
      #oznacza ze uzytkownik jest zalogowany
      if (time()-$_SESSION['timestamp']>$idletime){
          #session_destroy();
          #session_unset();
          header('Location: php/log_out.php');
      }else{
          $_SESSION['timestamp']=time();
      }
      echo "zalogowany";
   }

?>
