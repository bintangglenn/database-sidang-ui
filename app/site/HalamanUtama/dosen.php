<?php session_start();
	function connectDB() {
		$conn = pg_connect('host=localhost port=5432 dbname=postgres user=postgres password=admin05');
		
		if (!$conn) {
			die("Connection failed");
		}
		return $conn;
	}

	function selectAllFromDosen() {
		$conn = connectDB();

		$nip = $_SESSION['loggedNIP'];
		$sql = "SELECT * FROM SISIDANG.dosen WHERE nip = $nip";
		
		if(!$result = pg_query($conn, $sql)) {
			die("Error: $sql");
		}
		pg_close($conn);
		return $result;
	}

	function getInfoSidang() {
		$conn = connectDB();

		$nip = $_SESSION['loggedNIP'];
		date_default_timezone_set('Asia/Jakarta');
		$bulan = date('m');
		$tahun = date('Y');
		$sql = "SELECT js.tanggal, j.NamaMKS, mks.Judul, m.nama, js.jamMulai, js.jamSelesai, r.namaRuangan
				FROM SISIDANG.jadwal_sidang AS js, SISIDANG.mata_kuliah_spesial AS mks, SISIDANG.ruangan AS r, SISIDANG.jenismks AS j, SISIDANG.mahasiswa AS m
				WHERE EXISTS (
					SELECT 1 FROM SISIDANG.dosen_pembimbing AS db, SISIDANG.dosen_penguji AS du
					WHERE js.idmks = du.idmks AND js.idmks = db.IDMKS AND EXTRACT(MONTH FROM js.tanggal) = $bulan AND EXTRACT(YEAR FROM js.tanggal) = $tahun AND
					(du.nipdosenpenguji = '$nip' OR db.nipdosenpembimbing = '$nip'))
					AND r.idRuangan = js.idRuangan AND js.idmks = mks.IdMKS AND j.ID = mks.IdJenisMKS AND m.npm = mks.NPM
				ORDER BY js.tanggal";
		
		if(!$result = pg_query($conn, $sql)) {
			die("Error: $sql");
		}
		pg_close($conn);
		return $result;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisidang - Dosen</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:300,400,700">
	    <link rel="stylesheet" href="http://weloveiconfonts.com/api/?family=fontawesome">
	    <link rel="stylesheet" href="../../libs/css/style-personal.css">
	    <link rel="stylesheet" type="text/css" href="../../libs/css/bootstrap.min.css">
	    <script src="../../libs/js/jquery.min.js" type="text/javascript"></script>
	    <script src="../../libs/js/simplecalendar.js" type="text/javascript"></script>
		<script src="../../libs/js/bootstrap.min.js"></script>
		<style type="text/css">
            th {
                text-align: center;
                vertical-align: middle !important;
            }
        </style>
	</head>
	<body>
		<header>
			<nav class="navbar navbar-inverse">
        <div class="container">
          <a class="navbar-brand" href="../HalamanUtama/dosen.php"> Sisidang </a>
          <ul class="nav navbar-nav">
            <li class="nav-item">
              <li><a href="../mks/index.php" > Mata Kuliah Spesial</a></li>
            </li> <!--nav-item-->
            <li class="nav-item">
              <li><a href="../LihatJadwalSidang/jadwalDosen.php" >Jadwal Sidang </a></li>    
            </li> <!--nav-item-->  
            
            <li class="nav-item">
             <li class="dropdown">
                <a href="#" data-toggle="dropdown"> Jadwal Non Sidang <span class="arrow">&#9660;  </span></a>
                <ul class="dropdown-menu">
                  <li><a href="../JadwalNonSidang/lihatNonSidang.php"> Tambah Jadwal Non Sidang </a></li>
                  <li><a href="../JadwalNonSidang/daftarNonSidang.php"> Daftar Jadwal Non Sidang </a></li>
                </ul>
              </li> <!--dropdown-->
            </li><!--nav-item-->
            <li class="nav-item">
              <li><a href="../IzinMajuSidang/admin.php">Izin Maju Sidang</a></li>
            </li><!--nav-item-->
            <li class="nav-item">
              <li><a href="../Logout/logout.php">Logout</a></li>
            </li><!--nav-item-->           
          </ul>
        </div>
      </nav>
		</header>
		<div class="container" style="max-width: 70vw;">
			<div class="content col-md-12" style="margin-top: 10px">
				<div class="calendar col-md-4">
					<div class="calendar hidden-print">
	                    <header>
	                        <h2 class="month"></h2>
	                        <a class="btn-prev fontawesome-angle-left" href="#"></a>
	                        <a class="btn-next fontawesome-angle-right" href="#"></a>
	                    </header>
	                    <table>
	                        <thead class="event-days">
	                            <tr></tr>
	                        </thead>
	                        <tbody class="event-calendar">
	                            <tr class="1"></tr>
	                            <tr class="2"></tr>
	                            <tr class="3"></tr>
	                            <tr class="4"></tr>
	                            <tr class="5"></tr>
	                        </tbody>
	                    </table>
	                    <div class="list">
	                    </div>
	                </div>
				</div>
				<div class="info col-md-8">
					<div class="table-responsive">
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr></tr>
                                    <th>Tanggal</th>
                                    <th>Jenis Sidang</th>
                                    <th>Judul</th>
                                    <th>Mahasiswa</th>
                                    <th>Waktu dan Lokasi</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            		$data = getInfoSidang();
                            		while($row = pg_fetch_row($data)) {
                            			$date = date_format(date_create($row[0]), "d F Y");
                            			$waktu = substr($row[4], 0, 5) . " - " . substr($row[5], 0, 5);
                            			echo "<tr>
                            					<td>$date</td>
                            					<td>$row[1]</td>
                            					<td>$row[2]</td>
                            					<td>$row[3]</td>
                            					<td>$waktu <br> $row[6]</td>
                            				</tr>";
                            		}
                            	?>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
		</div>
	</body>
</html>