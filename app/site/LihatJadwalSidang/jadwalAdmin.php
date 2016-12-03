<?php session_start();
  function connectDB() {
   $conn = pg_connect('host=localhost port=5432 dbname=postgres user=postgres password=theinvoker');
    
    if (!$conn) {
      die("Connection failed");
    }
    return $conn;
  }

  function selectAll() {
    $conn = connectDB();
    
    $sql = "SELECT m.nama, j.NamaMKS, mks.judul, js.tanggal, js.jamMulai, js.jamSelesai, r.namaRuangan, mks.idMKS FROM jenismks AS j, mahasiswa AS m, mata_kuliah_spesial AS mks, jadwal_sidang AS js, ruangan AS r WHERE j.ID = mks.IdJenisMKS AND m.npm = mks.NPM AND r.idRuangan = js.idRuangan AND js.idmks = mks.IdMKS AND mks.IsSiapSidang = true ORDER BY m.nama";
    
    if(!$result = pg_query($conn, $sql)) {
      die("Error: $sql");
    }
    pg_close($conn);
    return $result;
  }

  function selectDosenPenguji($idMKS) {
    $conn = connectDB();

    $sql = "SELECT d.nama FROM dosen_penguji AS du, dosen AS d, mata_kuliah_spesial AS mks WHERE d.NIP = du.nipdosenpenguji AND du.IDMKS = mks.IdMKS AND mks.idMKS = $idMKS";

    if(!$result = pg_query($conn, $sql)) {
      die("Error: $sql");
    }
    pg_close($conn);
    return $result; 
  }

  function selectDosenPembimbing($idMKS) {
    $conn = connectDB();

    $sql = "SELECT d.nama FROM dosen_pembimbing AS dp, dosen AS d, mata_kuliah_spesial AS mks WHERE d.NIP = dp.nipdosenpembimbing AND dp.IDMKS = mks.IdMKS AND mks.idMKS = $idMKS";

    if(!$result = pg_query($conn, $sql)) {
      die("Error: $sql");
    }
    pg_close($conn);
    return $result; 
  }

  function getStatus($idMKS) {
    $conn = connectDB();

    $sql = "SELECT mks.PengumpulanHardCopy, mks.IjinMajuSidang FROM mata_kuliah_spesial AS mks WHERE mks.idmks = $idMKS";

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
                header("Location: ../Login/index.php");
            }
    } else if($_POST['command'] === 'tambahSidang') {
      header("Location: ../JadwalSidang/create.php");
    }
  }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisidang - Lihat Jadwal (Admin)</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../../libs/css/bootstrap.min.css">
		<script src="../../libs/js/jquery.min.js"></script>
		<script src="../../libs/js/bootstrap.min.js"></script>
		<style type="text/css">
            body {
              margin-bottom: 5vh;
            }

            th {
                text-align: center;
                vertical-align: middle !important;
            }

            tbody > tr {
              display: none;
            }

            .active {
              display: table-row !important;
            }

            #prev {
              float: left;
            }

            #next {
              float: right;
            }
        </style>
	</head>
	<body>
		<div class="container" style="max-width: 80vw;">
			<div class="menuBar col-md-12" style="margin-top: 2vh; border-bottom: 2px solid lightgrey;">
				<h3 class="col-md-1" style="margin-top: 10px;">Admin</h3>
				<?php
					if(isset($_SESSION['loggedUser'])) {
						echo "<form action=\"jadwalAdmin.php\" method=\"post\" style=\"float: right; margin: 5px;\">
							<input type=\"hidden\" id=\"logout-command\" name=\"command\" value=\"logout\">
							<button type=\"submit\" class=\"btn btn-danger\">Logout</button>
							</form>
							<form action=\"jadwalAdmin.php\" method=\"post\" style=\"float: right; margin: 5px;\">
							<input type=\"hidden\" id=\"tambahSidang-command\" name=\"command\" value=\"tambahSidang\">
							<button type=\"submit\" class=\"btn btn-info\">Tambah</button>
							</form>
						";
					}
				?>
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
							<?php 
								$list = selectAll();
								$idx = 0;
								$page = 0;
								while($row = pg_fetch_row($list)) {
									$page = floor($idx / 10) + 1;
									$date = date_format(date_create($row[3]), "d F Y");
									if($idx < 10) {
										echo "<tr class='active page$page'>"; 
									}
									else {
										echo "<tr class='page$page'>";
									}
									echo "<td>$row[0]</td>
										<td>$row[1]</td>
										<td>$row[2]</td>
										<td>$date <br>
										"; 
									echo substr($row[4], 0, 5) . " - " . substr($row[5], 0, 5);
									echo "<br> $row[6]</td>
									    <td><ul>";
									$data = selectDosenPembimbing($row[7]);
									while($dp = pg_fetch_row($data)) {
										echo "<li>$dp[0]</li>";
									}
									echo "</ul></td><td><ul>";
									$data = selectDosenPenguji($row[7]);
									while($du = pg_fetch_row($data)) {
										echo "<li>$du[0]</li>";
									}
									echo "</ul></td>
										<td class=\"action\">
											<form action=\"../JadwalSidang/edit.php\" method=\"post\">
												<input type=\"hidden\" id=\"edit-command\" name=\"command\" value=\"edit\">
										    	<button type=\"submit\" class=\"btn btn-info\">Edit</button>
										    </form>
										</td></tr>
										";
									$idx++;
								}
								echo "<p id='pageNum' style='display: none;'>1</p>
								  <p id='maxPage' style='display: none;'>$page</p>";
							?>
						</tbody>
					</table>
				</div>
				<button id="prev" class="btn btn-info">Prev</button>
				<button id="next" class="btn btn-info">Next</button>
			</div>
		</div>
		<script>
			$('#prev').click(function() {
				var pageNum = parseInt($('#pageNum').html());
				var thisPage = '.page' + pageNum;
				var prevPage = '.page' + (pageNum - 1);
				if((pageNum - 1) > 0) {
					$(thisPage).removeClass('active');
					$(prevPage).addClass('active');
					$('#pageNum').html(pageNum - 1);
				}
			});
			$('#next').click(function() {
				var pageNum = parseInt($('#pageNum').html());
				var maxPage = $('#maxPage').html();
				var thisPage = '.page' + pageNum;
				var nextPage = '.page' + (pageNum + 1);
				if(pageNum < maxPage) {
					$(thisPage).removeClass('active');
					$(nextPage).addClass('active');
					$('#pageNum').html(pageNum + 1);
				}
			});
		</script>
	</body>
</html>