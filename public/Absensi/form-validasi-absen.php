<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo APP_NAME ?> absensi</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


  <?php inc("include/includeCSS") ?>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <?php inc("include.logo") ?>
      
    <!-- Navigasi -->
    <?php inc("include.navigation") ?>
    
  </header>
  
  <!-- Left side column. contains the logo and sidebar -->
  <?php inc("include/sidebar") ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        absensi
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
    <div class="col-xs-10">
      <div class="box">
        <div class="box-header">
            <h3>Absensi</h3>
        </div>

        <br>
        <?php 
            $keterangan = ['H','I','S','A'];
            $hariSekarang = date('l');
            $hari = ['Sunday' =>'minggu','Monday' => 'senin','Tuesday' => 'selasa','Wednesday' => 'rabu','Thursday' => 'kamis','Friday' => 'jumat','Saturday'=> 'sabtu'];

            $hariSeleksi = "";

            foreach($hari as $key => $value){
              if($key == $hariSekarang){
                $hariSeleksi = $value;
              }
            }
            
            $request = new \engine\http\Request;
            $nis = $_SESSION['id_user'];

            // init siswa untuk mendapatkan kolom kelas
            $siswa = new \model\Siswa();
            $siswa->select($siswa->getTable())->where()->comparing('nis',$nis)->ready();
            $rowSiswa = $siswa->getStatement()->fetch();

            $id_kelas = $rowSiswa['id_kelas_siswa'];

            $jam = "";
            $tanggalReq = date('Y-m-d');

            if($request->get(3)){
              $jam = $request->get(3);
            }

            $notifikasi = $request->getNotification();
            
            if($notifikasi != ''){
        ?>
            <br><div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> <?php echo $notifikasi; ?> </h4>
            </div><br>
        <?php } 
        $jadwal = new \model\Jadwal();

        // jadwal berdasakan guru dan hari sebelum absen dibuat
        $jadwal->select($jadwal->getTable())
        ->join('mata_pelajaran','jadwal.kode_mapel_jadwal','mata_pelajaran.kode_mapel')
        ->join('guru','jadwal.nip_jadwal','guru.nip')
        ->where()->comparing('id_kelas_jadwal',$id_kelas)
        ->and()->comparing('hari',$hariSeleksi)->ready();

        ?>
          <div class="row">
            <div class="col-md-8">
              <div class="box-body box-primary">
              <h4>Jadwal anda pada hari <br> <?php echo $hariSeleksi.', '.date('d F Y') ?></h4>
              <table class="table table-bordered">
                <tr>
                  <th>Jam</th>
                  <th>Nama mapel</th>
                  <th>nama guru</th>
                </tr>
              <?php 
              if($jadwal->getStatement()->rowCount()){
                while($rowJadwal = $jadwal->getStatement()->fetch()){ ?>
                <tr>
                  <td><?php echo $rowJadwal['jam'] ?></td>
                  <td><?php echo $rowJadwal['nama_mapel'] ?></td>
                  <td><?php echo $rowJadwal['nip'] ?></td>
                </tr>
              <?php 
                }
              }else{ ?>
                <td>No data</td>
              <?php 
              }
              ?>
              </table><br><br>
              </div>
            </div>
          </div>

          <form action="<?php url('cekAbsensi/') ?>" method="post">
                <div class="form-group">
                    <label for="nipInput">Jam ke</label>
                    <select name="jam" class="form-control">
                      <option value="">- - -</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>

                <button class="btn btn-success" name="cek">Cek Jadwal</button>
            </form>

              <?php
              // jadwal berdasakan kelas, tanggal dan jam setelah absen dibuat
              $jadwal->select($jadwal->getTable())
              ->join('mata_pelajaran','jadwal.kode_mapel_jadwal','mata_pelajaran.kode_mapel')
              ->join('guru','jadwal.nip_jadwal','guru.nip')
              ->where()->comparing('id_kelas_jadwal',$id_kelas)
              ->and()->comparing('hari',$hariSeleksi)
              ->and()->comparing('jam',$jam)->ready();

              $rowJadwal = $jadwal->getStatement()->fetch();

              $absensi = new \model\Absensi();
              $absensi->select($absensi->getTable())->where()
              ->comparing("id_jadwal_absensi",$rowJadwal['id_jadwal'])
              ->and()->comparing("nis_absensi",$_SESSION['id_user'])->ready();
              $rowAbsen = $absensi->getStatement()->fetch();
              
              ?>
              <table class="table table-bordered">
                <thead>
                  <th>id absen</th>
                  <th>nis - nama siswa</th>
                  <th>keterangan</th>
                  <th>Aksi</th>
                </thead>
                <tbody>
                <?php 
                  $absensi = new \model\Absensi();
                  $absensi->select($absensi->getTable())->where()
                  ->comparing("id_jadwal_absensi",$rowJadwal['id_jadwal'])
                  ->and()->comparing("nis_absensi",$_SESSION['id_user'])->ready();

                  while ($rowAbsen = $absensi->getStatement()->fetch()) { 
                    $tanggal = explode(' ',$rowAbsen['tanggal_absensi']);
                    if($tanggal[0] == $tanggalReq && $jam == $rowJadwal['jam']){ ?>
                      <tr><td><?php echo $rowAbsen['id_absensi']; ?></td>  
                        <?php
                        $siswa = new \model\Siswa();
                        $siswa->select($siswa->getTable())->where()->comparing('nis',$rowAbsen['nis_absensi'])->ready(); 
                        $rowSiswa = $siswa->getStatement()->fetch();
                        ?>
                        <td><?php echo $rowAbsen['nis_absensi'].'-'.$rowSiswa['nama_siswa']; ?></td>  
                        <td><?php echo $rowAbsen['keterangan_absensi']; ?></td>
                        <td>
                        <form action="<?php url('absenHadir/') ?>" method="post">
                        <input type="text" name="id_absensi" value="<?php echo $rowAbsen['id_absensi'] ?>" class="hide">
                        <input type="text" name="nis" value="<?php echo $rowAbsen['nis_absensi'] ?>" class="hide">
                        <button class="btn btn-success" name="absen">H</button>
                        </form>&nbsp;
                        </td>
                      </tr>
                    <?php 
                    }
                  }
                ?>
                </tbody>
              </table>
      </div>
    </div>
    </section>
    
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
  </footer>

    <?php inc("include/control-sidebar") ?>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<?php  inc("include/includeJS") ?>
<script type="text/javascript">
  $(document).ready(function (){
    var hariJam ;

  });
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>