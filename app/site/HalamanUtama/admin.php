<?php session_start();
  function connectDB() {
    $conn = pg_connect('host=localhost port=5432 dbname=postgres user=postgres password=2456298.5');
    
    if (!$conn) {
      die("Connection failed");
    }
    return $conn;
  }

  function selectAll() {
    $conn = connectDB();
    
    $sql = "SELECT j.NamaMKS, m.nama, mks.judul, js.tanggal, js.jamMulai, js.jamSelesai, r.namaRuangan, mks.idMKS FROM SISIDANG.JENISMKS AS j, SISIDANG.MAHASISWA AS m, SISIDANG.MATA_KULIAH_SPESIAL AS mks, SISIDANG.JADWAL_SIDANG AS js, SISIDANG.RUANGAN AS r WHERE j.ID = mks.IdJenisMKS AND m.npm = mks.NPM AND r.idRuangan = js.idRuangan AND js.idmks = mks.IdMKS AND mks.IsSiapSidang = true ORDER BY js.tanggal";
    
    if(!$result = pg_query($conn, $sql)) {
      die("Error: $sql");
    }
    pg_close($conn);
    return $result;
  }

  function selectDosenPenguji($idMKS) {
      $conn = connectDB();

      $sql = "SELECT d.nama FROM SISIDANG.DOSEN_PENGUJI AS du, SISIDANG.DOSEN AS d, SISIDANG.MATA_KULIAH_SPESIAL AS mks WHERE d.NIP = du.nipdosenpenguji AND du.IdMKS = mks.IdMKS AND mks.idMKS = $idMKS";

      if(!$result = pg_query($conn, $sql)) {
        die("Error: $sql");
      }
      pg_close($conn);
      return $result; 
  }

  function selectDosenPembimbing($idMKS) {
      $conn = connectDB();

      $sql = "SELECT d.nama FROM SISIDANG.dosen_pembimbing AS dp, SISIDANG.dosen AS d, SISIDANG.mata_kuliah_spesial AS mks WHERE d.NIP = dp.nipdosenpembimbing AND dp.IDMKS = mks.IdMKS AND mks.idMKS = $idMKS";

      if(!$result = pg_query($conn, $sql)) {
        die("Error: $sql");
      }
      pg_close($conn);
      return $result; 
  }

  function selectFromJenis($term, $jenis) {
    $conn = connectDB();

      $sql = "SELECT j.NamaMKS, m.nama, mks.judul, js.tanggal, js.jamMulai, js.jamSelesai, r.namaRuangan, mks.idMKS
          FROM SISIDANG.jenismks AS j, SISIDANG.mahasiswa AS m, SISIDANG.mata_kuliah_spesial AS mks, SISIDANG.jadwal_sidang AS js, SISIDANG.ruangan AS r
          WHERE j.ID = mks.IdJenisMKS AND m.npm = mks.NPM AND r.idRuangan = js.idRuangan AND js.idmks = mks.IdMKS AND mks.Semester = $term AND mks.IdJenisMKS = $jenis AND mks.IsSiapSidang = true";

      if(!$result = pg_query($conn, $sql)) {
        die("Error: $sql");
      }
      pg_close($conn);

    $idx = 0;
    $page = 0;
        while($row = pg_fetch_row($result)) {
          $page = floor($idx / 10) + 1;
      $date = date_format(date_create($row[3]), "d F Y");
      $time = substr($row[4], 0, 5) . " - " . substr($row[5], 0, 5);
      if($idx < 10) {
        echo "<tr class='active page$page'>"; 
      }
      else {
        echo "<tr class='page$page'>";
      }
      echo "<td>$row[0]</td>
      <td>$row[1]<br><br>Judul: $row[2]</td>
      "; 
      echo "<td><ul>";
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
        <td>$date $time<br>$row[6]</td>
        <td class=\"action\">
        <form action=\"../JadwalSidang/edit.php\" method=\"post\">
          <input type=\"hidden\" id=\"edit-command\" name=\"command\" value=\"edit\">
            <button type=\"submit\" class=\"btn btn-info\">Edit</button>
        </form>
        </td>
        </tr>
      ";
      $idx++;
        }
        echo "<p id='pageNum' style='display: none;'>1</p>
          <p id='maxPage' style='display: none;'>$page</p>";
  }

  function selectFromNama($nama) {
    $conn = connectDB();

    $nama = strtolower($nama);
      $sql = "SELECT j.NamaMKS, m.nama, mks.judul, js.tanggal, js.jamMulai, js.jamSelesai, r.namaRuangan, mks.idMKS
          FROM SISIDANG.Jenismks AS j, SISIDANG.Mahasiswa AS m, SISIDANG.mata_kuliah_spesial AS mks, SISIDANG.jadwal_sidang AS js, SISIDANG.ruangan AS r
          WHERE j.ID = mks.IdJenisMKS AND m.npm = mks.NPM AND r.idRuangan = js.idRuangan AND js.idmks = mks.IdMKS AND m.nama LIKE \"%$nama%\" AND mks.IsSiapSidang = true";

      if(!$result = pg_query($conn, $sql)) {
        die("Error: $sql");
      }
      pg_close($conn);
      
      $idx = 0;
      $page = 0;
        while($row = pg_fetch_row($result)) {
          $page = floor($idx / 10) + 1;
      $date = date_format(date_create($row[3]), "d F Y");
      $time = substr($row[4], 0, 5) . " - " . substr($row[5], 0, 5);
      if($idx < 10) {
        echo "<tr class='active page$page'>"; 
      }
      else {
        echo "<tr class='page$page'>";
      }
      echo "<td>$row[0]</td>
      <td>$row[1]<br><br>Judul: $row[2]</td>
      "; 
      echo "<td><ul>";
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
        <td>$date $time<br>$row[6]</td>
        <td class=\"action\">
        <form action=\"../JadwalSidang/edit.php\" method=\"post\">
          <input type=\"hidden\" id=\"edit-command\" name=\"command\" value=\"edit\">
            <button type=\"submit\" class=\"btn btn-info\">Edit</button>
        </form>
        </td>
        </tr>
      ";
      $idx++;
        }
        echo "<p id='pageNum' style='display: none;'>1</p>
          <p id='maxPage' style='display: none;'>$page</p>";
  }

  $_SESSION['first'] = true;
  function firstInfo() {
        $list = selectAll();
        $idx = 0;
        $page = 0;
        while($row = pg_fetch_row($list)) {
          $page = floor($idx / 10) + 1;
      $date = date_format(date_create($row[3]), "d F Y");
      $time = substr($row[4], 0, 5) . " - " . substr($row[5], 0, 5);
      if($idx < 10) {
        echo "<tr class='active page$page'>"; 
      }
      else {
        echo "<tr class='page$page'>";
      }
      echo "<td>$row[0]</td>
      <td>$row[1]<br><br>Judul: $row[2]</td>
      "; 
      echo "<td><ul>";
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
          <td>$date $time<br>$row[6]</td>
          <td class=\"action\">
          <form action=\"../JadwalSidang/edit.php\" method=\"post\">
            <input type=\"hidden\" id=\"edit-command\" name=\"command\" value=\"edit\">
              <button type=\"submit\" class=\"btn btn-info\">Edit</button>
          </form>
          </td>
        </tr>
      ";
      $idx++;
        }
        echo "<p id='pageNum' style='display: none;'>1</p>
          <p id='maxPage' style='display: none;'>$page</p>";
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['command'] === 'jenisSearch') {
      $_SESSION['first'] = false;
      $_SESSION['jenisSearch'] = true;
      $_SESSION['namaSearch'] = false;
    } else if($_POST['command'] === 'namaSearch') {
      $_SESSION['first'] = false;
      $_SESSION['jenisSearch'] = false;
      $_SESSION['namaSearch'] = true;
    }
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
              </ul>
              </li> <!--dropdown-->    
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
              <li><a href="../IzinMajuSidang/admin.php">Izin Jadwal Sidang</a></li>
            </li><!--nav-item-->
            <li class="nav-item">
              <li><a href="../Logout/logout.php">Logout</a></li>
            </li><!--nav-item-->           
          </ul>
        </div>
      </nav>
    </header>
		<div class="container" style="max-width: 80vw;">
			<div class="daftarMahasiswa col-md-12" style="margin-top: 3vh;">
        <div class="search col-md-4">
          <div class="jenisSidang col-md-12"  style="border: 2px solid lightgrey;"> 
            <h3>Search - Jenis Sidang</h3>
            <form method="post" action="admin.php">
              <div class="form-group">
                <label for="term">Term</label>
                <select class="form-control" name="term" id="term">
                  <option value="1">Ganjil 2015/2016</option>
                  <option value="2">Genap 2015/2016</option>
                  <option value="3">Pendek 2015/2016</option>
                </select>
                <br>
                <label for="jenis">Jenis Sidang</label>
                <select class="form-control" name="jenis" id="jenis">
                  <option value="1">Skripsi</option>
                  <option value="2">Karya Akhir</option>
                  <option value="3">Proposal Tesis</option>
                  <option value="4">Usulan Penelitian</option>
                  <option value="5">Seminar Hasil Penelitian S3</option>
                  <option value="6">Pra Promosi</option>
                  <option value="7">Promosi</option>
                  <option value="8">Tesis</option>
                </select>
                <input type="hidden" id="jenisSearch" name="command" value="jenisSearch">
                <button class="btn btn-info" style="float: right; margin: 1vh;">Submit</button>
              </div>
            </form>
          </div>
          <div class="mahasiswa col-md-12"  style="border: 2px solid lightgrey; margin-top:20px;">
            <h3>Search - Mahasiwa</h3>
            <form action="admin.php" method="post">
              <div class="form-group">
                <label for="nama">Nama Mahasiswa</label>
                <input type="text" id="nama" name="nama" placeholder="Nama Mahasiswa">
                <input type="hidden" id="namaSearch" name="command" value="namaSearch">
                <button type="submit" class="btn btn-info" style="margin-left: 1vw;">Submit</button>
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
                    <?php 
                      if($_SESSION['first'] == true) {
                        firstInfo();
                      }
                      else if($_SESSION['jenisSearch'] == true) {
                        selectFromJenis($_POST['term'], $_POST['jenis']);
                      }
                      else if($_SESSION['namaSearch'] == true) {
                        selectFromNama($_POST['nama']);
                      }
                    ?>
                  </tbody>
              </table>
          </div>
          <button id="prev" class="btn btn-info">Prev</button>
          <button id="next" class="btn btn-info">Next</button>
        </div>
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