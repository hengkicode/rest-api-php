<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/mahasiswa.php';

$database = new Database();
$dbname = $database->koneksi();

$mahasiswa = new Mahasiswa($dbname);

// mengambil data post
$data = json_decode(file_get_contents("php://input"));

//validasi data yang akan diinput
if (
    !empty($data->nim) &&
    !empty($data->nama) &&
    !empty($data->jenis_kelamin) &&
    !empty($data->tempat_lahir) &&
    !empty($data->tanggal_lahir) &&
    !empty($data->alamat)

) {

    // set property mahasiswa 
    $mahasiswa->nim = $data->nim;
    $mahasiswa->nama = $data->nama;
    $mahasiswa->jenis_kelamin = $data->jenis_kelamin;
    $mahasiswa->tempat_lahir = $data->tempat_lahir;
    $mahasiswa->tanggal_lahir = $data->tanggal_lahir;
    $mahasiswa->alamat = $data->alamat;

    // proses input data siswa
    if ($mahasiswa->input_mhs()) {

        $respone = array(
            'messsage' => 'Input Success',
            'code' => http_response_code(200)

        );
    } else {

        // set respone 400 'Bad Request' jika input gagal
        http_response_code(400);
        $respone = array(
            'messsage' => 'Input Failed',
            'code' => http_response_code()
        );
    }
} else {

    // set respone 400 'Bad Request' jika parameter / nilai kosong
    http_response_code(400);
    $respone = array(
        'messsage' => 'Input Failed - Wrong Parameter',
        'code' => http_response_code()
    );
}

echo json_encode($respone);
