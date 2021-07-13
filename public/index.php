<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo APP_NAME ?> Dashboard</title>
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
<body class="hold-transition skin-blue">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <?php inc('include.logo') ?>

    <?php inc("include/navigation") ?>
    
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <?php inc("include/sidebar") ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        DASHBOARD
      </h1>

      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php echo $id['halaman'] ?></a></li>
        <li class="active"><?php echo $id['halamanAktif'] ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
    <?php 
      if($_SESSION['hak_akses'] == 'Siswa'){ ?>
      <br><div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
          <h4><i class="icon fa fa-info"></i>WARNING !!!</h4>
          <p>Ketahuan Curang sanksi nilai NOL </p>
          </div><br>

  <marquee>Absensi SMA Darussalam</marquee>

      <?php }

      if($_SESSION['hak_akses'] == "Admin"){ ?>
        <div class="row">
        <?php inc('include.list-box') ?>

        <?php
        $model = new \model\Siswa();
        $model->select($model->getTable())->ready();
        listBox("aqua",'Siswa',$model->getStatement()->rowCount(),'users');

        $model = new \model\Guru();
        $model->select($model->getTable())->ready();
        listBox("green",'Guru',$model->getStatement()->rowCount(),'male');

        $model = new \model\Kelas();
        $model->select($model->getTable())->ready();
        listBox("red",'Kelas',$model->getStatement()->rowCount(),'home') ?>
        <?php 
        $model = new \model\MataPelajaran();
        $model->select($model->getTable())->ready();
        listBox("yellow",'Mata Pelajaran',$model->getStatement()->rowCount(),'book') ?>
        <?php
        $model = new \model\User();
        $model->select($model->getTable())->ready();
        listBox("blue",'User',$model->getStatement()->rowCount(),'users');
        ?>
    </div>
      <?php 
      }
    ?>
    <?php if($_SESSION['hak_akses'] != 'Admin'){ ?>
      <div class="row">
      <?php if($_SESSION['hak_akses'] == 'WaliKelas'){ ?>
        <div class="col-md-8">
        <h3>Data Siswa yang anda walikan</h3>
        <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Foto</th>
                    <th>Nis</th>
                    <th>Nama Siswa</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Id Kelas</th>
                  </tr>
                </thead>
                <tbody>
                  <?php        
                    $request = new \engine\http\Request();
                    $page = 1;

                    $no = 1;
                    $batas = 5;

                    $nilaiAwal = 0;

                    $kelas = new \model\Kelas();
                    $kelas->select($kelas->getTable())->where()
                    ->comparing('wali_kelas',$_SESSION['id_user'])->ready();
                    $rowKelas = $kelas->getStatement()->fetch();
                    
                    if($kelas->getStatement()->rowCount()){

                      $siswa = new \model\Siswa();
                      $siswa->select($siswa->getTable())->where()
                      ->comparing('id_kelas_siswa',$rowKelas['id_kelas'])->ready();
                      $total = $siswa->getstatement()->rowCount();
  
                      $totalPage = ceil($total / $batas);
  
                      if($request->get(2) !== ""){
                          $page = $request->get(2);
                          $nilaiAwal = ($page - 1)  * $batas;
                          $no = $nilaiAwal+1;
                      }
  
                      $siswa->select($siswa->getTable())->where()->comparing('id_kelas_siswa',$rowKelas['id_kelas'])
                      ->ready();
                    while($row = $siswa->getStatement()->fetch()){ 
                    ?>
                      <tr>
                        <td><img src="<?php getFiles($row['foto_siswa']) ?>" alt="" width="100%"></td>
                        <td><?php echo $row['nis'] ?></td>
                        <td><?php echo $row['nama_siswa'] ?></td>
                        <td><?php echo $row['tanggal_lahir_siswa'] ?></td>
                        <td><?php echo $row['jenis_kelamin_siswa'] ?></td>
                        <td><?php echo $row['alamat_siswa'] ?></td>
                        <td><?php echo $row['id_kelas_siswa'] ?></td>
                      </tr> 
                      <?php
                      }
                    }else{
                      echo "<td>No data</td>";
                    }
                      ?>
                </tbody>
                <tfoot>
                
                </tfoot>
              </table>
      </div>
      <div class="col-md-2"></div>
      <?php 
      }
      ?>
      <div class="col-md-8">
        <h3>Jadwal Mata Pelajaran</h3>
        <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Id jadwal</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>kelas</th>
                    <th>kode mata pelajaran</th>
                    <th>nip</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $id_seleksi = "";
                    $value ="";
                    if($_SESSION['hak_akses'] == 'Siswa'){ ?>
                    <?php
                      
                      $id_seleksi = 'id_kelas_jadwal';

                      $siswa = new \model\Siswa();
                      $siswa->select($siswa->getTable())->where()->comparing('nis',$_SESSION['id_user'])->ready();
                      
                      $row = $siswa->getStatement()->fetch();

                      $value = $row['id_kelas_siswa'];
                    }else if($_SESSION['hak_akses'] == 'Guru' || $_SESSION['hak_akses'] == 'WaliKelas'){
                      $id_seleksi = 'nip_jadwal';
                      $value = $_SESSION['id_user'];
                    }

                    $request = new \engine\http\Request();
                    $page = 1;

                    $no = 1;
                    $batas = 5;

                    $nilaiAwal = 0;

                    $jadwal = new \model\Jadwal();
                    $jadwal->select($jadwal->getTable())->where()->comparing($id_seleksi,$value)->ready();

                    $total = $jadwal->getstatement()->rowCount();

                    $totalPage = ceil($total / $batas);

                    if($request->get(2) !== ""){
                        $page = $request->get(2);
                        $nilaiAwal = ($page - 1)  * $batas;
                        $no = $nilaiAwal+1;
                    }

                    $jadwal->select($jadwal->getTable())
                    ->join('mata_pelajaran','jadwal.kode_mapel_jadwal','mata_pelajaran.kode_mapel')
                    ->join('guru','jadwal.nip_jadwal','guru.nip')
                    ->where()->comparing($id_seleksi,$value)->ready();
                    if($jadwal->getStatement()->rowCount()){
                    while($row = $jadwal->getStatement()->fetch()){ 
                    ?>
                      <tr>
                        <td><?php echo $row['id_jadwal'] ?></td>
                        <td><?php echo $row['hari'] ?></td>
                        <td><?php echo $row['jam'] ?></td>
                        <td><?php echo $row['id_kelas_jadwal'] ?></td>
                        <td><?php echo $row['kode_mapel_jadwal'].' - '.$row['nama_mapel'] ?></td>
                        <td><?php echo $row['nip_jadwal'].' - '.$row['nama_guru'] ?></td>
                      </tr> 
                      <?php
                      }
                    }else{
                      echo "<td>No data</td>";
                    }
                      ?>
                </tbody>
                <tfoot>
                
                </tfoot>
              </table>
      </div>
    </div>
    <?php } ?>
    
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2019 <a href="#">Company</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <?php inc("include.control-sidebar") ?>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                  </span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
      </div>
      <!-- /.tab-pane -->
    </div>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<?php  inc("include/includeJS") ?>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>