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

    public static function create($db, $idmks, $term,  $npm, $type, $title) {
        try {
            $insert = "INSERT INTO SISIDANG.MATA_KULIAH_SPESIAL (idmks, npm, tahun, semester, judul, IdJenisMKS) ";
            $values = "VALUES ($idmks, '$npm', '$term[0]', '$term[1]', '$title', '$type')";
            $sql = $insert . $values;
            $create = pg_query($db, $sql);
            return $create;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function getAllMKS($db) {
        $query = "SELECT * FROM SISIDANG.MATA_KULIAH_SPESIAL";
        $MKSList = pg_query($this->conn,$query);
        return $MKSList;
    }

    public static function getMKSWith($db, $skip, $take, $sort) {
        $query = "SELECT MKS.idmks, MKS.judul, M.nama, MKS.tahun, MKS.semester, J.namamks as jenis, MKS.IsSiapSidang, MKS.PengumpulanHardCopy, MKS.IjinMajuSidang
         FROM SISIDANG.MATA_KULIAH_SPESIAL AS MKS, SISIDANG.MAHASISWA AS M, SISIDANG.JENISMKS AS J
         WHERE MKS.npm = M.npm AND MKS.idjenismks = J.id
         OFFSET $skip LIMIT $take";
        if ($sort != "") $query .= " ORDER BY $sort";
        $MKSList = pg_query($db,$query);
        $query = "SELECT COUNT(*) FROM SISIDANG.MATA_KULIAH_SPESIAL";
        $count = pg_query($db,$query);

        return ['mkslist' => pg_fetch_all($MKSList), 'total' => pg_fetch_row($count)[0] / $take];
    }
  }

 ?>
