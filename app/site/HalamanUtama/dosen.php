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
		<title>Sisidang - Dosen</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="../../libs/jquery.min.js"> </script>
        <script src="../../libs/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../../libs/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container" style="max-width: 70vw;">
			<div class="menuBar col-md-12" style="margin-top: 2vh; border-bottom: 2px solid lightgrey;">
				<h3 class="col-md-1" style="margin-top: 10px;">Dosen</h3>
				<form action="dosen.php" method="post" style="float: right; margin: 5px;">
					<input type="hidden" id="logout-command" name="command" value="logout">
					<button type="submit" class="btn btn-danger">Logout</button>
				</form>
				<form action="dosen.php" method="post" style="float: right; margin: 5px;">
					<input type="hidden" id="tambahMKS-command" name="command" value="tambahMKS">
					<button type="submit" class="btn btn-info">Tambah Peserta MKS</button>
				</form>
				<form action="dosen.php" method="post" style="float: right; margin: 5px;">
					<input type="hidden" id=" lihatSidang-command" name="command" value="lihatSidang">
					<button type="submit" class="btn btn-info">Lihat Jadwal Sidang</button>
				</form>
				<form action="dosen.php" method="post" style="float: right; margin: 5px;">
					<input type="hidden" id=" nonSidang-command" name="command" value="nonSidang">
					<button type="submit" class="btn btn-info">Buat Jadwal Non-Sidang</button>
				</form>
				<form action="dosen.php" method="post" style="float: right; margin: 5px;">
					<input type="hidden" id=" lihatMKS-command" name="command" value="lihatMKS">
					<button type="submit" class="btn btn-info">Lihat Daftar MKS</button>
				</form>
			</div>
			<div class="content col-md-12" style="margin-top: 10px">
				<div class="calendar col-md-4">
					<table class="table-condensed table-bordered table-striped">
                    <thead>
                        <tr>
                            <th colspan="7">
                                <span class="btn-group">
                           
                        	<p style="margin-left: 48px;">Februari 2012</p>
                        	
                        </span>
                            </th>
                        </tr>
                        <tr>
                            <th>Su</th>
                            <th>Mo</th>
                            <th>Tu</th>
                            <th>We</th>
                            <th>Th</th>
                            <th>Fr</th>
                            <th>Sa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="muted">29</td>
                            <td class="muted">30</td>
                            <td class="muted">31</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                            <td>11</td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>13</td>
                            <td class="btn-primary"><strong>14</strong></td>
                            <td>15</td>
                            <td>16</td>
                            <td>17</td>
                            <td>18</td>
                        </tr>
                        <tr>
                            <td>19</td>
                            <td class="btn-primary"><strong>20</strong></td>
                            <td>21</td>
                            <td>22</td>
                            <td>23</td>
                            <td>24</td>
                            <td>25</td>
                        </tr>
                        <tr>
                            <td>26</td>
                            <td>27</td>
                            <td>28</td>
                            <td>29</td>
                            <td class="muted">1</td>
                            <td class="muted">2</td>
                            <td class="muted">3</td>
                        </tr>
                    </tbody>
                </table>
				</div>
				<div class="info col-md-8">
					<div class="table-responsive">
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis Sidang</th>
                                    <th>Judul</th>
                                    <th>Mahasiswa</th>
                                    <th>Waktu dan Lokasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="tanggal" class="active" rowspan="2">
                                        <div class="dayofmonth">14</div>
                                        <div class="shortdate">Februari 2012,</div>
                                        <div class="dayofweek">Selasa</div>
                                    </td>
                                    <td class="jenisSidang">
                                        Skripsi
                                    </td>
                                    <td class="judul">
                                        Green ICT
                                    </td>
                                    <td class="mahasiswa">
                                        Andi
                                    </td>
                                    <td class="waktuLokasi">
                                        <div class="waktu">09:00 - 10:30 WIB</div>
                                        <div class="lokasi">2.2301</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="jenisSidang">
                                        Skripsi
                                    </td>
                                    <td class="judul">
                                        Analisa Algoritma Sorting
                                    </td>
                                    <td class="mahasiswa">
                                        Budi
                                    </td>
                                    <td class="waktuLokasi">
                                        <div class="waktu">15:00 - 16:30 WIB</div>
                                        <div class="lokasi">2.2502</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tanggal" class="active" rowspan="1">
                                        <div class="dayofmonth">20</div>
                                        <div class="shortdate">Februari 2012,</div>
                                        <div class="dayofweek">Senin</div>
                                    </td>
                                    <td class="jenisSidang">
                                        Skripsi
                                    </td>
                                    <td class="judul">
                                        Adaptive Stack Implementation
                                    </td>
                                    <td class="mahasiswa">
                                        Chanek
                                    </td>
                                    <td class="waktuLokasi">
                                        <div class="waktu">10:00 - 11:30 WIB</div>
                                        <div class="lokasi">2.2302</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
		</div>
	</body>
</html>