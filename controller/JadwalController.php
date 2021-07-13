<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controller;


use engine\abstraction\Controller;

class JadwalController extends Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function create(){
        $this->response->view('help/index');
    }
    
    public function save(){
        // post(requestData,tipeData yang diinginkan(string,angka),validasi satuan(null,string,number))

        $hari = $this->request->post('hari');
        $jam = $this->request->post('jam');
        
        $id_kelas = $this->request->post('id_kelas');
        $kode_mapel = $this->request->post('kode_mapel');
        $nip = $this->request->post('nip');

        $exampleValidation = [
            'id_kelas' => 'null',
            'kode_mapel' => 'null',
            'hari' => 'null',
            'jam' => 'null'
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);
        
        $jadwal = new \model\Jadwal();
        $jadwal->select($jadwal->getTable())->where()
        ->comparing('id_kelas_jadwal',$id_kelas)
        ->and()->comparing('hari',$hari)
        ->and()->comparing('jam',$jam)->ready();

        if($jadwal->getStatement()->rowCount()){
            $this->response->redirect('Jadwal/','hari dan jam sudah terdaftar oleh jadwal yang lain');
        }else{
            $model = new \model\Jadwal();
            $model->fields = [$hari,$jam,$id_kelas,$kode_mapel,$nip];
            $model->save();

            $this->response->redirect('Jadwal/','data jadwal berhasil ditambah');
        }
        
    }
    
    function update() {
        $id_jadwal = $this->request->post('id_jadwal');

        $hari = $this->request->post('hari');
        $jam = $this->request->post('jam');
        
        $id_kelas = $this->request->post('id_kelas');
        $kode_mapel = $this->request->post('kode_mapel');
        $nip = $this->request->post('nip');

        $exampleValidation = [
            'id_kelas' => 'null',
            'kode_mapel' => 'null',
            'hari' => 'null',
            'jam' => 'null'
        ];
        
        // validasi dengan data kelompok
        $this->request->validation($exampleValidation);
        
        $model = new \model\Jadwal();
        
        $model->fields = [$hari,$jam,$id_kelas,$kode_mapel,$nip];
        $model->update($id_jadwal,'string');
        
        $this->response->redirect('Jadwal/','data jadwal berhasil diperbarui');
    }
    
    function remove() {
        $id = $this->request->get(1);
        
        $model = new \model\Jadwal();
        
        $model->remove($id);
        
        $this->response->redirect('Jadwal/','data berhasil di hapus');
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
