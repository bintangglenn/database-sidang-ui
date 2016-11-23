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

    public static function getAllJenisMKS($db) {
        $query = "SELECT * FROM SISIDANG.JENISMKS";
        $jenisMKSList = pg_query($db,$query);
        return $jenisMKSList;
    }
  }

 ?>
