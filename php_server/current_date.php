<?php

   $current_date = date("Y-m-d H:i:s");

   $dateObj = new stdClass();
   $dateObj->fulldate = date("Y-m-d H:i:s");
   $dateObj->year = (int)date("Y");
   $dateObj->month = (int)date("m");
   $dateObj->day = (int)date("d ");
   $dateObj->hour = (int)date("H");
   $dateObj->minute = (int)date("i");
   $dateObj->second = (int)date("s");

   $myJSON = json_encode($dateObj);

   echo $myJSON;




   //echo $current_date;




?>
