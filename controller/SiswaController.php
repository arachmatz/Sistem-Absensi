<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controller;


use engine\abstraction\Controller;

class SiswaController extends Controller{
    //put your code here
    protected $file;
    public function __construct() {
        parent::__construct();
        $this->file = new \engine\files\Files();
    }
    
    public function create(){
        $this->response->view('help/index');
    }
    
    public function save(){
        // post(requestData,tipeData yang diinginkan(string,angka),validasi satuan(null,string,number))

        $nis = $this->request->post('nis');
        $nama_siswa = $this->request->post('nama_siswa');
        $tanggal_lahir = $this->request->post('tanggal_lahir_siswa');
        $jenis_kelamin = $this->request->post('jenis_kelamin_siswa');
        $alamat = $this->request->post('alamat_siswa');
        $id_kelas = $this->request->post('id_kelas_siswa');

        $uploadFoto = $this->file->upload('foto',$nis.'_'.$nama_siswa.'_'.$id_kelas,"user/siswa/");


        $exampleValidation = [
            'nis' => 'null',
            'nama_siswa' => 'null',
            'jenis_kelamin_siswa' => 'null',
            'alamat_siswa' => 'null',
            'id_kelas_siswa' => 'null'
        ];
        
        $this->request->validation($exampleValidation);
        
        if($uploadFoto['pesan'] == ''){
            $model = new \model\Siswa();
            //['nis','nama_siswa','tanggal_lahir','jenis_kelamin','email','no_telepon','alamat','foto']
            $model->fields = [$nis,$nama_siswa,$tanggal_lahir,$jenis_kelamin,$alamat,$id_kelas,$uploadFoto['file']];
            $model->save();

            $tanggalLahir =str_replace("-","",$tanggal_lahir);

            $user = new \model\User();
            $user->fields = [$nama_siswa,$nis,$tanggalLahir,'Siswa'];
            $user->save();
            
            $this->response->redirect('Siswa/','data siswa berhasil ditambah');
        }else{
            $this->response->back($uploadFoto['pesan']);
        }
    }
    
    function update() {
        
        $nama_siswa = $this->request->post('nama_siswa');
        $tanggal_lahir = $this->request->post('tanggal_lahir_siswa');
        $jenis_kelamin = $this->request->post('jenis_kelamin_siswa');
        $alamat = $this->request->post('alamat_siswa');
        $id_kelas = $this->request->post('id_kelas_siswa');
        
        // var cek ganti gambar atau tidak
        $ubah_foto = $this->request->post('ubah_foto','null');

        $foto = "";

        $nis = $this->request->post('nis');
        
        if($ubah_foto == 'ganti'){
            $foto = $this->file->upload('ganti_foto',$nis.'_'.$nama_siswa.'_'.$id_kelas,"user/siswa/");
        }else if($ubah_foto == 'tidak'){
            $foto = $this->request->post('tidak_ganti','null');
        }
        
        $exampleValidation = [
            'nis' => 'null',
            'nama_siswa' => 'null',
            'tanggal_lahir_siswa' => 'null',
            'jenis_kelamin_siswa' => 'null',
            'alamat_siswa' => 'null',
            'id_kelas_siswa' => 'null'
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);
        
        $siswa = new \model\Siswa();

        // ganti
        if(is_array($foto)){
            if($foto['pesan'] == ''){
                $siswa->fields = [$nis,$nama_siswa,$tanggal_lahir,$jenis_kelamin,$alamat,$id_kelas,$foto['file']];
                $siswa->update($nis,'string');
    
                $tanggalLahir =str_replace("-","",$tanggal_lahir);
                $user = new \model\User();
                $user->setPrimaryKey('username');
                $user->fields = [$nama_siswa,$nis,$tanggalLahir,$tanggalLahir,"Siswa"];
                $user->update($nis,'string');
                  
                $this->response->redirect('Siswa/','data siswa berhasil diperbarui');
            }else{
               $this->response->back($foto['pesan']);
            }   
        // tidak
        }else{
            $siswa->fields = [$nis,$nama_siswa,$tanggal_lahir,$jenis_kelamin,$alamat,$id_kelas,$foto];
            $siswa->update($nis);

            $tanggalLahir =str_replace("-","",$tanggal_lahir);
            $user = new \model\User();
            $user->setPrimaryKey('username');
            $user->fields = [$nama_siswa,$nis,$tanggalLahir,"Siswa"];
            $user->update($nis);

            $this->response->redirect('Siswa/','data siswa berhasil diperbarui');
        }
    }

    function updateProfil() {
        
        $nama_siswa = $this->request->post('nama_siswa');
        $tanggal_lahir = $this->request->post('tanggal_lahir_siswa');
        $password = $this->request->post('password');
        $jenis_kelamin = $this->request->post('jenis_kelamin_siswa');
        $alamat = $this->request->post('alamat_siswa');
        $id_kelas = $this->request->post('id_kelas_siswa');
        
        // var cek ganti gambar atau tidak
        $ubah_foto = $this->request->post('ubah_foto','null');

        $foto = "";

        $nis = $this->request->post('nis');
        
        if($ubah_foto == 'ganti'){
            $foto = $this->file->upload('ganti_foto',$nis.'_'.$nama_siswa.'_'.$id_kelas,"user/siswa/");
        }else if($ubah_foto == 'tidak'){
            $foto = $this->request->post('tidak_ganti','null');
        }
        
        $exampleValidation = [
            'nis' => 'null',
            'nama_siswa' => 'null',
            'tanggal_lahir_siswa' => 'null',
            'jenis_kelamin_siswa' => 'null',
            'alamat_siswa' => 'null',
            'id_kelas_siswa' => 'null'
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);
        
        $siswa = new \model\Siswa();

        // ganti
        if(is_array($foto)){
            if($foto['pesan'] == ''){
                $siswa->fields = [$nis,$nama_siswa,$tanggal_lahir,$jenis_kelamin,$alamat,$id_kelas,$foto['file']];
                $siswa->update($nis,'string');
    
                $tanggalLahir =str_replace("-","",$tanggal_lahir);
                $user = new \model\User();
                $user->setPrimaryKey('username');
                $user->fields = [$nama_siswa,$nis,$password,$tanggalLahir,"Siswa"];
                $user->update($nis,'string');
                  
                $this->response->redirect('User/profile/','data siswa berhasil diperbarui');
            }else{
               $this->response->back($foto['pesan']);
            }   
        // tidak
        }else{
            $siswa->fields = [$nis,$nama_siswa,$tanggal_lahir,$jenis_kelamin,$alamat,$id_kelas,$foto];
            $siswa->update($nis);

            $tanggalLahir =str_replace("-","",$tanggal_lahir);
            $user = new \model\User();
            $user->setPrimaryKey('username');
            $user->fields = [$nama_siswa,$nis,$password,"Siswa"];
            $user->update($nis,'string');

            $this->response->redirect('User/profile/','data siswa berhasil diperbarui');
        }
    }
    
    function remove() {
        $id = $this->request->get(1);
        
        $siswa = new \model\Siswa();
        $user = new \model\User();
        $user->setPrimaryKey('username');

        $user->remove($id,'string');
        $siswa->remove($id,'string');
        $this->response->redirect('Siswa/','data siswa berhasil di hapus');
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
