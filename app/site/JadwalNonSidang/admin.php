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
  <title>Jadwal Non Sidang Dosen (admin)</title>
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
       <h2>Tambah Jadwal Non-Sidang Dosen</h2> 
       <h6>khusus admin</h6>
       <br>
       <form method="post" id="form-mks">
           <div class="row">
               <div class="col-lg-6">
                  
                   <div class="form-group">
                       <label for="dosen"> Dosen </label>
                        <select class="form-control penguji" id="penguji" name="penguji">
                        	<option value="0">Pilih Dosen</option>
                            <option value='1'>Budi</option>
                        </select>
                   </div>
                   <div class="form-group">
                       <label for="TanggalMulai"> Tanggal Mulai </label>
                       <input type="text" class="form-control" id="TanggalMulai"/>
                   </div>
                   <div class="form-group">
                       <label for="TanggalSelesai"> Tanggal Selesai </label>
                       <input type="text" class="form-control" id="TanggalSelesai"/>
                   </div>
               </div>
             
               <div class="col-lg-6">
                   <div class="form-group">
                       <label for="JamMulai"> Jam Mulai </label>
                       <input type="text" class="form-control" id="JamMulai"/>
                   </div>
               </div>
               <div class="col-lg-6">
                   <div id="penguji-wrapper">
                       <div class="form-group ">
                           <label for="JamSelesai"> Jam Selesai </label>
                           <input type="text" class="form-control" id="JamSelesai"/>
                       </div>                       
                   </div>
               </div>
                 <div class="col-lg-6">                  
                    <div class="form-group ">
                        <label for="Keterangan"> Keterangan </label>
                        <input type="text" class="form-control" id="Keterangan"/>
                    </div>

               </div>
               <div class="col-lg-6">            
                    <div class="form-group">
                       <label for="KegiatanBerulang"> Kegiatan Berulang </label>
                       <div class="radio">
     						<label><input type="radio" name="optradio">Harian</label>
    					</div>
    					<div class="radio">
      						<label><input type="radio" name="optradio">Mingguan</label>
    					</div>
   				 		<div class="radio">
      						<label><input type="radio" name="optradio">Bulanan</label>
    					</div>

                   </div>
               </div>
           </div>
           <button id="btnCreate"type="button" class="btn btn-primary"> Simpan </button>
           <button id="btnCreate"type="button" class="btn btn-primary"> Batal </button>
       </form>
   </div>
   <script type="text/javascript">
   var dosenList;
   var dosenOption;

   // ajax call
   $.ajax({
       url : "../../request/request.php",
       method : "GET",
       dataType : "JSON",
       data : {"action" : "GET_TERM"},
       success : function(response) {
           var data = response.data;
           var selectTerm = $("#term");
           selectTerm.empty();
           for (var i = 0; i < data.length; i++) {
               selectTerm.append('<option value="' + data[i].tahun + ' ' + data[i].semester + '">' + data[i].tahun + ' ' + data[i].semester + '</option>');
           }
       },
       error : function (err) {
           console.log("error : ", err.responseText);
       }
   });

   $.ajax({
        url : "../../request/request.php",
        method : "GET",
        dataType : "JSON",
        data : {"action" : "GET_MAHASISWA"},
        success : function (response) {
            var data = response.data;
            var selectMahasiswa = $("#mahasiswa");
            selectMahasiswa.empty();
            for (var i = 0; i < data.length; i++) {
                selectMahasiswa.append('<option value=' + data[i].npm + '>' + data[i].nama + '</option>');
            }
        }
    });

    $.ajax({
         url : "../../request/request.php",
         method : "GET",
         dataType : "JSON",
         data : {"action" : "GET_JENIS_MKS"},
         success : function (response) {
             var data = response.data;
             var selectJenisMKS = $("#jenismks");
             selectJenisMKS.empty();
             for (var i = 0; i < data.length; i++) {
                 selectJenisMKS.append('<option value=' + data[i].id + '>' +  data[i].namamks + '</option>');
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
              var pembimbing1 = $("#pembimbing1");
              var pembimbing2 = $("#pembimbing2");
              var pembimbing3 = $("#pembimbing3");
              var penguji = $("#penguji");
              for (var i = 0; i < dosenList.length; i++) {
                  var option = '<option value=' + dosenList[i].nip + '>' + dosenList[i].nama + '</option>';
                  dosenOption += option;
                  pembimbing1.append(option);
                  pembimbing2.append(option);
                  pembimbing3.append(option);
                  penguji.append(option);
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

    $(".pembimbing").change(function() {
        console.log("change");
        var prevValue = $(this).data('previous');
        $('.pembimbing').not(this).find('option[value="' + prevValue + '"]').show();
        var value = $(this).val();
        $(this).data('previous', value);
        $('.pembimbing').not(this).find('option[value="' + value + '"]').hide();
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
        var term = $("#term").val().split(" ");
        var npm = $("#mahasiswa").val();
        var type = $("#jenismks").val();
        var title = $("#judulmks").val();
        if (title == null || title.length < 10) {
            error = true;
            $("#judulmks").parent().addClass("has-error");
        } else {
            $("#judulmks").parent().removeClass("has-error");
        }

        var adviserList = [];
        $(".pembimbing").each(function(){
            var value = $(this).val();
            if (value === "0") {
                error = true;
                $(this).parent().addClass("has-error");
            } else {
                $(this).parent().removeClass("has-error");
                adviserList.push(value);
            }
        });
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
            action : "CREATE_MKS",
            idmks : id,
            term : term,
            npm : npm,
            type : type,
            title : title,
            adviserlist : adviserList,
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
</body>