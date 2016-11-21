<?php
  /**
   *
   */
  class MKSHandler
  {
    private $conn;
    function __construct($connection)
    {
      $this->conn = $connection;
    }

    public function createMKS($term, $jenismks, $npm, $judulmks, $pembimbing, $penguji) {

    }

    public function getAllMKS() {
        $query = "SELECT * FROM SISIDANG.MATA_KULIAH_SPESIAL";
        $MKSList = pg_query($this->conn,$query);
        return $MKSList;
    }
  }

 ?>
