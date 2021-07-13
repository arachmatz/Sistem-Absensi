<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo APP_NAME ?> Pemeriksaan Detail</title>
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

<?php
    $request = new \engine\http\Request();
    $id_pemeriksaan = $request->get(1);


    $pemeriksaan = new \model\Pemeriksaan();
    $pemeriksaan->select($pemeriksaan->getTable())->where()->comparing("id_pemeriksaan",$id_pemeriksaan)->ready();

    $row = $pemeriksaan->getStatement()->fetch();
    
    $pasien = new \model\Pasien();
    $pasien->select($pasien->getTable())->where()->comparing("id_pasien",$row['id_pasien'])->ready();

    $rowPasien = $pasien->getStatement()->fetch();

?>
<body class="hold-transition skin-blue sidebar-mini">
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
                Pemeriksaan Detail 
                <small>Dengan <?php echo "Id ".$rowPasien['id_pasien'].' dan nama '.$rowPasien['nama_pasien'] ?></small>
            </h1>
        </div>
    </div>
    <section class="content">
      <div class="row">
        <div class="col-xs-10">
        <div class="box">

            <div class="box-header">
            <a class="btn btn-success btn-lg" href="<?php url("Pemeriksaan-detail/report/") ?>"><span class="fa fa-print"></span></a><br><br>
              <h3 class="box-title">Data Pemeriksaan detail</h3>
            </div>
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
            <?php } ?>
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Id Pemeriksaan detail</th>
                    <th>Id Pemeriksaan</th>
                    <th>Tanggal_pemeriksaan</th>
                    <th>Keluhan</th>
                    <th>Diagnosa</th>
                    <th>Status</th>
                    <th>Id dokter</th>
                    <th colspan="2">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $pemeriksaan = new \Model\PemeriksaanDetail();
                    $pemeriksaan->select($pemeriksaan->getTable())->where()->comparing('id_pemeriksaan',$id_pemeriksaan)->ready();
                    if($pemeriksaan->getStatement()->rowCount()){
                    while($row = $pemeriksaan->getStatement()->Fetch()){ 
                    ?>
                      <tr>
                        <td><?php echo $row['id_pemeriksaan_detail'] ?></td>
                        <td><?php echo $row['tanggal_pemeriksaan_detail'] ?></td>
                        <td><?php echo $row['keluhan'] ?></td>
                        <td><?php echo $row['diagnosa'] ?></td>
                        <td><?php echo $row['status'] ?></td>
                        <td><?php echo $row['id_dokter'] ?></td>

                        <td><a class="btn btn-warning" href="<?php url('Pemeriksaan/update/'.$row['id_pemeriksaan'].'/') ?>">Update</a></td>
                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#">Apakah <br> anda yakin</a></li>
                              <li class="divider"></li>
                              <li><a href="#">iya</a></li>
                              <li><a href="#">Tidak</a></li>
                            </ul>
                          </div>
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
            </div>
            <!-- /.box-body -->
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

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>