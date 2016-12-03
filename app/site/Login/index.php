<?php session_start();
	function connectDB() {
		$conn = pg_connect('host=localhost port=5432 dbname=postgres user=postgres password=theinvoker');
		
		if (!$conn) {
			die("Connection failed");
		}
		return $conn;
	}

	function userLogin($user, $pass) {
		if($user === "admin" && $pass === "admin") {
			$_SESSION['loggedUser'] = "admin";
			$_SESSION['loggedRole'] = "admin";
			header("Location: ../HalamanUtama/admin.php");
		}
		else {
			$conn = connectDB();

			$sql = "SELECT NIP FROM dosen WHERE username='$user' AND password='$pass' limit 1";

			if($result = pg_query($conn, $sql)) {
				$hasil = pg_fetch_row($result);
				if($hasil[0] === "" || $hasil[0] === null) {
					$sql = "SELECT NPM FROM mahasiswa WHERE username='$user' AND password='$pass' limit 1";
					if($result = pg_query($conn, $sql)) {
						$hasil = pg_fetch_row($result);
						if($hasil[0] === "" || $hasil[0] === null) {
							$_SESSION['errMsg'] = "Username atau Password Salah";
						}
						else {
							$_SESSION['loggedUser'] = $user;
							$_SESSION['loggedRole'] = "mahasiswa";
							$_SESSION['loggedNPM'] = $hasil[0];
							header("Location:  ../HalamanUtama/mahasiswa.php");
						}
					}
				}
				else {
					$_SESSION['loggedUser'] = $user;
					$_SESSION['loggedRole'] = "dosen";
					$_SESSION['loggedNIP'] = $hasil[0];
					header("Location: ../HalamanUtama/dosen.php");
				}
			}
		}
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if($_POST['command'] === 'login') {
			userLogin($_POST['username'], $_POST['password']);
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>SISIDANG - Login</title>
		<script src="../../libs/jquery.min.js"> </script>
		<script src="../../libs/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../../libs/css/login.css" >
		<link rel="stylesheet" type="text/css" href="../../libs/css/bootstrap.min.css" >
	</head>
	<body id="bodyLogin">
		<h1>Sistem Informasi Sidang</h1>
		<div id="fullBg" />
			<div class="container">
				<form class="form-signin" action="index.php" method="POST">       
					<h1 class="form-signin-heading">Please Login</h1>
					<input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
					<input type="password" class="form-control" name="password" placeholder="Password" required=""/>
					<input type="hidden" id="login-command" name="command" value="login"/>
					<button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>   
				</form>
			</div>
			<div id="errMsg">
				<?php
					if(isset($_SESSION['errMsg'])) {
						echo "<p>" . $_SESSION['errMsg'] . "</p>";
						unset($_SESSION['errMsg']);
					}
				?>
			</div>
		</div>
	</body>
</html>


