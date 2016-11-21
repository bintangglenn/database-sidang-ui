<?php
include_once 'config.php';
$db = pg_connect("$host $port $dbname $credentials");
if (!$db) {
  echo "Error : unable to open database \n";
  die();
}


 ?>
