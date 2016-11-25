<?php
include_once 'config.php';
$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=2456298.5");
if (!$db) {
  echo "Error : unable to open database \n";
  die();
}


 ?>
