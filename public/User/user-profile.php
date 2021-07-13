<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo APP_NAME ?> User Profile</title>
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
  <?php 
    $id = "";
    $class = "";
    $redirect = "";
    if($_SESSION['hak_akses'] == 'Admin'){
        $id = "id_user";
        $class = "\model\User";
        $redirect = "User/update/";
    }else if($_SESSION['hak_akses'] == 'Guru' || $_SESSION['hak_akses'] == 'WaliKelas'){
        $id = "nip";
        $class = "\model\Guru";
        $redirect = "Guru/updateProfil/";
    }else if($_SESSION['hak_akses'] == 'Siswa'){
        $id = "nis";
        $class = "\model\Siswa";
        $redirect = "Siswa/updateProfil/";
    }
    
    $model = new $class();
    if($_SESSION['hak_akses'] == 'Admin'){
      $model->select($model->getTable())->where()
      ->comparing($id,$_SESSION['id_user'])
      ->ready();
    }else if($_SESSION['hak_akses'] == 'Guru' || $_SESSION['hak_akses'] == 'WaliKelas' || $_SESSION['hak_akses'] == 'Siswa'){
      $classs = explode('\\',$class);
      $model->select($model->getTable())->join('user','user.username',$model->getTable().'.'.$id)
      ->where()->comparing($id,$_SESSION['id_user'])->ready();
    }

    $row = $model->getStatement()->fetch();
    ?>

    <!-- Logo -->
    <?php inc("include.logo") ?>

    <!-- navigasi -->
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
              User Profile untuk <?php echo $row[1] ?>
          </h1>
        </div>
    </div>
    <section class="content">
      <div class="row">
        <div class="col-xs-10">
        <div class="box">

            <div class="box-header">
              <h3 class="box-title">Data User</h3>
            </div>
            <!-- /.box-header -->
            <br>
            <?php 
                $request = new \engine\http\Request;
                $notifikasi = $request->getNotification();
                
                if($notifikasi != ''){
            ?>
                <br><div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <h4><i class="icon fa fa-info"></i> <?php echo $notifikasi; ?> </h4>
                </div><br>
            <?php } ?>
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                </thead>
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td><?php echo $row[1] ?></td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td><?php echo $row['username'] ?></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><?php echo $row['password'] ?></td>
                    </tr>
                    <?php if($_SESSION['hak_akses'] == 'Guru' || $_SESSION['hak_akses'] == 'WaliKelas' || $_SESSION['hak_akses'] == 'Siswa'){ ?>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td><?php echo $row[2] ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td><?php echo $row[4] ?></td>
                    </tr>

                    <?php } ?>
                    <tr>
                        <td>Hak Akses</td>
                        <td><?php echo $row['hak_akses'] ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="text-center">
                        <td colspan="2"><a href="<?php url($redirect.$row[0].'/') ?>" class="btn btn-primary">Ubah</a></td>
                    </tr>
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