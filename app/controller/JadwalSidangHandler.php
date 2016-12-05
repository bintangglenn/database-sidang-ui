<?php

  class JadwalSidangHandler
  {
      private $conn;
      public function __construct($connection)
      {
          $this->conn = $connection;
      }

      public static function create($db, $mahasiswa, $tanggal, $jammulai, $jamselesai, $ruangan, $hardcopy, $dosenpenguji)
      {
          try {
              $sql1 = 'SELECT idmks FROM SISIDANG.JADWAL_SIDANG AS js, SISIDANG.MATA_KULIAH_SPESIAL AS mks, SISIDANG.MAHASISWA AS m FROM js.idmks = mks.idmks AND m.npm = mks.npm AND m.nama = $mahasiswa';

              $sql2 = 'SELECT max(idjadwal) id FROM SISIDANG.JADWAL_SIDANG';

              $sql3 = 'SELECT idruanggan FROM SISIDANG.RUANGAN AS r WHERE r.namaruangan = $ruangan';
              $sql4 = 'SELECT nipdosenpenguji FROM SISIDANG.DOSEN_PENGUJI AS du, SISIDANG.DOSEN AS d WHERE du.nipdosenpenguji = d.nip AND d.nip = $dosenpenguji';
              
              $result = pg_query($sql1);
              $row = pg_fetch_all($result);
              $idmks = $row['idmks'];
              $npm = $row['npm'];

              $result2 = pg_query($sql2);
              $row1 = pg_fetch_all($result2);              
              $idjadwal = $row1['id']+1;

              $result3 = pg_query($sql3);
              $row2 = pg_fetch_all($result3);
              $idruangan = $row2['idruangan'];

              $result4 = pg_query($sql4);
              $row3 = pg_fetch_all($result4);
              $nipdosenpenguji = $row3['nipdosenpenguji'];

              $insert1 = 'INSERT INTO SISIDANG.JADWAL_SIDANG VALUES ("$idjadwal", "$idmks", "$npm", "$tanggal", "$jammulai", "$jamselesai", idruangan )';

              $insert2  = 'INSERT INTO SISIDANG.DOSEN_PENGUJI VALUES ("$idmks", "$nipdosenpenguji" )';
             
              $sql = $insertJS.$valuesJS;
              $create = pg_query($db, $sql);

              return $create;
          } catch (Exception $e) {
              return $e;
          }
      }

  }
