<?php print('<?xml version = "1.0" encoding = "utf-8"?>')?>
<?php
	$resp = "";
	session_start();
	if(isset($_POST["username"])){
		if(login($_POST["username"], $_POST["password"])  == null){
			//$resp = "login success";	
			$_SESSION["userlogin"] = $_POST["username"];
			$_SESSION["userpass"] = $_POST["password"];
			header("Location: ../HalamanUtama/admin.php");
		}else {
			$resp = login($_POST["username"], $_POST["password"]);
		}
	}
	
	function login($user, $pass){
		$servername = "localhost";
		$username = "postgres";
		$password = "2456298.5";
		$dbname = "postgres";
		
		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		
		$sql = "SELECT * FROM user WHERE username='$user'";
		$result = mysqli_query($conn, $sql);
		
		if ($result->num_rows > 0) {
			$sql = "SELECT * FROM user WHERE username='$user' AND password='$pass'";
			$result = mysqli_query($conn, $sql);
			
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
          			$_SESSION["userid"] = $row['user_id'];
    				mysqli_close($conn);
					return null;

    			}
								
			}
			return "Password Invalid";
		}
		
		mysqli_close($conn);
		return "Username Invalid";
	}

	function connectDB(){
		$servername = "localhost";
		$username = "postgres";
		$password = "2456298.5";
		$dbName = "postgres";
		
		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbName);
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		return $conn;
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
			      <input type="text" class="form-control" name="username" placeholder="Email Address" required="" autofocus="" />
			      <input type="password" class="form-control" name="password" placeholder="Password" required=""/>     
			      
			      <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>   
			    </form>
			  </div>
	</body>
</html>


