<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/mahasiswa.php';

$database = new Database();
$dbname = $database->koneksi();

$mahasiswa = new mahasiswa($dbname);
$mahasiswa->nim = isset($_GET['nim']) ? $_GET['nim'] : die();

//memanggil query get_mhs byNim di class mahasiswa
$mahasiswa->get_byNim();

if ($mahasiswa->nama != null) {
    $mhs_byNim = array(
        'nim' => $mahasiswa->nim,
        'nama' => $mahasiswa->nama,
        'jenis_kelamin' => $mahasiswa->jenis_kelamin,
        'tempat_lahir' => $mahasiswa->tempat_lahir,
        'tanggal_lahir' => $mahasiswa->tanggal_lahir,
        'alamat' => $mahasiswa->alamat
    );

    $respone = array(
        'status' =>  array(
            'messsage' => 'Success', 'code' => (http_response_code(200))
        ), 'data' => $mhs_byNim
    );
} else {
    http_response_code(404);
    $respone = array(
        'status' =>  array(
            'messsage' => 'No Data Found', 'code' => http_response_code()
        )
    );
}
echo json_encode($respone);
