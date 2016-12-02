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
<html lang="en">
<head>
    <title>Tutorial 8</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../../libs/js/jquery.min.js" type="text/javascript"></script>
    <script src="../../libs/js/bootstrap.min.js"></script>
    <script src="../../src/js/generator.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../../libs/css/reset.css">
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
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h2> Mata Kuliah Spesial </h2>
                            <a class="btn btn-primary" href="create.html"> Tambah MKS </a>
                        </div>
                        <div class="pull-right">
                            <div class="input-group">
                                <span> Show </span>
                                <select id="showperpage" class="form-control" name="showperpage">
                                    <option value="10"> 10 </option>
                                    <option value="20"> 20 </option>
                                    <option value="50"> 50 </option>
                                </select>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="panel-body">
                        <table id="mkstable" class="table table-inverse">
                            <thead>
                                <tr>
                                    <th> ID </th>
                                    <th colspan="1"> Judul </th>
                                    <th> Mahasiswa </th>
                                    <th> Term </th>
                                    <th> Jenis MKS </th>
                                    <th> STATUS </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="text-center">
                            <div class="pagination">
                                <span> Page </span>
                                <select style="display:inline-block;width:auto" id="pagination" class="form-control">
                          </select>
                                <span id="pageNum"></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        var currentPage = 3;
        var totalPage = 0;

        function getMks(data) {
            $.ajax({
                url: "../../request/request.php",
                dataType: "JSON",
                data: data,
                method: "GET",
                success: function(response) {
                    var table = $("#mkstable");
                    var thead = table.find("thead");
                    var tbody = table.find("tbody");
                    console.log("get mks success", response);
                    tbody.empty();
                    totalPage = Math.floor(response.data.total);
                    $("#pageNum").html("of " + totalPage);
                    $.each(response.data.mkslist, function(i, item) {
                        var mksItem = "<tr>";
                        mksItem += "<td>" + item['idmks'] + "</td>";
                        mksItem += "<td colspan='1'>" + item['judul'] + "</td>";
                        mksItem += "<td>" + item['nama'] + "</td>";
                        mksItem += "<td>" + item['tahun'] + "\n" + ((item['semester'] == 1) ? ("Gasal" + "</td>") : (item['semester'] == 2) ? "Genap" : "Pendek") + "</td>";
                        mksItem += "<td>" + item['jenis'] + "</td>";
                        mksItem += "<td><ul class='list-group'>" +
                            ((item['ijinmajusidang'] != null) ? "<li class='list-group-item list-group-item-success'> maju sidang </li> " : "") +
                            ((item['pengumpulanhardcopy'] != null) ? "<li class='list-group-item list-group-item-success'> kumpul hardcopy </li>" : "") +
                            ((item['issiapsidang'] != null) ? "<li class='list-group-item list-group-item-success'> siap sidang </li>" : "") +
                            "</ul></td>";
                        mksItem += "</tr>";
                        tbody.append(mksItem);
                    });
                },
                error: function(err) {
                    console.log("get mks error", err.responseText);
                }
            });
        }
        $.when(getMks({
            action: "GET_MKS",
            skip: 0,
            take: 10,
            sort: ""
        })).then(function() {
            console.log("load done", totalPage);
            for (var i = 1; i <= totalPage; i++) {
                var page = '<option value="' + i + '">' + i + '</option>';
                pagination.append(page);
            }
        });
        var pagination = $("#pagination");
        pagination.change(function() {
            currentPage = $(this).val();
            showperpage = $("#showperpage").val();
            var data = {
                action: "GET_MKS",
                skip: currentPage * showperpage,
                take: showperpage,
                sort: ""
            };

            getMks(data);
        });

        $("#showperpage").change(function() {
            currentPage = pagination.val();
            showperpage = $(this).val();
            var data = {
                action: "GET_MKS",
                skip: currentPage * showperpage,
                take: showperpage,
                sort: ""
            };
            getMks(data);
        });
    </script>
</body>
</html
