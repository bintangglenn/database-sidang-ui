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
<html>
<head>
	<meta charset="UTF-8">
  <title>Sisidang - Membuat Jadwal Sidang</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../../image/icon.png">
  <script src="../../libs/js/jquery.min.js" type="text/javascript"></script>
  <script src="../../libs/js/bootstrap.min.js"></script>
	<script src="../../src/js/generator.js" type="text/javascript"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../../libs/css/bootstrap.min.css">
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
    <h1>Tambah Jadwal Sidang MKS</h1>
		<p>Menambahkan jadwal sidang sebuah mata kuliah spesial. Silahkan Isi form dibawah ini:</p>
		<form method="post" id="form-jadwalSidang">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                       <label for="mahasiswa"> Mahasiswa </label>
                       <select class="form-control" id="mahasiswa" name="mahasiswa">
                       		<option value='0'> Pilih Mahasiswa </option>
                       </select>
                    </div>
                    <div class="form-group">
                       <label for="tanggal"> Tanggal </label>
                       <input type="text" class="form-control" id="tanggal" placeholder="19-11-2016" /> </select>
                    </div>
                    <div class="form-group">
                       <label for="jamMulai"> Jam Mulai </label>
                       <input type="text" class="form-control" id="jamMulai" placeholder="12:30"/>
                       <label for="jamSelesai"> Jam Selesai </label>
                        <input type="text" class="form-control" id="jamSelesai" placeholder="12:00"/>
                       </select>
                       <label for="ruangan"> Ruangan </label>
                          <select class="form-control penguji" id="ruangan" name="ruangan">
                            <option value='0'>Pilih Ruangan</option>
                          </select>
                    </div>

                    <div class="form-group">
                       <label for="pHardCopy"> Pengumpulan HardCopy</label>
                       <label><input type="radio" name="HardCopy"> Sudah </label>
                    </div>
                </div>
            <div class="col-lg-6">
	            <div class="form-group">
	                <label for="penguji1"> Penguji1 </label>
	            	<select class="form-control penguji" id="penguji1" name="penguji1">
	                	<option value='0'>Pilih Dosen Penguji</option>
	                </select>
	            </div>
	            <div class="form-group">
	                <label for="penguji2"> Penguji 2 </label>
	                <select class="form-control penguji" id="penguji2" name="penguji2">
	                    <option value='0'>Pilih Dosen Penguji</option>
	                </select>
	            </div>
	            <div id="tambah-penguji" class="btn btn-default"> Tambah penguji </div>
            </div>
            </div>
           <button id="btnCreate"type="button" class="btn btn-primary"> Create </button>
           <button id="btnCancel"type="button" class="btn btn-primary"> Cancel </button>
        </form>
	</div>
</body>
 <script type="text/javascript">
   var dosenList;
   var dosenOption;
   var mahasiswaoption;
   var mahasiswaList;
   var ruanganList;
   var ruanganOption;
   // ajax call

   $.ajax({
        url : "../../request/request.php",
        method : "GET",
        dataType : "JSON",
        data : {"action" : "GET_MAHASISWA"},
        success : function (response) {
            mahasiswaList = response.data;
            var selectMahasiswa = $("#mahasiswa");
            //selectMahasiswa.empty();
            for (var i = 0; i < mahasiswaList.length; i++) {
                var option = '<option value=' + mahasiswaList[i].npm + '>' + mahasiswaList[i].nama + '</option>';
                mahasiswaoption += option;
                selectMahasiswa.append(option);
            }
            
        }
    });

     $.ajax({
          url : "../../request/request.php",
          method : "GET",
          dataType : "JSON",
          data : {"action" : "GET_DOSEN"},
          success : function (response) {
              dosenList = response.data;
              var penguji1 = $("#penguji1");
              var penguji2 = $("#penguji2");
              var penguji3 = $("#penguji3");
              var penguji = $("#penguji");
              for (var i = 0; i < dosenList.length; i++) {
                  var option = '<option value=' + dosenList[i].nip + '>' + dosenList[i].nama + '</option>';
                  dosenOption += option;
                  penguji1.append(option);
                  penguji2.append(option);
                  penguji3.append(option);
                  penguji.append(option);
              }
          }
      });

      $.ajax({
          url : "../../request/request.php",
          method : "GET",
          dataType : "JSON",
          data : {"action" : "GET_RUANGAN"},
          success : function (response) {
              ruanganList = response.data;
              var ruangan = $("#ruangan");
              for (var i = 0; i < ruanganList.length; i++) {
                  var option = '<option value=' + ruanganList[i].idruangan + '>' + ruanganList[i].namaruangan + '</option>';
                  ruanganOption += option;
                  ruangan.append(option);
              }
          }
      });

      var x = 1;
      var pengujiWrapper = $("#penguji-wrapper");
      $("#tambah-penguji").click(function(){
          if (x < 3) {
              x++;
              var defaultOption = "<option value='0'>Pilih Dosen</option>";
              var penguji = 'penguji' + x;
              var field = '<div class="form-group ">' +
                  '<label for="' + penguji + '">' + penguji + ' <btn class="btn btn-danger remove-penguji"> Hapus </button></label> ' +
                  '<select class="form-control penguji" id="' + penguji + '" name="'+ penguji + '">' + defaultOption + dosenOption +
                  '</select>' +
                  '</div>';
            pengujiWrapper.append(field);
          }
      });

      pengujiWrapper.on("click",".remove-penguji", function(e){
          console.log("remove");
          $(this).parent().parent().remove();
          x--;
    });

    $(".penguji").change(function() {
        console.log("change");
        var prevValue = $(this).data('previous');
        $('.penguji').not(this).find('option[value="' + prevValue + '"]').show();
        var value = $(this).val();
        $(this).data('previous', value);
        $('.penguji').not(this).find('option[value="' + value + '"]').hide();
    });

    $("#btnCreate").click(function(e) {
        var error = false;
        var mahasiswa = $("#mahasiswa").val();
        var tanggal = $("#tanggal").val();
        var jamMulai = $("#jamMulai").val();
        var jamSelesai = $("#jamSelesai").val();
        var ruangan = $("#ruangan").val();
        var hardCopy = $("#hardCopy").val();
        
        var examinerList = [];
        $(".penguji").each(function(){
            var value = $(this).val();
            if (value === "0") {
                error = true;
                $(this).parent().addClass("has-error");
            } else {
                $(this).parent().removeClass("has-error");
                examinerList.push(value);
            }

        });
        
        if (error) return;
        var id = randomId();
        data = {
            action : "CREATE_JADWAL_SIDANG",
            mahasiswa : mahasiswa,
            tanggal : tanggal,
            jamMulai : jamMulai,
            jamSelesai : jamSelesai,
            ruangan : ruangan,
            hardCopy : hardCopy,
            examinerlist : examinerList,
        };
        $.ajax({
            url : "../../request/request.php",
            dataType : "json",
            data : data,
            method : "POST",
            success : function (response) {
                console.log("sumbitted", response);
            },
            error : function (data) {
                console.log("error", data.responseText);
            }
        });
    });
</script>
</html>
