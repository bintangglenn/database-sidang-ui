<?php session_start();
	function connectDB() {
		$conn = pg_connect('host=localhost port=5432 dbname=postgres user=postgres password=2456298.5');
		
		if (!$conn) {
			die("Connection failed");
		}
		return $conn;
	}

	function selectAllFromMahasiswa() {
		$conn = connectDB();

		$npm = $_SESSION['loggedNPM'];
		$sql = "SELECT * FROM SISIDANG.mahasiswa WHERE npm = '$npm'";
		
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
		<title>Sisidang - Mahasiswa</title>
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
		<div class="container" style="max-width: 70vw;">
			<div class="menuBar col-md-12" style="margin-top: 2vh; border-bottom: 2px solid lightgrey;">
				<h3 class="col-md-5" style="margin-top: 10px;">Mahasiswa</h3>
				
			</div>
			<?php
				if(isset($_SESSION['loggedUser'])) {
					$data = selectAllFromMahasiswa();
					echo "<div class=\"col-md-4\" style=\"margin-top: 3vh;padding-right:0px;\">
						<h2>NPM</h2>
						<h2>Nama</h2>
						<h2>Username</h2>
						<h2>Email</h2>
						";
					$row = pg_fetch_row($data);
					if($row[5] !== null && $row[5] !== "") {
						echo "<h2>Email Alternatif</h2>";
					}
					if($row[6] !== null && $row[6] !== "") {
						echo "<h2>Telepon</h2>";
					}
					if($row[7] !== null && $row[7] !== "") {
						echo "<h2>Nomor Telepon</h2>";
					}

					echo "</div>
						<div class=\"col-md-8\" style=\"margin-top: 3vh;padding-left:0px;\">
						<h2>: $row[0]</h2>
						<h2>: $row[1]</h2>
						<h2>: $row[2]</h2>
						<h2>: $row[4]</h2>
						";
					if($row[5] !== null && $row[5] !== "") {
						echo "<h2>: $row[5]</h2>";
					}
					if($row[6] !== null && $row[6] !== "") {
						echo "<h2>: $row[6]</h2>";
					}
					if($row[7] !== null && $row[7] !== "") {
						echo "<h2>: $row[7]</h2>";
					}					
				}
			?>
		</div>
	</body>
</html>