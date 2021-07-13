<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo APP_NAME ?> Absensi</title>
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
    <?php inc("include.logo") ?>

    <!-- Navigasi -->
    <?php inc("include/navigation") ?>
    
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <?php inc("include/sidebar") ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class ="row">
        <div class="col-md-4">
            <h1>
                Absensi
            </h1>
        </div>
    </div>
    <section class="content">
      <div class="row">
        <div class="col-xs-10">
        <div class="box">

            <!-- /.box-header -->
            <br>
            <?php 
                $request = new \engine\http\Request;
                $notifikasi = $request->getNotification();
                
                if($notifikasi != ''){
            ?>
                <br><div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> <?php echo $notifikasi; ?> </h4>
                </div><br>
            <?php 
            }
            ?>
            <div class="row">
              <div class="col-md-4">
                
              </div>
            </div><br>
            
            <div class="box-header">
            <a class="btn btn-success btn-lg" href="<?php url("Absensi/report/") ?>"><span class="fa fa-print"></span></a><br><br>
              <h3 class="box-title">Data absensi</h3>
            </div>

            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>id absensi</th>
                    <th>tanggal absensi</th>
                    <th>keterangan</th>
                    <th>status</th>
                    <th>hari</th>
                    <th>jam</th>
                    <th>nis</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    inc('include.search');

                    $request = new \engine\http\Request();

                    // proses pencarian
                    $absensi = new \model\Absensi();
                    $absensi->queryCustom("desc ".strtolower($request->get(0)))->ready();

                    $field = array();
                    $i = 0;
                    while ($row = $absensi->getStatement()->fetch()) {
                      $field[$i++] =  $row[0];
                    }

                    $absensi = new \model\Absensi();
                    $absensi->queryCustom("desc jadwal")->ready();
                    
                    while ($row = $absensi->getStatement()->fetch()) {
                      $field[$i++] =  $row[0];
                    }


                    $search = new Search();
                    $search->setField($field);
                    $search->setDelimiter(':');
                    // jadi bentuk search yang diinput menjadi nama_kolom:nilai_kolom

                    // set paging
                    $page = 1;

                    $no = 1;
                    $batas = 5;

                    $nilaiAwal = 0;

                    if($column = $search->matchingColumn($request->getValue('q'))){
                      $absensi->select($absensi->getTable())->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                      ->where()->comparing($column[0],$column[1])->limit($nilaiAwal,$batas)->ready();
                    }else{
                      $absensi->select($absensi->getTable())->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                      ->limit($nilaiAwal,$batas)->ready();
                    }

                    $total = $absensi->getstatement()->rowCount();

                    $totalPage = ceil($total / $batas);

                    if($request->get(2) !== ""){
                      $page = $request->get(2);
                      $nilaiAwal = ($page - 1)  * $batas;
                      $no = $nilaiAwal+1;
                    }else{
                      $page = 0;
                      $nilaiAwal = 0;
                      $no = 1;
                    }

                    // pengambilan data
                    // untuk siswa
                    if($_SESSION['hak_akses'] == 'Siswa'){
                      if($column = $search->matchingColumn($request->getValue('q'))){
                        $absensi->select($absensi->getTable())
                        ->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                        ->where()->comparing($column[0],$column[1])
                        ->and()->comparing('nis_absensi',$_SESSION['id_user'])->limit($nilaiAwal,$batas)->ready();
                      }else{
                        $absensi->select($absensi->getTable())
                        ->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                        ->where()->comparing('nis_absensi',$_SESSION['id_user'])->limit($nilaiAwal,$batas)->ready();
                      }
                    // untuk guru dan walikelas
                    }else if($_SESSION['hak_akses'] == 'Guru' || $_SESSION['hak_akses'] == 'WaliKelas'){
                      if($column = $search->matchingColumn($request->getValue('q'))){
                        $absensi->select($absensi->getTable())
                      ->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                      ->join('guru','jadwal.nip_jadwal','guru.nip')
                      ->where()->comparing('nip',$_SESSION['id_user'])
                      ->and()->comparing($column[0],$column[1])
                      ->limit($nilaiAwal,$batas)->ready();
                      }else{
                        $absensi->select($absensi->getTable())
                      ->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                      ->join('guru','jadwal.nip_jadwal','guru.nip')
                      ->where()->comparing('nip',$_SESSION['id_user'])
                      ->limit($nilaiAwal,$batas)->ready();
                      }
                    // untuk admin
                    }else{
                      if($column = $search->matchingColumn($request->getValue('q'))){
                        $absensi->select($absensi->getTable())
                      ->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                      ->join('guru','jadwal.nip_jadwal','guru.nip')
                      ->where()->comparing($column[0],$column[1])
                      ->limit($nilaiAwal,$batas)->ready();
                      }else{
                        $absensi->select($absensi->getTable())
                      ->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                      ->join('guru','jadwal.nip_jadwal','guru.nip')
                      ->limit($nilaiAwal,$batas)->ready();

                      }
                    }

                    if($absensi->getStatement()->rowCount()){
                    while($row = $absensi->getStatement()->fetch()){ 
                    ?>
                      <tr>
                        <td><?php echo $row['id_absensi'] ?></td>
                        <td><?php echo $row['tanggal_absensi'] ?></td>
                        <td><?php echo $row['keterangan_absensi'] ?></td>
                        <td><?php echo $row['status_absensi'] ?></td>
                        <td><?php echo $row['hari'] ?></td>
                        <td><?php echo $row['jam'] ?></td>

                        <?php 
                        $siswa = new \model\Siswa();
                        $siswa->select($siswa->getTable())->where()->comparing('nis',$row['nis_absensi'])->ready(); 
                        $rowSiswa = $siswa->getStatement()->fetch();
                        ?>
                        
                        <td><?php echo $row['nis_absensi'].'-'.$rowSiswa['nama_siswa'] ?></td>
                        <td>
                          <?php if($_SESSION['hak_akses'] == 'Admin'){ ?>
                            <div class="btn-group">
                              <button type="button" class="btn btn-danger">Delete</button>
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Apakah <br> anda yakin</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php url('removeAbsensi/'.$row['id_absensi'].'/') ?>">iya</a></li>
                                <li><a href="#">Tidak</a></li>
                              </ul>
                            </div>
                          <?php } ?>
                        </td>
                        
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

              <small> <?= $page ?> of <?= $totalPage ?></small>

              <ul class="pagination">
                <li class="page-item"><a href="<?php if($page <= 1){ echo"#"; }else{ url('Absensi/page/'.--$page.'/'); } ?>" class="page-link">Sebelumnya</a></li>
                <?php
                if($request->get(2) !== ""){
                    $page = $request->get(2);
                }else{
                    $page = 1;
                }
                
                for($i=1; $i <= $totalPage;$i++){ ?>
                    <li class="page-item <?php if($page == $i){?> active <?php } ?>"><a href="<?php url('Absensi/page/'.$i.'/') ?>" class="page-link"><?= $i ?></a></li>
                <?php } ?>

                <li class="page-item"><a href="<?php if($page >= $totalPage){ echo"#"; }else{ url('Absensi/page/'.++$page.'/'); } ?>" class="page-link">Setelahnya</a></li>
              </ul>
            </div><br><br>
            <!-- /.box-body -->

            <?php 
              if($_SESSION['hak_akses'] == 'WaliKelas'){
            ?>
            <div class="box-header">
              <a class="btn btn-success btn-lg" href="<?php url("Absensi/report/") ?>"><span class="fa fa-print"></span></a><br><br>
              <h3 class="box-title">Data absensi kelas</h3>
            </div>
            <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>id absensi</th>
                    <th>tanggal absensi</th>
                    <th>keterangan</th>
                    <th>status</th>
                    <th>hari</th>
                    <th>jam</th>
                    <th>nis</th>
                    <th colspan="2">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $request = new \engine\http\Request();

                    $page = 1;

                    $no = 1;
                    $batas = 5;

                    $nilaiAwal = 0;
                    $absensi = new \model\Absensi();
                    $absensi->select($absensi->getTable())->ready();
                    $total = $absensi->getstatement()->rowCount();

                    $totalPage = ceil($total / $batas);

                    if($request->get(2) !== ""){
                        $page = $request->get(2);
                        $nilaiAwal = ($page - 1)  * $batas;
                        $no = $nilaiAwal+1;
                    }
                    
                    $absensi->select($absensi->getTable())
                    ->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                    ->join('guru','jadwal.nip_jadwal','guru.nip')
                    ->join('kelas','jadwal.id_kelas_jadwal','kelas.id_kelas')
                    ->where()->comparing('nip',$_SESSION['id_user'])->and()
                    ->comparing('wali_kelas',$_SESSION['id_user'])
                    ->limit($nilaiAwal,$batas)->ready();
                    
                    if($absensi->getStatement()->rowCount()){
                    while($row = $absensi->getStatement()->fetch()){ 
                    ?>
                      <tr>
                        <td><?php echo $row['id_absensi'] ?></td>
                        <td><?php echo $row['tanggal_absensi'] ?></td>
                        <td><?php echo $row['keterangan_absensi'] ?></td>
                        <td><?php echo $row['status_absensi'] ?></td>
                        <td><?php echo $row['hari'] ?></td>
                        <td><?php echo $row['jam'] ?></td>

                        <?php 
                        $absensi = new \model\absensi();
                        $absensi->select($absensi->getTable())->where()->comparing('nis',$row['nis_absensi'])->ready(); 
                        $rowabsensi = $absensi->getStatement()->fetch();
                        ?>
                        
                        <td><?php echo $row['nis_absensi'].'-'.$rowabsensi['nama_absensi'] ?></td>
                        <td><a class="btn btn-warning" href="<?php url('absensi/update/'.$row['id_absensi'].'/') ?>">Update</a></td>
                        <td>
                          <?php if($_SESSION['hak_akses'] == 'Admin'){ ?>
                            <div class="btn-group">
                              <button type="button" class="btn btn-danger">Delete</button>
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Apakah <br> anda yakin</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php url('removeAbsensi/'.$row['nis'].'/') ?>">iya</a></li>
                                <li><a href="#">Tidak</a></li>
                              </ul>
                            </div>
                          <?php } ?>
                        </td>
                        
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

              <small> <?= $page ?> of <?= $totalPage ?></small>

              <ul class="pagination">
                <li class="page-item"><a href="<?php if($page <= 1){ echo"#"; }else{ url('Absensi/page/'.--$page.'/'); } ?>" class="page-link">Sebelumnya</a></li>
                <?php
                if($request->get(2) !== ""){
                    $page = $request->get(2);
                }else{
                    $page = 1;
                }
                
                for($i=1; $i <= $totalPage;$i++){ ?>
                    <li class="page-item <?php if($page == $i){?> active <?php } ?>"><a href="<?php url('Absensi/page/'.$i.'/') ?>" class="page-link"><?= $i ?></a></li>
                <?php } ?>

                <li class="page-item"><a href="<?php if($page >= $totalPage){ echo"#"; }else{ url('Absensi/page/'.++$page.'/'); } ?>" class="page-link">Setelahnya</a></li>
              </ul>
            </div>
          <?php } ?>
          </div>
          <!-- /.box -->
        </div>
        <!-- row -->
      </div>
    </section>


      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

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
    <strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
  </footer>

  <?php inc("include/control-sidebar") ?>

  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<?php  inc("include/includeJS") ?>
<script>
  $(function () {
    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>