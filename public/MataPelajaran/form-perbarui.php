<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo APP_NAME ?> Mata Pelajaran</title>
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
        Mata Pelajaran
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
            <h3>Perbarui Data</h3>
        </div>

        <br>
        <?php 
            $request = new \engine\http\Request;

            $kode_mapel = $request->get(2);

            $MataPelajaran = new \model\MataPelajaran();
            $MataPelajaran->select($MataPelajaran->getTable())->where()->comparing("kode_mapel",$kode_mapel)->ready();

            $row = $MataPelajaran->getStatement()->fetch();

            $notifikasi = $request->getNotification();
            
            if($notifikasi != ''){
        ?>
            <br><div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> <?php echo $notifikasi; ?> </h4>
            </div><br>
        <?php } ?>

        <form action="<?php url("updateMataPelajaran/") ?>" method="post">
            <div class="box-body">
                <div class="form-group">
                    <label for="Mata PelajaranInput">kode Mata Pelajaran</label>
                    <input type="text" class="form-control" id="Mata PelajaranInput" placeholder="Masukan id" name="kode_mapel" value="<?php echo $row['kode_mapel'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="MataPelajaranInput">Nama Mata Pelajaran</label>
                    <input type="text" class="form-control" id="MataPelajaranInput" placeholder="Masukan nama" name="nama_mapel" value="<?php echo $row['nama_mapel'] ?>">
                </div>
                <div class="form-group">
                    <label for="JenisKelamin">Jenis Mata Pelajaran</label>
                    <select class="form-control" id="JenisKelamin" name="jenis_mapel" readonly>
                        <option value="normatif" <?php if($row['jenis_mapel'] == 'normatif'){?> selected <?php } ?>>Normatif</option>
                        <option value="adaptif" <?php if($row['jenis_mapel'] == 'adaptif'){?> selected <?php } ?>>Adaptif</option>
                        <option value="produktif" <?php if($row['jenis_mapel'] == 'produktif'){?> selected <?php } ?>>Produktif</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="MataPelajaranInput">Keterangan Mata Pelajaran</label>
                  <textarea name="keterangan_mapel" class="form-control" id="MataPelajaranInput" cols="10" rows="3" placeholder="Keterangan Mata Pelajaran"><?php echo $row['keterangan_mapel'] ?></textarea>
                </div>
                <div class="form-group">
                  <label for="TingkatInput">Tingkat Mata Pelajaran</label>
                  <div class="form-control">
                  <label> 
                    <input type="checkbox" value="1" name="tingkat_mapel[]" <?php if(strpos($row['tingkat_mapel'],"1") !== FALSE){ ?> checked <?php } ?>> 1
                  </label>&nbsp&nbsp
                  <label>
                    <input type="checkbox" value="2" name="tingkat_mapel[]" <?php if(strpos($row['tingkat_mapel'],"2") !== FALSE){ ?> checked <?php } ?>> 2
                  </label>&nbsp&nbsp
                  <label>
                    <input type="checkbox" value="3" name="tingkat_mapel[]" <?php if(strpos($row['tingkat_mapel'],"3") !== FALSE){ ?> checked <?php } ?>> 3
                  </label>
                </div> <br>
            </div>
            <!-- /.box-body -->
            &nbsp
            <button type="submit" class="btn btn-primary" name="submit">Perbarui</button><br><br>
          </form>
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
    $("#jenisMapelSelect").click(function (){
        var value = $("#jenisMapelSelect").val();
        
        if(value == 'produktif'){
          $("#MataPelajaranInput").val('P');
        }else if(value == 'normatif'){
          $("#MataPelajaranInput").val('N');
        }else if(value == 'adaptif'){
          $("#MataPelajaranInput").val('A');
        }
    });
  });
</script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>