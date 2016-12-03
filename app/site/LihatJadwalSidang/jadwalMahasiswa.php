<?php session_start();
  function connectDB() {
   $conn = pg_connect('host=localhost port=5432 dbname=postgres user=postgres password=theinvoker');
   
    if (!$conn) {
      die("Connection failed");
    }
    return $conn;
  }

  function checkSiapSidang() {
  	$conn = connectDB();

    $sql = "SELECT * FROM mata_kuliah_spesial WHERE NPM = " . $_SESSION['loggedNPM'] . " AND IsSiapSidang = true";
    
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
    
    $sql = "SELECT mks.IdMKS, mks.judul, js.tanggal, js.jamMulai, js.jamSelesai, r.namaRuangan FROM mata_kuliah_spesial AS mks, jadwal_sidang AS js, ruangan AS r WHERE mks.IdMKS = js.idmks AND r.idRuangan = js.idRuangan AND mks.NPM = $npm";
    
    if(!$result = pg_query($conn, $sql)) {
      die("Error: $sql");
    }
    pg_close($conn);
    return $result;
  }

  function selectDosenPenguji($id) {
    $conn = connectDB();

    $sql = "SELECT d.nama FROM dosen_penguji AS du, dosen AS d, mata_kuliah_spesial AS mks WHERE d.NIP = du.nipdosenpenguji AND du.IDMKS = mks.IdMKS AND mks.NPM = $id";

    if(!$result = pg_query($conn, $sql)) {
      die("Error: $sql");
    }
    pg_close($conn);
    return $result; 
  }

  function selectDosenPembimbing($id) {
    $conn = connectDB();

    $sql = "SELECT d.nama FROM dosen_pembimbing AS dp, dosen AS d, mata_kuliah_spesial AS mks WHERE d.NIP = dp.nipdosenpembimbing AND dp.IDMKS = mks.IdMKS AND mks.NPM = $id";

    if(!$result = pg_query($conn, $sql)) {
      die("Error: $sql");
    }
    pg_close($conn);
    return $result; 
  }

  function getStatus($id) {
    $conn = connectDB();

    $sql = "SELECT mks.PengumpulanHardCopy, mks.IjinMajuSidang FROM mata_kuliah_spesial AS mks WHERE mks.idmks = $id";

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

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['command'] === 'logout') {
    	if(isset($_SESSION['loggedUser'])) {
    		unset($_SESSION['loggedUser']);
    		unset($_SESSION['loggedRole']);
    		unset($_SESSION['loggedNPM']);
    		header("Location: ../Login/index.php");
    	}
    } 
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
		<div class="container" style="max-width: 80vw;">
			<div class="menuBar col-md-12" style="margin-top: 2vh; border-bottom: 2px solid lightgrey;">
				<h3 class="col-md-1" style="margin-top: 10px;">Mahasiswa</h3>
				<?php
		          if(isset($_SESSION['loggedUser'])) {
		            echo "<form action=\"jadwalMahasiswa.php\" method=\"post\" style=\"float: right; margin: 5px;\">
		                <input type=\"hidden\" id=\"logout-command\" name=\"command\" value=\"logout\">
		                <button type=\"submit\" class=\"btn btn-danger\">Logout</button>
		              </form>
		              ";
		          }
		        ?>
			</div>
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
                    $data = selectDosenPembimbing($_SESSION['loggedNPM']);
                    while($row = pg_fetch_row($data)) {
                        echo "$row[0], ";
                    }
                    echo "<b>Status: $status</b><td>
                        </tr>
                        <tr>
                            <th>Dosen Penguji</th>
                            <td><ul>";
                    $data = selectDosenPenguji($_SESSION['loggedNPM']);
                    while($row = pg_fetch_row($data)) {
                        echo "<li>$row[0]</li>";
                    }
                    echo "</ul></td></tr></table></div>";
                }
			?>
		</div>
	</body>
</html>