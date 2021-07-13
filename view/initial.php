<?php

/*
 * semua file yang digunakan di includekan pada file ini 
 * dari model controller dan getter, getter = class objek yang dibuat sendiri,
 * tata penulisannya,
 * "NamaKelas => directori pada file projek"
 */
class Initial{
    
    public $web = [
        'Model' => 'engine/abstraction',
        'Controller' => 'engine/abstraction',
        'BasicQuery' => 'engine/databases',
        'Database' => 'engine/databases',
        'Connection' => 'engine/databases',
        'QueryExp' => 'engine/databases',
        'DMLQuery' => 'engine/databases/order',
        
        'Response' => 'engine/http',
        'Request' => 'engine/http',
        'Route' => 'engine/http',
        'Session'=> 'engine/http',
        
        'ErrorCode'=>'engine/errors',
		'SessionError' => 'engine/errors',
        
		'Files' => 'engine/files',
		
        'Pagination'=>'engine/pagination',
        'filter'=>'engine/pagination',
		
        
        'JsonManipulation' => 'engine/utility',
        'ArrayManipulation' => 'engine/utility',
        'MysqlConnection' => 'engine/databases/driver',
        'PosgreConnection' => 'engine/databases/driver',
        'Acces' => 'view'
    ]; //endEngine
    
    /*
     * class model include
     * 
     */
    public $model = [
        'ModelExample' => 'model',
	'Siswa' => 'model',
	'User' => 'model',
	'Kelas' => 'model',
	'Guru' => 'model',
	'MataPelajaran' => 'model',
	'Jadwal' => 'model',
	'Absensi' => 'model'
    ];// endModel
    
    /*
     * class controller include
     */
    public $controller = [
        'ControllerExample' => 'controller',
 	'SiswaController' => 'controller',
 	'UserController' => 'controller',
 	'KelasController' => 'controller',
 	'GuruController' => 'controller',
 	'MataPelajaranController' => 'controller',
 	'JadwalController' => 'controller',
 	'AbsensiController' => 'controller'
    ]; // endController
    
    /*
     * class getter include
     */
    public $getter = [
        
    ];// endGetter
   
    
    public function addInitial($param) {
        
    }
}
?>