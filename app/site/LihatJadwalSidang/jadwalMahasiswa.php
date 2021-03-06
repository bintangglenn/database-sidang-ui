<?php session_start();
  function connectDB() {
   $conn = pg_connect('host=localhost port=5432 dbname=postgres user=postgres password=2456298.5');
   
    if (!$conn) {
      die("Connection failed");
    }
    return $conn;
  }

  function checkSiapSidang() {
  	$conn = connectDB();
    $npm = $_SESSION['loggedNPM'];
    $sql = "SELECT * FROM SISIDANG.mata_kuliah_spesial WHERE NPM = '$npm' AND IsSiapSidang = true";
    
    if(!$result = pg_query($conn, $sql)) {
      die("Error: $sql");
    }
    pg_close($conn);
    if(pg_fetch_row($result) == null) {
    	return false;
    }
    else return true;
  }

  function selectAll($npm) {
    $conn = connectDB();
    
    $sql = "SELECT mks.IdMKS, mks.judul, js.tanggal, js.jamMulai, js.jamSelesai, r.namaRuangan, mks.idmks FROM SISIDANG.mata_kuliah_spesial AS mks, SISIDANG.jadwal_sidang AS js, SISIDANG.ruangan AS r WHERE mks.IdMKS = js.idmks AND r.idRuangan = js.idRuangan AND mks.NPM = '$npm' ORDER BY js.tanggal DESC LIMIT 1";
    
    if(!$result = pg_query($conn, $sql)) {
      die("Error: $sql");
    }
    pg_close($conn);
    return $result;
  }

  function selectDosenPenguji($id) {
    $conn = connectDB();

    $sql = "SELECT d.nama FROM SISIDANG.dosen_penguji AS du, SISIDANG.dosen AS d, SISIDANG.mata_kuliah_spesial AS mks WHERE d.NIP = du.nipdosenpenguji AND du.IDMKS = mks.IdMKS AND mks.idmks = '$id'";

    if(!$result = pg_query($conn, $sql)) {
      die("Error: $sql");
    }
    pg_close($conn);
    return $result; 
  }

  function selectDosenPembimbing($id) {
    $conn = connectDB();

    $sql = "SELECT d.nama FROM SISIDANG.dosen_pembimbing AS dp, SISIDANG.dosen AS d, SISIDANG.mata_kuliah_spesial AS mks WHERE d.NIP = dp.nipdosenpembimbing AND dp.IDMKS = mks.IdMKS AND mks.idmks = '$id'";

    if(!$result = pg_query($conn, $sql)) {
      die("Error: $sql");
    }
    pg_close($conn);
    return $result; 
  }

  function getStatus($id) {
    $conn = connectDB();

    $sql = "SELECT mks.PengumpulanHardCopy, mks.IjinMajuSidang FROM SISIDANG.mata_kuliah_spesial AS mks WHERE mks.idmks = '$id'";

    if(!$result = pg_query($conn, $sql)) {
      die("Error: $sql");
    }
    pg_close($conn);
    
    $hasil = "";
    $row = pg_fetch_row($result);
    if($row[0] == true) {
        $hasil .= "Izin Maju Sidang";
    }
    if($row[0] == true && $row[1] == true) {
        $hasil .= ", ";
    }
    if($row[1] == true) {
        $hasil .= "Kumpul Hard Copy";
    }

    return $hasil;
  } 
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisidang - Lihat Jadwal (Mahasiswa)</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../../libs/css/bootstrap.min.css">
        <script src="../../libs/js/jquery.min.js"></script>
        <script src="../../libs/js/bootstrap.min.js"></script>
	</head>
	<body>
        <header>
            <nav class="navbar navbar-inverse">
                <div class="container">
                    <a class="navbar-brand" href="../HalamanUtama/mahasiswa.php"> Sisidang </a>
                    <ul class="nav navbar-nav">
                        <li class="nav-item">
                            <li><a href="../LihatJadwalSidang/jadwalMahasiswa.php">Lihat Jadwal Sidang</a></li>
                        </li> <!--nav-item--> 
                        <li class="nav-item">
                            <li><a href="../Logout/logout.php">Logout</a></li>
                        </li><!--nav-item-->           
                    </ul>
                </div>
            </nav>
        </header>
		<div class="container" style="max-width: 80vw;">
			<?php 
				if(checkSiapSidang() == false) {
					echo "<h1 class=\"col-md-12\" style=\"text-align: center;\">Jadwal Sidang Anda Belum Ada</h1>";
				}
				else {
                    $data = selectAll($_SESSION['loggedNPM']);
                    $row = pg_fetch_row($data);
                    $date = date_format(date_create($row[2]), "j F Y");
                    $status = getStatus($row[0]);
                    $time = substr($row[3], 0, 5) . " - " . substr($row[4], 0, 5);
                    echo "<div class=\"sidangMahasiswa col-md-12\" style=\"margin-top: 10px; font-size: 2vw;\">
                        <table class=\"table table-responsive\" style=\"margin-top: 3vh;padding-right:0px;\">
                            <tr>
                                <th>Judul Tugas Akhir</th>
                                <td>$row[1]</td>
                            </tr>
                            <tr>
                                <th>Jadwal Sidang</th>
                                <td>$date</td>
                            </tr>
                            <tr>
                                <th>Waktu Sidang</th>
                                <td>$time @ $row[5]</td>
                            </tr>
                            <tr>
                                <th>Dosen Pembimbing</th>
                                <td>";
                    $dataDP = selectDosenPembimbing($row[6]);
                    while($rowDP = pg_fetch_row($dataDP)) {
                        echo "$rowDP[0], ";
                    }
                    echo "<b>Status: $status</b><td>
                        </tr>
                        <tr>
                            <th>Dosen Penguji</th>
                            <td><ul>";
                    $dataDU = selectDosenPenguji($row[6]);
                    while($rowDU = pg_fetch_row($dataDU)) {
                        echo "<li>$rowDU[0]</li>";
                    }
                    echo "</ul></td></tr></table></div>";
                }
			?>
		</div>
	</body>
</html>