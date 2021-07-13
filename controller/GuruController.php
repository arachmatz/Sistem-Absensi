<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controller;


use engine\abstraction\Controller;

class GuruController extends Controller{
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

        $nip = $this->request->post('nip');
        $nama_guru = $this->request->post('nama_guru');
        $tanggal_lahir = $this->request->post('tanggal_lahir_guru');
        $jenis_kelamin = $this->request->post('jenis_kelamin_guru');
        $alamat = $this->request->post('alamat_guru');

        $uploadFoto = $this->file->upload('foto',$nip.'_'.$nama_guru,"user/guru/");


        $exampleValidation = [
            'nip' => 'null',
            'nama_guru' => 'null',
            'alamat_guru' => 'null'
        ];
        
        $this->request->validation($exampleValidation);
        
        if($uploadFoto['pesan'] == ''){
            $model = new \model\Guru();
            //['nip','nama_Guru','tanggal_lahir','jenis_kelamin','email','no_telepon','alamat','foto']
            $model->fields = [$nip,$nama_guru,$tanggal_lahir,$jenis_kelamin,$alamat,$uploadFoto['file']];
            $model->save();

            $tanggalLahir =str_replace("-","",$tanggal_lahir);

            $user = new \model\User();
            $user->fields = [$nama_guru,$nip,$tanggalLahir,'Guru'];
            $user->save();
            
            
            $this->response->redirect('Guru/','data guru berhasil ditambah');
        }else{
            $this->response->back($uploadFoto['pesan']);
        }
    }
    
    function update() {
        
        $nama_guru = $this->request->post('nama_guru');
        $tanggal_lahir = $this->request->post('tanggal_lahir_guru');
        $jenis_kelamin = $this->request->post('jenis_kelamin_guru');
        $alamat = $this->request->post('alamat_guru');

        
        // var cek ganti gambar atau tidak
        $ubah_foto = $this->request->post('ubah_foto','null');

        $foto = "";

        $nip = $this->request->post('nip');
        
        if($ubah_foto == 'ganti'){
            $foto = $this->file->upload('ganti_foto',$nip.'_'.$nama_guru,"user/guru/");
        }else if($ubah_foto == 'tidak'){
            $foto = $this->request->post('tidak_ganti','null');
        }
        
        $exampleValidation = [
            'nama_guru' => 'null',
            'alamat_guru' => 'null'
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);
        
        $Guru = new \model\Guru();

        // ganti
        if(is_array($foto)){
            if($foto['pesan'] == ''){
                $Guru->fields = [$nip,$nama_guru,$tanggal_lahir,$jenis_kelamin,$alamat,$foto['file']];
                $Guru->update($nip,'string');
    
                $tanggalLahir =str_replace("-","",$tanggal_lahir);
                $user = new \model\User();
                $user->setPrimaryKey('username');
                $user->fields = [$nama_guru,$username,$tanggalLahir,"Guru"];
                $user->update($nip,'string');
                
                
                $this->response->redirect('Guru/','data berhasil diperbarui');
            }else{
               $this->response->back($foto['pesan']);
            }   
        // tidak
        }else{
            echo $foto;
            $Guru->fields = [$nip,$nama_guru,$tanggal_lahir,$jenis_kelamin,$alamat,$foto];
            $Guru->update($nip,'string');

            $tanggalLahir =str_replace("-","",$tanggal_lahir);
            $user = new \model\User();
            $user->setPrimaryKey('username');
            $user->fields = [$nama_guru,$nip,$password,"Guru"];
            $user->update($nip);

            $this->response->redirect('Guru/','data guru berhasil diperbarui');
        }
    }
    
    function updateProfil() {
        
        $nama_guru = $this->request->post('nama_guru');
        $tanggal_lahir = $this->request->post('tanggal_lahir_guru');
        $password = $this->request->post('password');
        $jenis_kelamin = $this->request->post('jenis_kelamin_guru');
        $alamat = $this->request->post('alamat_guru');

        
        // var cek ganti gambar atau tidak
        $ubah_foto = $this->request->post('ubah_foto','null');

        $foto = "";

        $nip = $this->request->post('nip');
        
        if($ubah_foto == 'ganti'){
            $foto = $this->file->upload('ganti_foto',$nip.'_'.$nama_guru,"user/guru/");
        }else if($ubah_foto == 'tidak'){
            $foto = $this->request->post('tidak_ganti','null');
        }
        
        $exampleValidation = [
            'nama_guru' => 'null',
            'alamat_guru' => 'null'
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);
        
        $Guru = new \model\Guru();

        // ganti
        if(is_array($foto)){
            if($foto['pesan'] == ''){
                $Guru->fields = [$nip,$nama_guru,$tanggal_lahir,$jenis_kelamin,$alamat,$foto['file']];
                $Guru->update($nip,'string');
    
                $tanggalLahir =str_replace("-","",$tanggal_lahir);
                $user = new \model\User();
                $user->setPrimaryKey('username');
                $user->fields = [$nama_guru,$username,$password,"Guru"];
                $user->update($nip,'string');
                
                
                $this->response->redirect('User/profile/','data berhasil diperbarui');
            }else{
               $this->response->back($foto['pesan']);
            }   
        // tidak
        }else{
            echo $foto;
            $Guru->fields = [$nip,$nama_guru,$tanggal_lahir,$jenis_kelamin,$alamat,$foto];
            $Guru->update($nip,'string');

            $tanggalLahir =str_replace("-","",$tanggal_lahir);
            $user = new \model\User();
            $user->setPrimaryKey('username');
            $user->fields = [$nama_guru,$nip,$password,"Guru"];
            $user->update($nip,'string');

            $this->response->redirect('User/profile/','data guru berhasil diperbarui');
        }
    }

    function remove() {
        $id = $this->request->get(1);
        
        $Guru = new \model\Guru();
        $user = new \model\User();
        $user->setPrimaryKey('username');
        $user->remove($id,'string');
        $Guru->remove($id,'string');

        $this->response->redirect('Guru/','data guru berhasil di hapus');
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
