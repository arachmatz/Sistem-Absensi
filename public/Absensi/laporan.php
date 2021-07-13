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
<form action="#" method="get" class="sidebar-form">
  <div class="input-group">
    <input type="text" name="q" class="form-control" placeholder="Search..." value="">
    <span class="input-group-btn">
        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
        </button>
      </span>
  </div>
</form>
<div class="container">
<script>
window.print();
</script>
<div class="box">
        <div class="row">
            <div class="col-sm-4">
                <h1 class="logo-lg"><b>Sistem Absensi</b></h1>
            </div>
            <div class="col-sm-8 text-center">
                <h1>Rekap Absensi</h1>
                <h2>SMA Darusalam</h2>
                <p>Tulis Alamatnya</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <header>
            <table width="50%" style="">
                <tr>
                    <td>Id</td>
                    <td>:</td>
                    <td><?php echo $_SESSION['id_user'] ?></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><?php echo $_SESSION['nama']?></td>
                </tr>
                <tr>
                    <td>Tanggal Rekap</td>
                    <td>:</td>
                    <td><?php $tanggal_sekarang = date('d F Y');
                    echo $tanggal_sekarang; ?></td>
                </tr>
            </table>
            </header><br><br>
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
                    
                    // pengambilan data
                    // untuk siswa
                    if($_SESSION['hak_akses'] == 'Siswa'){
                      if($column = $search->matchingColumn($request->getValue('q'))){
                        $absensi->select($absensi->getTable())
                        ->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                        ->where()->comparing($column[0],$column[1])
                        ->and()->comparing('nis_absensi',$_SESSION['id_user'])->ready();
                      }else{
                        $absensi->select($absensi->getTable())
                        ->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                        ->where()->comparing('nis_absensi',$_SESSION['id_user'])->ready();
                      }
                    // untuk guru dan walikelas
                    }else if($_SESSION['hak_akses'] == 'Guru' || $_SESSION['hak_akses'] == 'WaliKelas'){
                      if($column = $search->matchingColumn($request->getValue('q'))){
                        $absensi->select($absensi->getTable())
                      ->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                      ->join('guru','jadwal.nip_jadwal','guru.nip')
                      ->where()->comparing('nip',$_SESSION['id_user'])
                      ->and()->comparing($column[0],$column[1])->ready();
                      }else{
                        $absensi->select($absensi->getTable())
                      ->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                      ->join('guru','jadwal.nip_jadwal','guru.nip')
                      ->where()->comparing('nip',$_SESSION['id_user'])->ready();
                      }
                    // untuk admin
                    }else{
                      if($column = $search->matchingColumn($request->getValue('q'))){
                        $absensi->select($absensi->getTable())
                      ->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                      ->join('guru','jadwal.nip_jadwal','guru.nip')
                      ->where()->comparing($column[0],$column[1])->ready();
                      }else{
                        $absensi->select($absensi->getTable())
                      ->join('jadwal','jadwal.id_jadwal','absensi.id_jadwal_absensi')
                      ->join('guru','jadwal.nip_jadwal','guru.nip')->ready();
                    
                      }
                    }                    

                    if($absensi->getStatement()->rowCount()){
                    while($row = $absensi->getStatement()->Fetch()){ 
                    ?>
                        <tr>
                        <td><?php echo $row['id_absensi'] ?></td>
                        <td><?php echo $row['tanggal_absensi'] ?></td>
                        <td><?php echo $row['keterangan_absensi'] ?></td>
                        <td><?php echo $row['status_absensi'] ?></td>
                        <td><?php echo $row['hari'] ?></td>
                        <td><?php echo $row['jam'] ?></td>

                        <td><?php 
                        $siswa = new \model\Siswa();
                        $siswa->select($siswa->getTable())->where()->comparing('nis',$row['nis_absensi'])->ready();
                        $rowSiswa = $siswa->getStatement()->fetch();

                        echo $row['nis_absensi'].' - '.$rowSiswa['nama_siswa'] ?></td>
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
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

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