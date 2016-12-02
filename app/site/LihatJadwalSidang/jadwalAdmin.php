<?php
  session_start();
  $user='';
  if(!isset($_SESSION["userlogin"])){
    //header("Location: ../Login/index.php");
  }else{
    $nav = '';
  }

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisidang - Lihat Jadwal (Admin)</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="../../libs/js/jquery.min.js"> </script>
    <script src="../../libs/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../libs/css/bootstrap.min.css">
	</head>
	<body>
<header>
    <nav class="navbar navbar-inverse">
      <div class="container">
        <a class="navbar-brand" href="../HalamanUtama/admin.php"> Sisidang </a>
         <ul class="nav navbar-nav">
           <li class="nav-item">
              <li class="dropdown">
                <a href="#" data-toggle="dropdown"> Mata Kuliah Spesial <span class="arrow">&#9660;  </span></a>
                <ul class="dropdown-menu">
                    <li><a href="../mks/index.php"> Lihat Daftar </a></li>
                    <li><a href="../mks/create.php"> Tambah MKS </a></li>
                </ul>
              </li> <!--dropdown-->
           </li> <!--nav-item-->
           <li class="nav-item">
              <li class="dropdown">
                <a href="#" data-toggle="dropdown">Jadwal Sidang <span class="arrow">&#9660;  </span></a>
                <ul class="dropdown-menu">
                  <li><a href="../LihatJadwalSidang/jadwalAdmin.php">Lihat Daftar</a></li>
                  <li><a href="../JadwalSidang/create.php">Buat</a></li>
                  <li><a href="../JadwalSidang/edit.php">Edit</a></li>
                </ul>
              </li> <!--dropdown-->    
           </li> <!--nav-item-->  
           <li class="nav-item">
              <li><a href="../JadwalNonSidang/admin.php">Jadwal Non Sidang</a></li>
           </li><!--nav-item-->
           <li class="nav-item">
              <li><a href="../Logout/logout.php">Logout</a></li>
           </li><!--nav-item-->
      </ul>
    </div>
  </nav>
</header>
		<div class="container" style="max-width: 80vw;">
			<div class="menuBar col-md-12" style="margin-top: 2vh; border-bottom: 2px solid lightgrey;">
				<h3 class="col-md-1" style="margin-top: 10px;">Admin</h3>
				<form style="float: right; margin: 5px;">
					<input type="hidden" id="logout-command" name="command" value="logout">
					<button type="submit" class="btn btn-danger">Logout</button>
				</form>
				<form style="float: right; margin: 5px;">
					<input type="hidden" id="tambah-command" name="command" value="tambah">
					<button type="submit" class="btn btn-info">Tambah</button>
				</form>
			</div>
			<div class="daftarMahasiswa col-md-12" style="margin-top: 10px;">
				<div class="table-responsive">
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Jenis Sidang</th>
                                <th>Judul</th>
                                <th>Waktu dan Lokasi</th>
                                <th>Dosen Pembimbing</th>
                                <th>Dosen Penguji</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="mahasiswa">
                                    Andi
                                </td>
                                <td class="jenisSidang">
                                    Skripsi
                                </td>
                                <td class="judul">
                                  	Green ICT
                                </td>
                                 <td class="waktuLokasi">
                                  	<div class="tanggal">17-Nov-16</div>
                                    <div class="waktu">09:00 - 10:30 WIB</div>
                                    <div class="lokasi">2.301</div>
                                </td>
                                <td class="pembimbing">
                                  	<ul>
                                  		<li>Ani</li>
                                  	</ul>
                                </td>
                                <td class="penguji">
                                	<ul>
                                  		<li>Anto</li>
                                  		<li>Alief</li>
                                  	</ul>
                                </td>
                                <td class="action">
                                  	<form>
										<input type="hidden" id=" edit-command" name="command" value="edit">
										<button type="submit" class="btn btn-info">Edit</button>
									</form>
                                </td>
                            </tr>
                            <tr>
                                <td class="mahasiswa">
                                    Budi
                                </td>
                                <td class="jenisSidang">
                                    Skripsi
                                </td>
                                <td class="judul">
                                  	Analisa Algoritma Sorting
                                </td>
                                <td class="waktuLokasi">
                                  	<div class="tanggal">19-Nov-16</div>
                                    <div class="waktu">15:00 - 16:30 WIB</div>
                                    <div class="lokasi">2.2502</div>
                                </td>
                                <td class="pembimbing">
                                  	<ul>
                                  		<li>Bayu</li>
                                  	</ul>
                                </td>
                                <td class="penguji">
                                	<ul>
                                  		<li>Chanek</li>
                                  		<li>Cecep</li>
                                  	</ul>
                                </td>
                                <td class="action">
                                  	<form>
										<input type="hidden" id=" edit-command" name="command" value="edit">
										<button type="submit" class="btn btn-info">Edit</button>
									</form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <form style="float:left;">
					<input type="hidden" id=" prev-command" name="command" value="prev">
					<button type="submit" class="btn btn-info">Prev</button>
				</form>
				<form style="float:right;">
					<input type="hidden" id=" next-command" name="command" value="next">
					<button type="submit" class="btn btn-info">Next</button>
				</form>
			</div>
		</div>
	</body>
</html>