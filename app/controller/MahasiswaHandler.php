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

    public function getAllMahasiswa() {
        $query = "SELECT * FROM SISIDANG.MAHASISWA";
        $mahasiswaList = pg_query($this->conn,$query);
        return $mahasiswaList;
    }

    public function getMahasiswa($npm) {
        $query = "SELECT * FROM SISIDANG.MAHASISWA WHERE npm='$npm'";
        $mahasiswa = pg_query($this->conn, $query);
        return $mahasiswa;
    }

}

 ?>
