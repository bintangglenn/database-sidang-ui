<?php
/**
 *
 */
class MahasiswaHandler
{
    private $conn;
    function __construct($connection)
    {
        $this->conn = $connection;
    }

    public static function getAllMahasiswa($connection) {
        $query = "SELECT * FROM SISIDANG.MAHASISWA";
        $mahasiswaList = pg_query($connection ,$query);
        return $mahasiswaList;
    }

    public function getMahasiswa($connection, $npm) {
        $query = "SELECT * FROM SISIDANG.MAHASISWA WHERE npm='$npm'";
        $mahasiswa = pg_query($this->conn, $query);
        return $mahasiswa;
    }

    public function getMahasiswa($connection, $status){
        $query = "SELECT * FROM SISIDANG.MAHASISWA JOIN SISIDANG.MATA_KULIAH_SPESIAL MKS WHERE MKS.status = $status";
        
    }

}

 ?>
