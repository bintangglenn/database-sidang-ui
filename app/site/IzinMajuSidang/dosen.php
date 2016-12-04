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
    
    $sql = "SELECT m.nama, j.NamaMKS, mks.judul, js.tanggal, js.jamMulai, js.jamSelesai, r.namaRuangan, mks.idMKS FROM SISIDANG.jenismks AS j, SISIDANG.mahasiswa AS m, SISIDANG.mata_kuliah_spesial AS mks, SISIDANG.jadwal_sidang AS js, SISIDANG.ruangan AS r WHERE j.ID = mks.IdJenisMKS AND m.npm = mks.NPM AND r.idRuangan = js.idRuangan AND js.idmks = mks.IdMKS AND mks.IsSiapSidang = true ORDER BY m.nama";
    
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

  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Izin Jadwal Sidang (Admin)</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="../../libs/js/jquery.min.js" type="text/javascript"></script>
  <script src="../../libs/js/bootstrap.min.js"></script>
  <script src="../../src/js/generator.js" type="text/javascript"></script>
  <link rel="stylesheet" href="../../libs/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
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
              <li><a href="../IzinMajuSidang/admin.php">IzinkanJadwal Sidang</a></li>
            </li><!--nav-item-->
            <li class="nav-item">
              <li><a href="../Logout/logout.php">Logout</a></li>
            </li><!--nav-item-->           
          </ul>
        </div>
      </nav>
</header>
  <div class="container">
      <div class="row">
          <div class="col-lg-12">
              <div class="panel">
                  <div class="panel-header">
                        <h2> Izin Jadwal Sidang </h2>
                        <div class="pull-left">
                            <div class="pagination">
                                <div class="input-group">
                                    <label for="pagination">
                                        Page
                                    </label>
                                </div>
                                <select id="pagination">
                                </select>
                            </div>
                        </div>
                        <div class="pull-right">
                            <div class="input-group">
                                <label for="showperpage"> Show </label>
                                <select id="showperpage" name="showperpage">
                                    <option value="10"> 10 </option>
                                    <option value="20"> 20 </option>
                                    <option value="50"> 50 </option>
                                </select>
                            </div>
                        </div>
                  </div>
                  <div class="panel-content">
                      <table class="table table-condensed table-bordered">
            <thead>
              <tr>
                <th>Mahasiswa</th>
                <th>Jenis Sidang</th>
                <th>Judul</th>
                <th>Waktu dan Lokasi</th>
                <th>Dosen Pembimbing</th>
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
                  
                  echo "</ul></td>
                    <td class=\"action\">
                      <form action=\"../LihatJadwalSidang/jadwalAdmin.php\" method=\"post\">
                        <input type=\"hidden\" id=\"izin-command\" name=\"command\" value=\"izin\">
                          <button type=\"submit\" class=\"btn btn-info\">izinkan</button>
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
              </div>

          </div>
      </div>
  </div>

  <script>
    var currentPage = 0;
    var totalPage = 0;

      function getMks (data) {
          $.ajax({
              url : "../../request/request.php",
              dataType : "JSON",
              data : data,
              method : "GET",
              success : function (response) {
                  var table = $("#mkstable");
                  var thead = table.find("thead");
                  var tbody = table.find("tbody");
                  console.log("get mks success", response);
                  tbody.empty();
                  totalPage = response.data.total;
                  $.each(response.data.mkslist, function(i, item){
                      var mksItem = "<tr>";
                          mksItem += "<td>" + item['idmks'] + "</td>";
                          mksItem += "<td>" + item['judul'] + "</td>";
                          mksItem += "<td>" + item['nama'] + "</td>";
                          mksItem += "<td>" + item['tahun'] + "\n" + ((item['semester'] == 1) ? ("Gasal" + "</td>") : (item['semester'] == 2) ? "Genap" : "Pendek") + "</td>";
                          mksItem += "<td>" + item['jenis'] + "</td>";
                          mksItem += "<td><ul>" +
                              ((item['ijinmajusidang'] != null) ? "<li> maju sidang </li> " : "") +
                              ((item['pengumpulanhardcopy'] != null) ? "<li> kumpul hardcopy </li>" : "") +
                              ((item['issiapsidang'] != null) ? "<li> siap sidang </li>": "") +
                          "</ul></td>";
                      mksItem += "</tr>";
                      tbody.append(mksItem);
                  });
              },
              error : function (err) {
                  console.log("get mks error", err.responseText);
              }
          });
      }
      $.when(getMks({action : "GET_MKS", skip : 0, take : 10, sort : ""})).then(function(){
          console.log("load done", totalPage);
          for (var i = 1; i <= totalPage; i++) {
              console.log("append");
              var page = '<option value="' + i + '">' + i + '</option>';
              pagination.append(page);
          }
      });
    var pagination = $("#pagination");
    pagination.change(function(){
        currentPage = $(this).val();
        showperpage = $("#showperpage").val();
        var data = {
            action : "GET_MKS",
            skip : currentPage * showperpage,
            take : showperpage,
            sort : ""
        };

        getMks(data);
    });

    $("#showperpage").change(function(){
            currentPage = pagination.val();
            showperpage = $(this).val();
            var data = {
                action : "GET_MKS",
                skip : currentPage * showperpage,
                take : showperpage,
                sort : ""
            };
            getMks(data);
    });

  </script>
</body>