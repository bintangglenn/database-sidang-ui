<?php
  /**
   *
   */
  class JenisMKSHandler
  {
    private $conn;
    function __construct($connection)
    {
      $this->conn = $connection;
    }

    public function createJenisMKS($id, $nama) {

    }

    public function getAllJenisMKS() {
        $query = "SELECT * FROM SISIDANG.JENISMKS";
        $jenisMKSList = pg_query($this->conn,$query);
        return $jenisMKSList;
    }
  }

 ?>
