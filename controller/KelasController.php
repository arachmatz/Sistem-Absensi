<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controller;


use engine\abstraction\Controller;

class KelasController extends Controller{
    //put your code here
    protected $file;
    public function __construct() {
        parent::__construct();
        
    }
    
    public function create(){
        $this->response->view('help/index');
    }
    
    public function save(){
        // post(requestData,tipeData yang diinginkan(string,angka),validasi satuan(null,string,number))

        $id_kelas = $this->request->post('id_kelas');
        $nama_kelas = $this->request->post('nama_kelas');
        $wali_kelas = $this->request->post('wali_kelas');
        
        $exampleValidation = [
            'id_kelas' => 'null',
            'nama_kelas' => 'null'
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);
        
        $model = new \model\Kelas();
        
        $model->fields = [$id_kelas,$nama_kelas,$wali_kelas];
        $model->save();

        if($wali_kelas != ''){
            $user = new \model\User();
            $user->select($user->getTable())->ready();
            $user->setField(['hak_akses']);

            $user->fields(['WaliKelas']);
            $user->setPrimaryKey('username');
            $user->update($wali_kelas,'string');
        }
        
        $this->response->redirect('Kelas/','data kelas berhasil ditambah');
        
    }
    
    function update() {
        $id_kelas = $this->request->post('id_kelas');
        
        $nama_Kelas = $this->request->post('nama_kelas');
        $wali_kelas = $this->request->post('wali_kelas');
        
        $exampleValidation = [
            'nama_kelas' => 'null'
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);
        
        $model = new \model\Kelas();
        $model->select($model->getTable())->where()->comparing('id_kelas',$id_kelas)->ready();
        $rowKelas = $model->getStatement()->fetch();

        if($wali_kelas != ''){
            $user = new \model\User();

            // mengganti hak akses wali kelas menjadi guru
            $user->setField(['hak_akses']);
            $user->fields = ['Guru'];
            $user->setPrimaryKey('username');
            $user->update($rowKelas['wali_kelas'],'string');

            // mengganti hak akses guru menjadi wali kelas
            $user->fields = ['WaliKelas'];
            $user->update($wali_kelas,'string');
        }

        $model->fields = [$id_kelas,$nama_Kelas,$wali_kelas];
        $model->update($id_kelas,'string');
        
        $this->response->redirect('Kelas/','data kelas berhasil diperbarui');
    }
    
    function remove() {
        $id = $this->request->get(1);
        
        $model = new \model\Kelas();

        $siswa = new \model\Siswa();
        $siswa->setPrimaryKey('id_kelas_siswa');
        $siswa->remove($id,'string');

        $model->remove($id,'string');
        
        $this->response->redirect('Kelas/','data kelas dan siswa dengan kelas '.$id.' berhasil di hapus');
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
