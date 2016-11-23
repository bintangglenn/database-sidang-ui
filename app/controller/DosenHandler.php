<?php
  /**
   *
   */
  class DosenHandler
  {
    private $conn;
    function __construct($connection)
    {
      $this->conn = $connection;
    }

    public static function getAlldosen($db) {
        $query = "SELECT * FROM SISIDANG.DOSEN";
        $dosenList = pg_query($db,$query);
        return $dosenList;
    }
  }

 ?>
