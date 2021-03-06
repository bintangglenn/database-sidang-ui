<?php

  class JadwalSidangHandler
  {
      private $conn;
      public function __construct($connection)
      {
          $this->conn = $connection;
      }

      public static function create($db, $idmks, $npm, $tanggal, $jammulai, $jamselesai, $idruangan, $hardcopy, $dosenpengujiList)
      {
              $idjadwalQuery = 'SELECT max(idjadwal) id FROM SISIDANG.JADWAL_SIDANG'; // get max id jadwal sidang
              $idjadwal = pg_fetch_row($idjadwalQuery) + 1; // increment idjadwal
              $insertJadwalSidangQuery = "INSERT INTO SISIDANG.JADWAL_SIDANG (idjadwal, idmks, tanggal, jammulai, jamselesai, idruangan) VALUES ('$idjadwal', $idmks, '$tanggal', '$jammulai', '$jamselesai', $idruangan)";
              foreach ($dosenpengujiList as $dosenpenguji) { // iterate dosen pengujilist
                   $insertDosenPengujiQuery  = 'INSERT INTO SISIDANG.DOSEN_PENGUJI(idmks, nipdosenpenguji) VALUES ("$idmks", "$dosenpenguji" )';
                   pg_query($db, $insertDosenPengujiQuery);
              }
              $create = pg_query($db, $insertJadwalSidangQuery); // create jadwal sidang
              return $crate;
      }

  }
