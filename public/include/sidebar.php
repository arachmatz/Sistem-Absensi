<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php getFiles($_SESSION['foto']) ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['nama'] ?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <?php  
          $request = new \engine\http\Request();
          $halaman = $request->get(0);

          if($halaman == 'MataPelajaran'){
            $halaman = 'mata_pelajaran';
          }

          if($halaman){
            $user = new \model\User();
            $user->queryCustom("desc ".strtolower($halaman))->ready();

            $field = array();
            $i = 0;
            while ($row = $user->getStatement()->fetch()) {
              $field[$i++] =  $row[0];
            }

            $user = new \model\User();
            $user->queryCustom("desc jadwal")->ready();
            
            while ($row = $user->getStatement()->fetch()) {
              $field[$i++] =  $row[0];
            }
        ?>
      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          
          <input type="text" name="q" class="form-control" placeholder="Search..." value="">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>
      <ul class="sidebar-menu" data-widget="tree">
      <li class="treeview">
        <a href="#">
          <i class="fa fa-search"></i> <span>Field yang bisa dicari</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" id="chooseField">
        <?php for($i = 1;$i < count($field);$i++){ ?>
          <li><a href="#"><?= $field[$i] ?></a></li>
        <?php } ?>
        <li><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                Penggunaan search
            </button></li><br>
        </ul>
      </li>
      </ul>
      <!-- /.search form -->
      <?php   } ?>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
      <?php 
        if(count($_SESSION) > 0){ 
          switch ($_SESSION['hak_akses']) {
            case 'Admin': ?>
              <li class="header">Main Data</li>
        <!-- Optionally, you can add icons to the links -->
              <li><a href="<?php url("Guru/") ?>"><i class="fa fa-user-md"></i><span>Guru</span></a></li>
              <li ><a href="<?php url("Kelas/") ?>"><i class="fa fa-users"></i><span>Kelas</span></a></li>
              <li ><a href="<?php url("Siswa/") ?>"><i class="fa fa-user"></i><span>Siswa</span></a></li>
              <li><a href="<?php url("MataPelajaran/") ?>"><i class="fa fa-book"></i><span>Mata Pelajaran</span></a></li>
              <li><a href="<?php url("User/") ?>"><i class="fa fa-user-secret"></i><span>User</span></a></li>

              <li class="header">Transaction Data</li>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-stethoscope"></i> <span>Jadwal</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li>
                      <a href="<?php url('Jadwal/add/') ?>"><i class="fa fa-circle-o"></i>Tambah Data</a>
                  </li>
                  <li><a href="<?php url('Jadwal/') ?>"><i class="fa fa-circle-o"></i> Lihat Selengkapnya</a></li>
                </ul>

              </li>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-book"></i> <span>Absensi</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li>
                      <a href="<?php url('Absensi/add/') ?>"><i class="fa fa-circle-o"></i>Tambah Data</a>
                  </li>
                  <li><a href="<?php url('Absensi/') ?>"><i class="fa fa-circle-o"></i> Lihat Selengkapnya</a></li>
                </ul>

              </li>      

              <?php
              break;
            case 'Siswa':
            case 'Guru':
            case 'WaliKelas': ?>
              <li class="header">Transaction Data</li>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-stethoscope"></i> <span>Jadwal</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">>
                  <li><a href="<?php url('Jadwal/') ?>"><i class="fa fa-circle-o"></i> Lihat Selengkapnya</a></li>
                </ul>
              </li>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-book"></i> <span>Absensi</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                <?php if($_SESSION['hak_akses'] != "Siswa"){ ?>
                  <li>
                      <a href="<?php url('Absensi/add/') ?>"><i class="fa fa-circle-o"></i>Tambah Data</a>
                  </li>
                <?php } 
                
                if($_SESSION['hak_akses'] == "Siswa"){ ?>
                  <li><a href="<?php url('Absensi/validasi/') ?>"><i class="fa fa-circle-o"></i>Validasi Absensi</a></li>
                  <?php } ?>
                  <li><a href="<?php url('Absensi/') ?>"><i class="fa fa-circle-o"></i> Lihat Selengkapnya</a></li>
                </ul>

              </li>
              <?php
              break;
          }
          ?>
          
        <?php 
        }else{ ?>

        <?php
        }
      ?>
        
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Struktur Pencarian</h4>
        </div>
        <div class="modal-body">
          <p><b>NamaField:NilaiField</b> <br>
          <b>NamaField</b> = kolom field yang akan dicari datanya, kolom field bisa dilihat pada menu field yang tersedia. <br>
          <b>NilaiField</b> = nilai yang akan dicari berdasarkan nama field.<br>
          contoh = nama:nita, penjelasannya yaitu mencari nilai nita pada kolom nama. 
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
        <!-- /.modal -->
