<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controller;


use engine\abstraction\Controller;

class AbsensiController extends Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function create(){
        $this->response->view('help/index');
    }
    
    public function save(){
        // post(requestData,tipeData yang diinginkan(string,angka),validasi satuan(null,string,number))
        $tanggal_hari_ini = date('Y-m-d');

        $tanggal_absen = date('Y-m-d h:i:s');

        $nip = $this->request->post('nip');
        $hari = $this->request->post('hari');
        $jam = $this->request->post('jam');
        
        $exampleValidation = [
            'nip' => 'null',
            'hari' => 'null',
            'jam' => 'null'
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);
        
        // 
        $jadwal = new \model\Jadwal();
        $jadwal->select($jadwal->getTable())
        ->join('mata_pelajaran','jadwal.kode_mapel_jadwal','mata_pelajaran.kode_mapel')
        ->join('guru','jadwal.nip_jadwal','guru.nip')
        ->where()->comparing('nip',$nip)
        ->and()->comparing('hari',$hari)
        ->and()->comparing('jam',$jam)->ready();

        $row = $jadwal->getStatement()->fetch();

        if($jadwal->getStatement()->rowCount() == 0){
            $this->response->back('Jadwal tidak tersedia');
        }else{
            $id_kelas = $row['id_kelas_jadwal'];

            $absensi = new \model\Absensi();
            $absensi->select($absensi->getTable())->where()->comparing("id_jadwal_absensi",$row['id_jadwal'])->ready();

            $rowAbsen = $absensi->getStatement()->fetch();
            $tanggal = explode(' ',$rowAbsen['tanggal_absensi']);

            // init siswa berdasarkan kelas
            $siswa = new \model\Siswa();
            $siswa->select($siswa->getTable())->where()->comparing('id_kelas_siswa',$id_kelas)->ready();

            if($absensi->getStatement()->rowCount() != 0){
                if($tanggal[0] == $tanggal_hari_ini){
                    $this->response->redirect("Absensi/add/tanggal/$tanggal_hari_ini/jam/$jam/",'Absensi sudah dibuat');
                }else{
                    $absensi = new \model\Absensi();
                    while ($rowSiswa = $siswa->getStatement()->fetch()) {
                        $absensi->field =[$tanggal_absen,'O','terbuka',$row['id_jadwal'],$rowSiswa['nis']];
                        $absensi->save();    
                    }
                    
                    $this->response->redirect("Absensi/add/tanggal/$tanggal_hari_ini/jam/$jam/",'Absensi berhasil dibuat');
                }
            }else{
                $absensi = new \model\Absensi();
                while($rowSiswa = $siswa->getStatement()->fetch()) {
                    $absensi->fields =[$tanggal_absen,'O','terbuka',$row['id_jadwal'],$rowSiswa['nis']];
                    $absensi->save();    
                }

                $this->response->redirect("Absensi/add/tanggal/$tanggal_hari_ini/jam/$jam/",'Absensi berhasil dibuat');
            }        
        }
    }

    function validasi(){
        $jam = $this->request->post('jam');

        $exampleValidation = [
            'jam' => 'null'
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);

        $this->response->redirect("Absensi/validasi/jam/$jam/");
    }

    function hadir(){
        $id_absensi = $this->request->post('id_absensi');
        $nis_absensi = $this->request->post('nis');

        $exampleValidation = [
            
        ];
        

        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);

        $absensi = new \model\Absensi();
        $absensi->setField(['keterangan_absensi']);

        $absensi->fields = ['H'];
        $absensi->update($id_absensi);
        $this->response->redirect("Absensi/","absensi dengan nis $nis berhasil diperbarui");
    }

    function izin(){
        $id_absensi = $this->request->post('id_absensi');
        $nis_absensi = $this->request->post('nis_absensi');

        $exampleValidation = [
            
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);

        $absensi = new \model\Absensi();
        $absensi->setField(['keterangan_absensi']);

        $absensi->fields = ['I'];
        $absensi->update($id_absensi);
        $this->response->redirect("Absensi/","absensi dengan nis $nis berhasil diperbarui");
    }

    function sakit(){
        $id_absensi = $this->request->post('id_absensi');
        $nis_absensi = $this->request->post('nis_absensi');

        $exampleValidation = [
            
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);

        $absensi = new \model\Absensi();
        $absensi->setField(['keterangan_absensi']);

        $absensi->fields = ['S'];
        $absensi->update($id_absensi);
        $this->response->redirect("Absensi/","absensi dengan nis $nis berhasil diperbarui");
    }

    function alpha(){
        $id_absensi = $this->request->post('id_absensi');
        $nis_absensi = $this->request->post('nis_absensi');

        $exampleValidation = [
            
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);

        $absensi = new \model\Absensi();
        $absensi->setField(['keterangan_absensi']);

        $absensi->fields = ['A'];
        $absensi->update($id_absensi);
        $this->response->redirect("Absensi/","absensi dengan nis $nis berhasil diperbarui");
    }
    
    function update() {
        $id = $this->request->post('id','null');
        $namaDepan = $this->request->post('namaDepan','null');
        $namaBelakang = $this->request->post('namaBelakang','null');
        $umur = $this->request->post('umur','number');
        
        $model = new ModelExample();
        
        $model->fields = [$namaDepan,$namaBelakang,$umur];
        $model->update($id);
        
        $this->response->redirect('help/','data berhasil diperbarui');
    }
    
    function remove() {
        $id = $this->request->get(1);
        
        $absensi = new \model\Absensi();
        
        $absensi->remove($id);
        
        $this->response->redirect('Absensi/','data berhasil di hapus');
    }

    function memilih(){
        $id_kelas = $this->request->post('id_kelas');
        $kode_mapel = $this->request->post('kode_mapel');

        $exampleValidation = [
            'id_kelas' => 'null',
            'kode_mapel' => 'null'
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);

        $jadwal = new \model\Jadwal();
        $jadwal->select($jadwal->getTable())->where()->comparing('id_kelas_jadwal',$id_kelas)
        ->and()->comparing('kode_mapel_jadwal',$kode_mapel)->ready();

        if($jadwal->getStatement()->rowCount()){ 
            $this->response->redirect('Jadwal/add/'.$id_kelas.'/'.$kode_mapel.'/',"Mata pelajaran dan id kelas telah terdaftar dijadwal");
        }else{
            $this->response->redirect('Jadwal/add/'.$id_kelas.'/'.$kode_mapel.'/');
        }
    }
    
    function search() {
        $colom = $this->request->post('sort','mhsID');
        $type = $this->request->post('type','ASC');
        
        echo $colom;
        echo $type;
        
        $this->response->redirect('help/1/column/'.$colom.'/tipe/'.$type.'/');
    }
	
	function login(){
        
        $username = $this->request->post('email','null');
        $password = $this->request->post('password','null');

        $user = new \model\User();

        $user->select($user->getTable())->where()->comparing("username",$username)->ready();

        $row = $user->getStatement()->fetch();

        if($row){
            
            $user = new \model\User();
            $user->select($user->getTable())->where()->comparing("username",$username)
            ->and()->comparing("password",$password)->ready();

            $rowWithPassword = $user->getStatement()->fetch();

            if($rowWithPassword){

                $pegawai = new \model\Pegawai();
                $pegawai->select($pegawai->getTable())->where()
                ->comparing("nip",$rowWithPassword['nip'])->ready();

                $rowPegawai = $pegawai->getStatement()->fetch();

                $this->session->set('hak_akses',$rowWithPassword['hak_akses']);

                $this->session->set('nip',$rowPegawai['nip']);
                $this->session->set('nama_pegawai',$rowPegawai['nama_pegawai']);
                $this->session->set('gambar',$rowPegawai['foto']);
                
                $this->response->redirect('');
            }else{
                $this->response->back('password yang dimasukan salah');
            }
        }else{
            $this->response->back('username tidak ditemukan');
        }
    }

    function logout(){
        session_destroy();

        $this->response->redirect('User/Login/');
    }
    
}
