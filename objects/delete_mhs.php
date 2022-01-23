<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/mahasiswa.php';

$database = new Database();
$dbname = $database->koneksi();

$mahasiswa = new Mahasiswa($dbname);

//mengambil input post nim
$data = json_decode(file_get_contents("php://input"));

$mahasiswa->nim = $data->nim;

//memanggil query delete_mhs di class mahasiswa
if ($mahasiswa->delete_mhs()) {

    $respone = array(
        'messsage' => 'Delete Success',
        'code' => http_response_code(200)
    );
} else {

    // set respone 400 'Bad Request' jika delete gagal
    http_response_code(400);
    $respone = array(
        'messsage' => 'Delete Failed',
        'code' => http_response_code()
    );
}

echo json_encode($respone);
