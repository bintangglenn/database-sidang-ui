<?php
  session_start();
  $user='';
  if(!isset($_SESSION["userlogin"])){
    $nav = '<li><a href="../Login/login.php">Login</a></li>';
  }else{
    $nav = '<li><a href="../Logout/logout.php">Logout</a></li>';
  }

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisidang - Mahasiswa</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="../../libs/jquery.min.js"> </script>
	    <script src="../../libs/bootstrap.min.js"></script>
	    <link rel="stylesheet" type="text/css" href="../../libs/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container" style="max-width: 70vw;">
			<div class="menuBar col-md-12" style="margin-top: 2vh; border-bottom: 2px solid lightgrey;">
				<h3 class="col-md-5" style="margin-top: 10px;">Mahasiswa</h3>
				<form action="mahasiswa.php" method="post" style="float: right; margin: 5px;">
					<input type="hidden" id="logout-command" name="command" value="logout">
					<button type="submit" class="btn btn-danger">Logout</button>
				</form>
				<form action="mahasiswa.php" method="post" style="float: right; margin: 5px;">
					<input type="hidden" id="tambahMKS-command" name="command" value="tambahMKS">
					<button type="submit" class="btn btn-info">Tambah Peserta MKS</button>
				</form>
				<form action="mahasiswa.php" method="post" style="float: right; margin: 5px;">
					<input type="hidden" id=" lihatSidang-command" name="command" value="lihatSidang">
					<button type="submit" class="btn btn-info">Lihat Jadwal Sidang</button>
				</form>
			</div>
			<div class="col-md-4" style="margin-top: 3vh;padding-right:0px;">
				<h2>NPM</h2>
				<h2>Nama</h2>
				<h2>Username</h2>
				<h2>Email</h2>
				<h2>Email Alternatif</h2>
				<h2>Telepon</h2>
				<h2>Nomor Telepon</h2>
			</div>
			<div class="col-md-8" style="margin-top: 3vh;padding-left:0px;">
				<h2>1506690264</h2>
				<h2>Andi</h2>
				<h2>andi</h2>
				<h2>andi@univ.ac.id</h2>
				<h2>andi@mailmail.com</h2>
				<h2>021727273</h2>
				<h2>080987777712</h2>
			</div>
		</div>
	</body>
</html>