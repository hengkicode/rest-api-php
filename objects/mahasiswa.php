<?php

class Mahasiswa{
    
    public $nim;
    public $nama;
    public $jenis_kelamin;
    public $tempat_lahir;
    public $tanggal_lahir;    
    public $alamat;

    private $kon;
    private $tabel = "tbl_mahasiswa";
      
    public function __construct($dbname){
        $this->kon = $dbname;
    }

    //Get Semua data Mahasiswa
    function get_mhs()
    {
        $query = "SELECT * FROM " . $this->tabel . "";        
        $stmt = $this->kon->prepare($query);        
        $stmt->execute();
        return $stmt;
    }

    //fungsi get mahasiswa by nim
    function get_byNim()
    {
        $query = "SELECT * FROM " . $this->tabel . " m          
                WHERE
                    m.nim = ?
                LIMIT
                0,1";

        $stmt = $this->kon->prepare($query);
        $stmt->bindParam(1, $this->nim);
        
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // memasukkan nilai ke object      
        $this->nama = $row['nama'];
        $this->tempat_lahir = $row['tempat_lahir'];
        $this->jenis_kelamin = $row['jenis_kelamin'];
        $this->tanggal_lahir = $row['tanggal_lahir'];
        $this->alamat = $row['alamat'];
    }
    
    //fungsi input data mahasiswa
    function input_mhs()
    {        
        $query = "INSERT INTO
                " . $this->tabel . "
            SET
               nim=:nim, nama=:nama, jenis_kelamin=:jenis_kelamin, 
               tempat_lahir=:tempat_lahir, tanggal_lahir=:tanggal_lahir, 
               alamat=:alamat";

        $stmt = $this->kon->prepare($query);     
        $stmt->bindParam('nim', $this->nim);
        $stmt->bindParam('nama', $this->nama);
        $stmt->bindParam('jenis_kelamin', $this->jenis_kelamin);
        $stmt->bindParam('tempat_lahir', $this->tempat_lahir);
        $stmt->bindParam('tanggal_lahir', $this->tanggal_lahir);
        $stmt->bindParam('alamat', $this->alamat);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //fungsi updete data mahasiswa
    function update_mhs()
    {        
        $query = "UPDATE
                " . $this->tabel . "
            SET
                nama = :nama,
                tempat_lahir = :tempat_lahir,
                jenis_kelamin = :jenis_kelamin,
                tanggal_lahir = :tanggal_lahir,
                alamat = :alamat
            WHERE
                nim = :nim";
        
        $stmt = $this->kon->prepare($query);

        $stmt->bindParam('nama', $this->nama);
        $stmt->bindParam('tempat_lahir', $this->tempat_lahir);
        $stmt->bindParam('jenis_kelamin', $this->jenis_kelamin);
        $stmt->bindParam('tanggal_lahir', $this->tanggal_lahir);
        $stmt->bindParam('alamat', $this->alamat);
        $stmt->bindParam('nim', $this->nim);
        
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //fungsi delete mahasiswa
    function delete_mhs()
    {        
        $query = "DELETE FROM " . $this->tabel . " WHERE nim = ?";        
        $stmt = $this->kon->prepare($query);
        $stmt->bindParam(1, $this->nim);    
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>