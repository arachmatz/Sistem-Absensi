<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controller;


use engine\abstraction\Controller;

class MataPelajaranController extends Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function create(){
        $this->response->view('help/index');
    }
    
    public function save(){
        // post(requestData,tipeData yang diinginkan(string,angka),validasi satuan(null,string,number))

        $kode_mapel = $this->request->post('kode_mapel');
        $nama_mapel = $this->request->post('nama_mapel');
        $jenis_mapel = $this->request->post('jenis_mapel');
        $keterangan_mapel = $this->request->post('keterangan_mapel');

        $tingkat_mapelArray = $this->request->post('tingkat_mapel');

        
        $exampleValidation = [
            'kode_mapel' => 'null',
            'nama_mapel' => 'null',
            'jenis_mapel' => 'null',
            'keterangan_mapel' => 'null',
            'tingkat_mapel' => 'null'
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);

        $tingkat_mapel = implode('_',$tingkat_mapelArray);
        
        $model = new \model\MataPelajaran();
        
        $model->fields = [$kode_mapel,$nama_mapel,$jenis_mapel,$keterangan_mapel,$tingkat_mapel];
        $model->save();
        
        $this->response->redirect('MataPelajaran/','data mata pelajaran berhasil ditambah');
        
    }
    
    function update() {
        $kode_mapel = $this->request->post('kode_mapel');
        
        $nama_mapel = $this->request->post('nama_mapel');
        $jenis_mapel = $this->request->post('jenis_mapel');
        $keterangan_mapel = $this->request->post('keterangan_mapel');

        $tingkat_mapelArray = $this->request->post('tingkat_mapel');
        
        $exampleValidation = [
            'nama_mapel' => 'null',
            'jenis_mapel' => 'null',
            'keterangan_mapel' => 'null',
            'tingkat_mapel' => 'null'
        ];

        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);

        $tingkat_mapel = implode('_',$tingkat_mapelArray);

        $model = new \model\MataPelajaran();
        
        $model->fields = [$kode_mapel,$nama_mapel,$jenis_mapel,$keterangan_mapel,$tingkat_mapel];
        $model->update($kode_mapel,'string');
        
        $this->response->redirect('MataPelajaran/','data mata pelajaran berhasil diperbarui');
    }
    
    function remove() {
        $id = $this->request->get(1);
        
        $model = new \model\MataPelajaran();
        
        $model->remove($id,'string');
        
        $this->response->redirect('MataPelajaran/','data mata pelajaran berhasil di hapus');
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
