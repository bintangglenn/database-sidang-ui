<?php session_start();
    function connectDB() {
       $conn = pg_connect('host=localhost port=5432 dbname=postgres user=postgres password=2456298.5');
       
        if (!$conn) {
            die("Connection failed");
        }
        return $conn;
    }

    function selectAllFromDosen() {
        $conn = connectDB();

        $nip = $_SESSION['loggedNIP'];
        $sql = "SELECT * FROM dosen WHERE nip = $nip";
        
        if(!$result = pg_query($conn, $sql)) {
            die("Error: $sql");
        }
        pg_close($conn);
        return $result;
    }

    function getInfoSidang() {
        $conn = connectDB();

        $nip = $_SESSION['loggedNIP'];

        $sql = "SELECT m.nama, j.NamaMKS, mks.Judul, js.tanggal, js.jamMulai, js.jamSelesai, r.namaRuangan, mks.IjinMajuSidang, mks.PengumpulanHardCopy, mks.idMKS
                FROM jadwal_sidang AS js, mata_kuliah_spesial AS mks, ruangan AS r, jenismks AS j, mahasiswa AS m
                WHERE EXISTS (
                    SELECT 1 FROM dosen_pembimbing AS db, dosen_penguji AS du
                    WHERE js.idmks = du.idmks AND js.idmks = db.IDMKS AND
                    (du.nipdosenpenguji = $nip OR db.NIPdosenpembimbing = $nip))
                    AND r.idRuangan = js.idRuangan AND js.idmks = mks.IdMKS AND j.ID = mks.IdJenisMKS AND m.npm = mks.NPM
                ORDER BY js.tanggal, js.jamMulai";
        
        if(!$result = pg_query($conn, $sql)) {
            die("Error: $sql");
        }
        pg_close($conn);
        return $result;
    }

    function getRole($idMKS) {
        $conn = connectDB();

        $nip = $_SESSION['loggedNIP'];

        $sql = "SELECT 1 FROM dosen_pembimbing WHERE NIPdosenpembimbing = $nip AND IDMKS = $idMKS";
        
        if(!$result = pg_query($conn, $sql)) {
            die("Error: $sql");
        }
        pg_close($conn);
        
        $row = pg_fetch_row($result);
        if($row[0] == true) {
            return "Pembimbing";
        } else {
            return "Penguji";
        }
    }

    function getStatus($izinMaju, $hardcopy) {
        $hasil = "<ul>";
        if($izinMaju == true) {
            $hasil .= "<li>Izin Maju Sidang</li>";
        }
        if($hardcopy == true) {
            $hasil .= "<li>Kumpul Hardcopy</li>";
        }
        $hasil .= "</ul>";
        return $hasil;
    }

    function selectDosenPenguji($idMKS) {
        $conn = connectDB();

        $nip = $_SESSION['loggedNIP'];
        $sql = "SELECT d.nama FROM dosen_penguji AS du, dosen AS d, mata_kuliah_spesial AS mks WHERE d.NIP = du.nipdosenpenguji AND du.IDMKS = mks.IdMKS AND mks.idMKS = $idMKS AND d.nama NOT IN (SELECT nama FROM dosen WHERE NIP = $nip)";

        if(!$result = pg_query($conn, $sql)) {
          die("Error: $sql");
        }
        pg_close($conn);
        return $result; 
    }

    function selectDosenPembimbing($idMKS) {
        $conn = connectDB();

        $nip = $_SESSION['loggedNIP'];
        $sql = "SELECT d.nama FROM dosen_pembimbing AS dp, dosen AS d, mata_kuliah_spesial AS mks WHERE d.NIP = dp.nipdosenpembimbing AND dp.IDMKS = mks.IdMKS AND mks.idMKS = $idMKS AND d.nama NOT IN (SELECT nama FROM dosen WHERE NIP = $nip)";

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
		<title>Sisidang - Lihat Jadwal (Dosen)</title>
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
        <header>
            <nav class="navbar navbar-inverse">
                <div class="container">
                    <a class="navbar-brand" href="../HalamanUtama/dosen.php"> Sisidang </a>
                    <ul class="nav navbar-nav">
                        <li class="nav-item">
                            <li><a href="../Logout/logout.php">Logout</a></li>
                        </li><!--nav-item-->           
                    </ul>
                </div>
            </nav>
        </header>
		<div class="container" style="max-width: 80vw;">
			<div class="daftarMahasiswa col-md-12" style="margin-top: 10px;">
				<div class="table-responsive">
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Jenis Sidang</th>
                                <th>Judul</th>
                                <th>Waktu dan Lokasi</th>
                                <th>Pembimbing Lain</th>
                                <th>Penguji Lain</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $idx = 0;
                                $page = 0;
                                $data = getInfoSidang();
                                while($row = pg_fetch_row($data)) {
                                    $page = floor($idx / 10) + 1;
                                    $date = date_format(date_create($row[3]), "d F Y");
                                    $waktu = substr($row[4], 0, 5) . " - " . substr($row[5], 0, 5);
                                    $status = getStatus($row[7], $row[8]);
                                    $role = getRole($row[9]);
                                    if($idx < 10) {
                                        echo "<tr class='active page$page'>";   
                                    }
                                    else {
                                        echo "<tr class='page$page'>";
                                    }
                                    echo "<td>$row[0]</td>
                                        <td>$row[1]<br><br>Sebagai: $role</td>
                                        <td>$row[2]</td>
                                        <td>$date<br>$waktu<br>$row[6]</td>
                                        <td><ul>";
                                    $dosTerkait = selectDosenPembimbing($row[9]);
                                    while($dp = pg_fetch_row($dosTerkait)) {
                                        echo "<li>$dp[0]</li>";
                                    }
                                    echo "</ul></td><td><ul>";

                                    $dosTerkait = selectDosenPenguji($row[9]);
                                    while($du = pg_fetch_row($dosTerkait)) {
                                        echo "<li>$du[0]</li>";
                                    }
                                    echo "</ul></td>
                                            <td>$status</td>
                                        </tr>";
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