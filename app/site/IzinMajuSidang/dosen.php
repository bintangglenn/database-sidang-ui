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
        $sql = "SELECT * FROM SISIDANG.dosen WHERE nip = $nip";
        
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
  <title>Izin Jadwal Sidang (Dosen)</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="../../libs/jquery.min.js" type="text/javascript"></script>
  <script src="../../src/js/generator.js" type="text/javascript"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-inverse">
        <div class="container">
          <a class="navbar-brand" href="../HalamanUtama/dosen.php"> Sisidang </a>
          <ul class="nav navbar-nav">
            <li class="nav-item">
              <li><a href="../mks/index.php" > Mata Kuliah Spesial</a></li>
            </li> <!--nav-item-->
            <li class="nav-item">
              <li><a href="../LihatJadwalSidang/jadwalDosen.php" >Jadwal Sidang </a></li>    
            </li> <!--nav-item-->  
            <li class="nav-item">
              <li><a href="../JadwalNonSidang/dosen.php">Jadwal Non Sidang</a></li>
            </li><!--nav-item-->
            <li class="nav-item">
              <li><a href="../Logout/logout.php">Logout</a></li>
            </li><!--nav-item-->           
          </ul>
        </div>
      </nav>
  <div class="container">
      <div class="row">
          <div class="col-lg-12">
              <div class="panel">
                  <div class="panel-header">
                        <h2> Izin Jadwal Sidang </h2>
                        <h6>khusus dosen</h6>
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
                      <table id="mkstable" class="table table-inverse">
                          <thead>
                              <tr>
                                  <th> Mahasiswa </th>
                                  <th> Jenis Sidang </th>
                                  <th> Judul </th>
                                  <th> Waktu dan Lokasi </th>
                                  <th> Pembimbing Lain </th>
                                  <th> Izinkan Maju Sidang </th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <th> Andi </th>
                                  <th> Skripsi (sebagai pembimbing) </th>
                                  <th> Green ICT </th>
                                  <th> 17 Nov 2016 09:00 – 10:30 ruang 2.2301</th>
                                  <th> Alief </th>
                                  <th> Izinkan </th>
                              </tr>
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