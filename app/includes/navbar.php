<?php

?>
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
