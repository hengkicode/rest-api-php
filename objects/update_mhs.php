<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/mahasiswa.php';

$database = new Database();
$dbname = $database->koneksi();

$mahasiswa = new Mahasiswa($dbname);

// get nim menggunkan file_get_contents
$data = json_decode(file_get_contents("php://input"));

$mahasiswa->nim = $data->nim;

// set property mahasiswa 
$mahasiswa->nama = $data->nama;
$mahasiswa->jenis_kelamin = $data->jenis_kelamin;
$mahasiswa->tempat_lahir = $data->tempat_lahir;
$mahasiswa->tanggal_lahir = $data->tanggal_lahir;
$mahasiswa->alamat = $data->alamat;

if ($mahasiswa->update_mhs()) {

    //format json yang dikirim ke client
    $respone = array(
        'messsage' => 'Update Success',
        'code' => http_response_code(200)

    );
} else {
    // set respone 400 'Bad Request' jika update gagal
    http_response_code(400);
    $respone = array(
        'messsage' => 'Update Failed',
        'code' => http_response_code()
    );
}
echo json_encode($respone);
