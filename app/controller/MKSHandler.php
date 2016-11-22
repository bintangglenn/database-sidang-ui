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

    public function create($idmks, $term,  $npm, $type, $title, $adviserList, $examinerList) {
        try {
            $insert = "INSERT INTO SISIDANG.MATA_KULIAH_SPESIAL (idmks, npm, tahun, semester, judul, IdJenisMKS) ";
            $values = "VALUES ($idmks, '$npm', '$term[0]', '$term[1]', '$title', '$type')";
            $sql = $insert . $values;
            $create = pg_query($this->conn, $sql);
            return $create;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function getAllMKS() {
        $query = "SELECT * FROM SISIDANG.MATA_KULIAH_SPESIAL";
        $MKSList = pg_query($this->conn,$query);
        return $MKSList;
    }
  }

 ?>
