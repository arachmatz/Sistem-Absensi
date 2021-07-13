<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace model;

use engine\abstraction\Model;

class Guru extends Model {

    /* 
	* Field yg di masukan ialah yang tidak mempunyai atribut Auto Increment
	* 
	* nilai set tetap ketika kelas model digunakan untuk save, edit dan hapus data. 
	* nilai set juga bisa diatur ulang diluar fungsi contruct, disesuaikan dengan kebutuhan 
	*/
    function __construct() {
        $this->initial();
        
		// set
        $this->setPrimaryKey('nip');
        
        $this->setTable("guru");
        
        $this->setField(['nip','nama_guru','tanggal_lahir_guru','jenis_kelamin_guru','alamat_guru','foto_guru']);
        
    }
}
