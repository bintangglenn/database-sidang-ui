<?php

  class JadwalSidangHandler
  {
      private $conn;
      public function __construct($connection)
      {
          $this->conn = $connection;
      }

      public static function create($db, $idJadwal, $idmks, $tanggal, $jammulai, $jamselesai, $idruangan)
      {
          $query = "INSERT INTO SISIDANG.JADWAL_SIDANG (idjadwal, idmks, tanggal, jammulai, jamselesai, idruangan) VALUES ($idjadwal, $idmks, '$tanggal', '$jammulai', '$jamselesai', $idruangan)";
          $resut = pg_query($db, $query);
          return $result;
      }

  }
