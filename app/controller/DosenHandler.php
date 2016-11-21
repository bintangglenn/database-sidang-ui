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

    public function getAlldosen() {
        $query = "SELECT * FROM SISIDANG.DOSEN";
        $dosenList = pg_query($this->conn,$query);
        return $dosenList;
    }
  }

 ?>
