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
		<title>Sisidang - Admin</title>
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
              <?php echo $nav; ?>
           </li><!--nav-item-->
      </ul>
    </div>
  </nav>
</header>
		<div class="container" style="max-width: 80vw;">
			
			<div class="daftarMahasiswa col-md-12" style="margin-top: 10px;">
				<div class="search col-md-4">
					<div class="jenisSidang col-md-12"  style="border: 2px solid lightgrey;"> 
						<h3>Search - Jenis Sidang</h3>
						<form>
							<div class="form-group">
								<label for="term">Term</label>
								<select class="form-control" name="term" id="term">
									<option value="">Genap 2015/2016</option>
								</select>
								<br>
								<label for="jenis">Jenis Sidang</label>
								<select class="form-control" name="jenis" id="jenis">
									<option value="">Skripsi</option>
								</select>
							</div>
						</form>
					</div>
					<div class="mahasiswa col-md-12"  style="border: 2px solid lightgrey; margin-top:20px;">
						<h3>Search - Mahasiwa</h3>
						<form>
							<div class="form-group">
								<label for="nama">Nama Mahasiswa</label>
								<input type="text" id="nama" name="nama" placeholder="Nama Mahasiswa">
							</div>
						</form>
					</div>
				</div>
				<div class="hasil col-md-8">
					<div class="table-responsive">
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>Jenis Sidang</th>
                                    <th>Mahasiswa</th>
                                    <th>Dosen Pembimbing</th>
                                    <th>Dosen Penguji</th>
                                    <th>Waktu dan Lokasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="jenisSidang">
                                        Skripsi
                                    </td>
                                    <td class="mahasiswa">
                                        Andi


                                        Judul: "Green ICT"
                                    </td>
                                    <td class="pembimbing">
                                    	Ani
                                    </td>
                                    <td class="penguji">
                                    	Anto
                                    	Alief
                                    </td>
                                    <td class="waktuLokasi">
                                    	<div class="tanggal">17-Nov-16</div>
                                        <div class="waktu">09:00 - 10:30 WIB</div>
                                        <div class="lokasi">2.301</div>
                                    </td>
                                    <td class="action">
                                    	<form>
											<input type="hidden" id=" edit-command" name="command" value="edit">
											<button type="submit" class="btn btn-info">Edit</button>
										</form>
                                    </td>
                                </tr>
                                 <td class="jenisSidang">
                                        Skripsi
                                    </td>
                                    <td class="mahasiswa">
                                        Budi


                                        Judul: "Analisa Algoritma Sorting"
                                    </td>
                                    <td class="pembimbing">
                                    	Bayu
                                    </td>
                                    <td class="penguji">
                                    	Chanek
                                    	Cecep
                                    </td>
                                    <td class="waktuLokasi">
                                    	<div class="tanggal">19-Nov-16</div>
                                        <div class="waktu">15:00 - 16:30 WIB</div>
                                        <div class="lokasi">2.2502</div>
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
		</div>
	</body>
</html>