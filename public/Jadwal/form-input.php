<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo APP_NAME ?> jadwal</title>
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
        jadwal
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
            <h3>Tambah Data</h3>
        </div>

        <br>
        <?php 
            $hari = ['senin','selasa','rabu','kamis','jumat','sabtu'];
            $jam = ['1','2','3','4'];
            
            $request = new \engine\http\Request;
            $kode_mapel = "";
            $id_kelas = "";
            

            if($request->get(2)){
              $id_kelas = $request->get(2);
              $kode_mapel = $request->get(3);
            }

            $notifikasi = $request->getNotification();
            
            if($notifikasi != ''){
        ?>
            <br><div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> <?php echo $notifikasi; ?> </h4>
            </div><br>
        <?php } ?>
          <div class="row">
            <div class="col-md-8">
              <div class="box-body box-primary with-border">
                <form action="<?php url('memilihJadwal/') ?>" method="post">  
                  <div class="form-group">
                    <label for="kodeMatkulInput">Kode Mata Pelajaran</label>
                      <select name="kode_mapel" id="" class="form-control">
                        <option value="">- - - -</option>
                        <?php 
                            $mapel = new \model\MataPelajaran();
                            $mapel->select($mapel->getTable())->ready();
                              while($row= $mapel->getStatement()->fetch()){ ?>
                              <option value="<?= $row['kode_mapel'] ?>" <?php if($row['kode_mapel'] == $kode_mapel){?> selected <?php } ?>><?php echo $row['kode_mapel'].' - '.$row['nama_mapel'].'('.$row['tingkat_mapel'].')' ?></option>
                        <?php 
                              }
                      ?>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="idKelasInput">id kelas</label>
                      <select name="id_kelas" id="" class="form-control">
                        <option value="">- - - -</option>
                      <?php $kelas = new \model\Kelas();
                            $kelas->select($kelas->getTable())->ready();
                            while($row= $kelas->getStatement()->fetch()){ ?>
                              <option value="<?= $row['id_kelas'] ?>" <?php if($row['id_kelas'] == $id_kelas){?> selected <?php } ?> ><?php echo $row['nama_kelas'] ?></option>
                      <?php 
                            }
                      ?>
                      </select>
                      <br>
                      <input type="submit" class="btn btn-success" name="memilih" value="memilih">
                  </div>
                </form>
              </div>
            </div>
          </div>
            
              <?php
              
              $jadwal = new \model\Jadwal();
              $jadwal->select($jadwal->getTable())->join('mata_pelajaran','jadwal.kode_mapel_jadwal','mata_pelajaran.kode_mapel')
              ->where()->comparing('id_kelas_jadwal',$id_kelas)
              ->ready(); ?>
              <div class="box-body table responsive">
              <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                          <th colspan="3">Daftar mata pelajaran kelas <?php echo $id_kelas ?> yang sudah didaftarkan</th>
                        </tr>
                        <tr>
                          <th>Mata Pelajaran</th>
                          <th>Hari</th>
                          <th>Jam</th>
                        </tr>
                    </thead>
              <?php
              if($jadwal->getStatement()->rowCount()){
              ?>
                  <?php
                      
                      while($row = $jadwal->getStatement()->fetch()){ ?>
                      <tr>
                        <td><?php echo $row['kode_mapel'].' - '.$row['nama_mapel'] ?></td>
                        <td><?php echo $row['hari'] ?></td>
                        <td><?php echo $row['jam'] ?></td>
                      </tr>
                      <?php }
                      }else{ ?>
                        <td>No data</td>
                      <?php } ?>
                  </table>
              </div>
              
              <?php
              $jadwal->select($jadwal->getTable())->join('mata_pelajaran','jadwal.kode_mapel_jadwal','mata_pelajaran.kode_mapel')
              ->where()->comparing('id_kelas_jadwal',$id_kelas)
              ->and()->comparing('kode_mapel_jadwal',$kode_mapel)->ready();
              $row = $jadwal->getStatement()->fetch();

              
              // periksa apa jadwal sudah dibuat berdasarkan kode mapel dan id kelas
              if($jadwal->getStatement()->rowCount()){ ?>
              
              <?php } else{ 
                  if($kode_mapel != "" && $id_kelas != ""){
                ?>
              <div class="box-header">
                    <h3>Tambah jadwal <br><small>jadwal yang ditambah tidak terdapat hari dan jam pada daftar jadwal diatas</small></h3>
              </div>
              <div class="box-body">
                <form action="<?php url('addJadwal/')?>" method="post")>
                <div class="form-group">
                  <input type="text" name="id_kelas" placeholder="id kelas" class="form-control" value="<?php echo $id_kelas ?>" readonly>
                </div>
                <div class="form-group">
                  <input type="text" name="kode_mapel" placeholder="kode mata pelajaran" class="form-control" value="<?php echo $kode_mapel ?>" readonly>
                </div>
                  
                  
                <div class="form-group">
                    <label for="nipInput">nip</label>
                    <select name="nip" id="" class="form-control">
                    <option value="">- - - -</option>
                  <?php $guru = new \model\Guru();
                        $guru->select($guru->getTable())->ready();
                        while($row= $guru->getStatement()->fetch()){ ?>
                          <option value="<?= $row['nip'] ?>"><?php echo $row['nip'].' - '.$row['nama_guru'] ?></option>
                  <?php 
                        }
                  ?>
                    </select>
                  </div>

                  <div class="form-group">
                      <label for="hariInput">hari</label>
                      <select name="hari" id="hariInput" class="form-control">
                      <option value="">- - - -</option>
                      <?php
                      foreach($hari as $value){ ?>
                          <option value="<?php echo $value ?>"><?php echo $value?></option>
                      <?php } ?>
                        
                      </select>
                  </div>
                   
                  <div class="form-group">
                    <label for="hariInput">jam ke</label>
                    <select name="jam" id="hariInput" class="form-control">
                    <option value="">- - - -</option>
                    <?php
                    
                    foreach($jam as $value){ ?>
                        <option value="<?php echo $value ?>"><?php echo $value ?></option>
                    <?php } ?>  
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary" name="submit">Tambahkan</button><br><br>
                  </form>
              </div>
              <!-- /.box-body -->
            <?php 
              }
            }
            ?>
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