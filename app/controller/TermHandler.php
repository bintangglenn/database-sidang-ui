<?php
  /**
   *
   */
  class TermHandler
  {
    private $conn;
    function __construct($connection)
    {
      $this->conn = $connection;
    }

    public function createTerm($tahun, $semester) {

    }

    public function getAllTerm() {
        $query = "SELECT * FROM SISIDANG.TERM";
        $termList = pg_query($this->conn,$query);
        return $termList;
    }
  }

 ?>
