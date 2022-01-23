<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/mahasiswa.php';

$database = new Database();
$dbname = $database->koneksi();

$mahasiswa = new Mahasiswa($dbname);

//memanggil query get_mahasiswa di class mahasiswa
$stmt = $mahasiswa->get_mhs();
$num = $stmt->rowCount();

$respone = [];
if ($num > 0) {

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {        
        extract($row);

        $mhs_item[] = array(
            "nim" => $nim,
            "nama" => $nama,
            "jenis_kelamin" => $jenis_kelamin,
            "tempat_lahir" => $tempat_lahir,
            "tanggal_lahir" => $tanggal_lahir,
            "alamat" => $alamat
        );
    }

    //format json yang akan dikirim ke client
    $respone = array(
        'status' =>  array(
            'messsage' => 'Success', 'code' => http_response_code(200)
        ), 'data' => $mhs_item
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