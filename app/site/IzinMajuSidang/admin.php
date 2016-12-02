<?php
  session_start();
  $user='';
  if(!isset($_SESSION["userlogin"])){
    //header("Location: ../Login/index.php");
  }else{
    
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
                      <table id="mkstable" class="table table-inverse">
                          <thead>
                              <tr>
                                  <th> Mahasiswa </th>
                                  <th> Jenis Sidang </th>
                                  <th> Judul </th>
                                  <th> Waktu dan Lokasi </th>
                                  <th> Dosen Pembimbing </th>
                                  <th> Izinkan Maju Sidang </th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <th> Andi  </th>
                                  <th> Skripsi (sebagai pembimbing)</th>
                                  <th> Green ICT </th>
                                  <th> 17 Nov 2016 09:00 – 10:30 ruang 2.2301 </th>
                                  <th> Alief, Ani </th>
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