<?php
  session_start();
  $user='';
  if(!isset($_SESSION["loggedRole"])){
    header("Location: ../Login/index.php");
  }else{
    $nav = '';
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sisidang - Daftar Mata Kuliah Spesial</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../../libs/js/jquery.min.js" type="text/javascript"></script>
    <script src="../../libs/js/bootstrap.min.js"></script>
    <script src="../../src/js/generator.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../../libs/css/reset.css">
    <link rel="stylesheet" href="../../libs/css/bootstrap.min.css" />
</head>
<body>
<header>
<?php
    if($_SESSION['loggedRole'] == "admin") {
        echo '<nav class="navbar navbar-inverse">
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
      </nav>';
    }else{
        echo '<nav class="navbar navbar-inverse">
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
      </nav>';
    }
?>

</header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h2> Mata Kuliah Spesial </h2>
                            <?php
                                if($_SESSION['loggedRole'] == "admin") {
                                    echo '<a class="btn btn-primary" href="create.php"> Tambah MKS </a>';
                                }
                            ?>
                            <div class="sort">
                                <select id="sort" class="form-control" name="showperpage">
                                    <option value="mahasiswa"> Nama Mahasiswa </option>
                                    <option value="term"> Term </option>
                                    <option value="jenismks"> Jenis MKS </option>
                                </select>
                            </div>
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
                            <div class="input-group">
                                <select id="selectTerm" class="form-control" name="selectTerm">
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
                                    <th> ACTION </th>
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
        var term;
        var sort = $("#sort").val();
        function getMks(data) {
            console.log("data", data);
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

        function getTerm() {
            $.ajax({
                url: "../../request/request.php",
                method: "GET",
                dataType: "JSON",
                data: {
                    "action": "GET_TERM"
                },
                success: function(response) {
                    var data = response.data;
                    var selectTerm = $("#selectTerm");
                    selectTerm.empty();
                    for (var i = 0; i < data.length; i++) {
                        var semester = (data[i].semester == 1) ? 'Gasal' : (data[i].semester == 2) ? 'Genap' : 'Pendek';
                        selectTerm.append('<option value="' + data[i].tahun + ' ' + data[i].semester + '">' + data[i].tahun + '/' + semester + '</option>');
                    }
                    term = selectTerm.val().split(" ");
                    console.log("term", term);
                },
                error: function(err) {
                    console.log("error : ", err.responseText);
                }
            });
        }
        $.when(getTerm()).then(function(){
            $.when(getMks({
                action: "GET_MKS_WITH_TERM",
                skip: 0,
                take: 10,
                term : term,
                sort: sort
            })).then(function() {
                console.log("load done", totalPage);
                for (var i = 1; i <= totalPage; i++) {
                    var page = '<option value="' + i + '">' + i + '</option>';
                    pagination.append(page);
                }
            });
        });
        var pagination = $("#pagination");
        pagination.change(function() {
            currentPage = $(this).val();
            showperpage = $("#showperpage").val();
            var data = {
                action: "GET_MKS_WITH_TERM",
                skip: currentPage * showperpage,
                take: showperpage,
                sort: sort,
                term : term
            };
            getMks(data);
        });

        $("#showperpage").change(function() {
            currentPage = pagination.val();
            showperpage = $(this).val();
            var data = {
                action: "GET_MKS_WITH_TERM",
                skip: currentPage * showperpage,
                take: showperpage,
                sort: sort,
                term : term
            };
            getMks(data);
        });

        $("#selectTerm").change(function(){
            term = $(this).val().split(" ");
            $.when(getMks({
                action: "GET_MKS_WITH_TERM",
                skip: 0,
                take: 10,
                sort: sort,
                term : term
            })).then(function() {
                console.log("load done", totalPage);
                for (var i = 1; i <= totalPage; i++) {
                    var page = '<option value="' + i + '">' + i + '</option>';
                    pagination.append(page);
                }
            });
        });

        $("#sort").change(function() {
            sort = $(this).val();
            $.when(getMks({
                action: "GET_MKS_WITH_TERM",
                skip: 0,
                take: 10,
                sort: sort,
                term : term
            })).then(function() {
                console.log("load done", totalPage);
                for (var i = 1; i <= totalPage; i++) {
                    var page = '<option value="' + i + '">' + i + '</option>';
                    pagination.append(page);
                }
            });
        });
    </script>
</body>
</html>
