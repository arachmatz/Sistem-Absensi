<?php

/*
 * init variabel dengan variabel random
 * jika menampilkan data berdasarkan kategori tertentu
 * route->get(url, view, acces)
 * route->get(url data -> url default namaprojek/public/,
 *            tampilan yang ingin digunakan bisa dengan halaman web atau controller dengan fungsi view dari objek response,
 *              hak akses dari halaman tersebut -> default bisa akses oleh semua, ['nama session' => 'value'] or ['nama session' => ['value1','value2','valueN']]);
 * route->post(url, view, button, acces)
 * route->post(url data -> url default namaprojek/public/,
 *            tampilan yang ingin digunakan bisa dengan halaman web atau controller dengan fungsi view dari objek response, nama tombol submit dari form,
 *              hak akses dari halaman tersebut -> default bisa akses oleh semua, ['nama session' => 'value'] or ['nama session' => ['value1','value2','valueN']]);
 * 
 */

use engine\http\Route;
use engine\http\Response;
use engine\errors\ErrorCode;
use engine\errors\SessionError;

class Routing{
    public $routes,$response;
    
    public function __construct() {
        
        
        
        $this->routes = new Route();
        $this->response = new Response();
        
        $route = $this->routes;

        /*
        * set error location
		* page error = halaman error
		* lokasi error = folder lokasi error
        */
        ErrorCode::setPageError("error-configuration.php");
        ErrorCode::setLocationError("view");

		/*
        * set Session Error location 
        */
        SessionError::setLocationSession('logout/');

        /*
        * Add Route this
        */

       // homepage
       // homepage
       $route->get('', function ($id){
        $id['halaman'] = '';
        $id['halamanAktif'] = 'Home';

        $this->response->view('index',$id);
    },["hak_akses" => ["Guru","Siswa","Admin","WaliKelas"]]);

       // login
    $route->get('User/Login/',function($id){
        $id['halaman'] = '/ > ';

        $this->response->view('Pages/login',$id);
    });

    
    $route->post('login/',function($id){
        $id['halaman'] = 'login/';

        $this->response->view('UserController&login',$id);
    },'submit');

    // logout
    $route->get('logout/',function($id){
        $id['halaman'] = 'page/login/';

        $this->response->view('UserController&logout',$id);
    });

    // Siswa
    $route->get('Siswa/', function ($id){
        $id['halaman'] = '/ > Siswa > ';
        $id['halamanAktif'] = 'Home';

        $this->response->view('Siswa/index',$id);
    },["hak_akses" => ["Admin"]]);

    $route->get('Siswa/page/(id)/', function ($id){
        $id['halaman'] = '/ > Siswa > ';
        $id['halamanAktif'] = 'Home';

        $this->response->view('Siswa/index',$id);
    },["hak_akses" => ["Admin"]]);

    $route->get('Siswa/add/', function ($id){
        $id['halaman'] = '/ > Siswa > ';
        $id['halamanAktif'] = 'Form Tambah';

        $this->response->view('Siswa/form-input',$id);
    },["hak_akses" => ["Admin"]]);

    $route->post('addSiswa/', function ($id){
        $id['halaman'] = 'Siswa/';

        $this->response->view('SiswaController&save',$id);
    },'submit');

    $route->get('Siswa/update/(id)/', function ($id){
        $id['halaman'] = '/ > Siswa > ';
        $id['halamanAktif'] = 'Form Perbarui';

        $this->response->view('Siswa/form-perbarui',$id);
    },["hak_akses" => ["Admin"]]);

    $route->post('updateSiswa/', function ($id){
        $id['halaman'] = 'Siswa/';

        $this->response->view('SiswaController&update',$id);
    },'submit');

    $route->get('removeSiswa/(id)/', function ($id){
        $id['halaman'] = 'Siswa/';

        $this->response->view('SiswaController&remove',$id);
    },["hak_akses" => ["Admin"]]);

    $route->get('Siswa/updateProfil/(id)/', function ($id){
        $id['halaman'] = '/ > Siswa > ';
        $id['halamanAktif'] = 'Form Perbarui';

        $this->response->view('Siswa/perbarui-profil-siswa',$id);
    });

    $route->post('updateSiswaProfil/', function ($id){
        $id['halaman'] = 'Siswa/';

        $this->response->view('SiswaController&updateProfil',$id);
    },'submit');

    // Kelas
    $route->get('Kelas/', function ($id){
        $id['halaman'] = '/ > Kelas > ';
        $id['halamanAktif'] = 'Home';

        $this->response->view('Kelas/index',$id);
    },["hak_akses" => ["Admin"]]);

    $route->get('Kelas/page/(id)/', function ($id){
        $id['halaman'] = '/ > Kelas > ';
        $id['halamanAktif'] = 'Home';

        $this->response->view('Kelas/index',$id);
    },["hak_akses" => ["Admin"]]);

    $route->get('Kelas/add/', function ($id){
        $id['halaman'] = '/ > Kelas > ';
        $id['halamanAktif'] = 'Form Tambah';

        $this->response->view('Kelas/form-input',$id);
    },["hak_akses" => ["Admin"]]);

    $route->post('addKelas/', function ($id){
        $id['halaman'] = 'Kelas/';

        $this->response->view('KelasController&save',$id);
    },'submit');

    $route->get('Kelas/update/(id)/', function ($id){
        $id['halaman'] = '/ > Kelas > ';
        $id['halamanAktif'] = 'Form Perbarui';

        $this->response->view('Kelas/form-perbarui',$id);
    },["hak_akses" => ["Admin"]]);

    $route->post('updateKelas/', function ($id){
        $id['halaman'] = 'Kelas/';

        $this->response->view('KelasController&update',$id);
    },'submit');

    $route->get('removeKelas/(id)/', function ($id){
        $id['halaman'] = 'Kelas/';

        $this->response->view('KelasController&remove',$id);
    },["hak_akses" => ["Admin"]]);

    // Guru
    $route->get('Guru/', function ($id){
        $id['halaman'] = '/ > Guru > ';
        $id['halamanAktif'] = 'Home';

        $this->response->view('Guru/index',$id);
    },["hak_akses" => ["Admin"]]);

    $route->get('Guru/page/(id)/', function ($id){
        $id['halaman'] = '/ > Guru > ';
        $id['halamanAktif'] = 'Home';

        $this->response->view('Guru/index',$id);
    },["hak_akses" => ["Admin"]]);

    $route->get('Guru/add/', function ($id){
        $id['halaman'] = '/ > Guru > ';
        $id['halamanAktif'] = 'Form Tambah';

        $this->response->view('Guru/form-input',$id);
    },["hak_akses" => ["Admin"]]);

    $route->post('addGuru/', function ($id){
        $id['halaman'] = 'Guru/';

        $this->response->view('GuruController&save',$id);
    },'submit');

    $route->get('Guru/update/(id)/', function ($id){
        $id['halaman'] = '/ > Guru > ';
        $id['halamanAktif'] = 'Form Perbarui';

        $this->response->view('Guru/form-perbarui',$id);
    },["hak_akses" => ["Admin"]]);

    $route->post('updateGuru/', function ($id){
        $id['halaman'] = 'Guru/';

        $this->response->view('GuruController&update',$id);
    },'submit');

    $route->get('removeGuru/(id)/', function ($id){
        $id['halaman'] = 'Guru/';

        $this->response->view('GuruController&remove',$id);
    },["hak_akses" => ["Admin"]]);

    $route->get('Guru/updateProfil/(id)/', function ($id){
        $id['halaman'] = '/ > Guru > ';
        $id['halamanAktif'] = 'Form Profil';

        $this->response->view('Guru/perbarui-profil-guru',$id);
    });

    $route->post('updateGuruProfil/', function ($id){
        $id['halaman'] = 'Guru/';

        $this->response->view('GuruController&updateProfil',$id);
    },'submit');

     // MataPelajaran
     $route->get('MataPelajaran/', function ($id){
        $id['halaman'] = '/ > MataPelajaran > ';
        $id['halamanAktif'] = 'Home';

        $this->response->view('MataPelajaran/index',$id);
    },["hak_akses" => ["Admin"]]);

    $route->get('MataPelajaran/page/(id)/', function ($id){
        $id['halaman'] = '/ > MataPelajaran > ';
        $id['halamanAktif'] = 'Home';

        $this->response->view('MataPelajaran/index',$id);
    },["hak_akses" => ["Admin"]]);

    $route->get('MataPelajaran/add/', function ($id){
        $id['halaman'] = '/ > MataPelajaran > ';
        $id['halamanAktif'] = 'Form Tambah';

        $this->response->view('MataPelajaran/form-input',$id);
    },["hak_akses" => ["Admin"]]);

    $route->post('addMataPelajaran/', function ($id){
        $id['halaman'] = 'MataPelajaran/';

        $this->response->view('MataPelajaranController&save',$id);
    },'submit');

    $route->get('MataPelajaran/update/(id)/', function ($id){
        $id['halaman'] = '/ > MataPelajaran > ';
        $id['halamanAktif'] = 'Form Perbarui';

        $this->response->view('MataPelajaran/form-perbarui',$id);
    },["hak_akses" => ["Admin"]]);

    $route->post('updateMataPelajaran/', function ($id){
        $id['halaman'] = 'MataPelajaran/';

        $this->response->view('MataPelajaranController&update',$id);
    },'submit');

    $route->get('removeMataPelajaran/(id)/', function ($id){
        $id['halaman'] = 'MataPelajaran/';

        $this->response->view('MataPelajaranController&remove',$id);
    },["hak_akses" => ["Admin"]]);

    // User
    $route->get('User/', function ($id){
        $id['halaman'] = '/ > User > ';
        $id['halamanAktif'] = 'Home';

        $this->response->view('User/index',$id);
    },["hak_akses" => ["Admin"]]);

    $route->get('User/page/(id_page)/', function ($id){
        $id['halaman'] = '/ > User > ';
        $id['halamanAktif'] = 'Home';

        $this->response->view('User/index',$id);
    },["hak_akses" => ["Admin"]]);

    $route->get('User/add/', function ($id){
        $id['halaman'] = '/ > User > ';
        $id['halamanAktif'] = 'Form Tambah';

        $this->response->view('User/form-input',$id);
    },["hak_akses" => ["Admin"]]);

    $route->post('addUser/', function ($id){
        $id['halaman'] = 'User/';

        $this->response->view('UserController&save',$id);
    },'submit');

    $route->get('removeUser/(id)/', function ($id){
        $id['halaman'] = 'User/';

        $this->response->view('UserController&remove',$id);
    },["hak_akses" => ["Admin"]]);

    $route->get('User/profile/', function ($id){
        $id['halaman'] = '/ > User > ';
        $id['halamanAktif'] = 'User-Profile';

        $this->response->view('User/user-profile',$id);
    });

    $route->get('User/update/(id)/', function ($id){
        $id['halaman'] = '/ > User > ';
        $id['halamanAktif'] = 'Form Tambah';

        $this->response->view('User/form-perbarui',$id);
    },["hak_akses" => ["Admin"]]);

    $route->post('updateUser/', function ($id){
        $id['halaman'] = 'User/';

        $this->response->view('UserController&update',$id);
    },'submit');

    // Jadwal
    $route->get('Jadwal/', function ($id){
        $id['halaman'] = '/ > Jadwal > ';
        $id['halamanAktif'] = 'Home';

        $this->response->view('Jadwal/index',$id);
    },["hak_akses" => ["Guru","Siswa","Admin","WaliKelas"]]);

    $route->get('Jadwal/page/(id)/', function ($id){
        $id['halaman'] = '/ > Jadwal > ';
        $id['halamanAktif'] = 'Home';

        $this->response->view('Jadwal/index',$id);
    },["hak_akses" => ["Guru","Siswa","Admin","WaliKelas"]]);

    $route->get('Jadwal/add/', function ($id){
        $id['halaman'] = '/ > Jadwal > ';
        $id['halamanAktif'] = 'Form Tambah';

        $this->response->view('Jadwal/form-input',$id);
    },["hak_akses" => ["Admin"]]);

    $route->post('memilihJadwal/', function ($id){
        $id['halaman'] = 'Jadwal/';

        $this->response->view('JadwalController&memilih',$id);
    },'memilih');

    $route->get('Jadwal/add/(idKelas)/(kodeMapel)/', function ($id){
        $id['halaman'] = '/ > Jadwal > ';
        $id['halamanAktif'] = 'Form Tambah';

        $this->response->view('Jadwal/form-input',$id);
    },["hak_akses" => ["Admin"]]);

    $route->post('addJadwal/', function ($id){
        $id['halaman'] = 'Jadwal/';

        $this->response->view('JadwalController&save',$id);
    },'submit');

    $route->get('Jadwal/update/(id)/', function ($id){
        $id['halaman'] = '/ > Jadwal > ';
        $id['halamanAktif'] = 'Form Perbarui';

        $this->response->view('Jadwal/form-perbarui',$id);
    },["hak_akses" => ["Admin"]]);

    $route->post('updateJadwal/', function ($id){
        $id['halaman'] = 'Jadwal/';

        $this->response->view('JadwalController&update',$id);
    },'submit');

    $route->get('removeJadwal/(id)/', function ($id){
        $id['halaman'] = 'Jadwal/';

        $this->response->view('JadwalController&remove',$id);
    },["hak_akses" => ["Admin"]]);

    // Absensi
    $route->get('Absensi/', function ($id){
        $id['halaman'] = '/ > Absensi > ';
        $id['halamanAktif'] = 'Home';

        $this->response->view('Absensi/index',$id);
    },["hak_akses" => ["Guru","Siswa","Admin","WaliKelas"]]);

    $route->get('Absensi/report/', function ($id){
        $id['halaman'] = '/ > Absensi > ';
        $id['halamanAktif'] = 'Report';

        $this->response->view('Absensi/laporan',$id);
    },["hak_akses" => ["Guru","Siswa","Admin","WaliKelas"]]);

    $route->get('Absensi/page/(id)/', function ($id){
        $id['halaman'] = '/ > Absensi > ';
        $id['halamanAktif'] = 'Home';

        $this->response->view('Absensi/index',$id);
    },["hak_akses" => ["Guru","Siswa","Admin","WaliKelas"]]);

    $route->get('Absensi/add/', function ($id){
        $id['halaman'] = '/ > Absensi > ';
        $id['halamanAktif'] = 'Form Tambah';

        $this->response->view('Absensi/form-input',$id);
    },["hak_akses" => ["Guru","Admin","WaliKelas"]]);

    $route->get('Absensi/validasi/', function ($id){
        $id['halaman'] = '/ > Absensi > ';
        $id['halamanAktif'] = 'Form Validasi';

        $this->response->view('Absensi/form-validasi-absen',$id);
    },["hak_akses" => ["Siswa"]]);

    $route->get('Absensi/validasi/jam/(id_jam)/', function ($id){
        $id['halaman'] = '/ > Absensi > ';
        $id['halamanAktif'] = 'Form Validasi';

        $this->response->view('Absensi/form-validasi-absen',$id);
    },["hak_akses" => ["Siswa"]]);

    $route->get('Absensi/add/tanggal/(id)/jam/(id_jam)/', function ($id){
        $id['halaman'] = '/ > Absensi > ';
        $id['halamanAktif'] = 'Form Tambah';

        $this->response->view('Absensi/form-input',$id);
    },["hak_akses" => ["Guru","Siswa","Admin","WaliKelas"]]);

    $route->post('addAbsensi/', function ($id){
        $id['halaman'] = 'Absensi/';

        $this->response->view('AbsensiController&save',$id);
    },'mulai');

    $route->post('cekAbsensi/', function ($id){
        $id['halaman'] = 'Absensi/';

        $this->response->view('AbsensiController&validasi',$id);
    },'cek');

    $route->post('absenHadir/', function ($id){
        $id['halaman'] = '/ > Absensi > ';
        $id['halamanAktif'] = 'Form Perbarui';

        $this->response->view('AbsensiController&hadir',$id);
    },'absen');

    $route->post('absenIzin/', function ($id){
        $id['halaman'] = '/ > Absensi > ';
        $id['halamanAktif'] = 'Form Perbarui';

        $this->response->view('AbsensiController&izin',$id);
    },'absen');

    $route->post('absenSakit/', function ($id){
        $id['halaman'] = '/ > Absensi > ';
        $id['halamanAktif'] = 'Form Perbarui';

        $this->response->view('AbsensiController&sakit',$id);
    },'absen');

    $route->post('absenAlpha/', function ($id){
        $id['halaman'] = '/ > Absensi > ';
        $id['halamanAktif'] = 'Form Perbarui';

        $this->response->view('AbsensiController&alpha',$id);
    },'absen');

    $route->get('Absensi/update/(id)/', function ($id){
        $id['halaman'] = '/ > Absensi > ';
        $id['halamanAktif'] = 'Form Perbarui';

        $this->response->view('Absensi/form-perbarui',$id);
    },["hak_akses" => ["Guru","Siswa","Admin","WaliKelas"]]);

    $route->post('updateAbsensi/', function ($id){
        $id['halaman'] = 'Absensi/';

        $this->response->view('AbsensiController&update',$id);
    },'submit');

    $route->get('removeAbsensi/(id)/', function ($id){
        $id['halaman'] = 'Absensi/';

        $this->response->view('AbsensiController&remove',$id);
    },["hak_akses" => ["Guru","Siswa","Admin","WaliKelas"]]);

       /*
       $route->get('Mahasiswa/add/', function ($array){
           $array['id'] = 1;
           $array['sort'] = 'mhsID';
           $array['type'] = 'ASC';
           $this->response->view('home/Mahasiswa/formInput');
       },['name' => ['dwi']]);
       
       $route->post('addMahasiswa/', function (){
           $this->response->view('MahasiswaController&store');
       },'submit');


       $route->get('Mahasiswa/perbarui/(id)/', function ($array){
           $array['id'] = 1;
           $array['sort'] = 'mhsID';
           $array['type'] = 'ASC';
           $this->response->view('home/Mahasiswa/formPerbarui',$array);
       });
       
       $route->post('perbaruiMahasiswa/', function (){
           $this->response->view('MahasiswaController&update');
       },'submit');
       
       $route->get('hapusMahasiswa/(id)/', function ($array){
           $this->response->view('MahasiswaController&remove',$array);
       });

       $route->post('searchForm/', function (){
           $response->view('ControllerExample&search');
       },'search');
       */
       



       // End added route

       $route->checkRoute();
    }
}
?>