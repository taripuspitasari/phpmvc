<?php

class Mahasiswa_model
{
    // stores the table name
    private $table = 'mahasiswa';
    // holds an instance of the Database class for the database operations
    private $db;

    public function __construct()
    {
        // create a new instance of the Database class
        $this->db = new Database();
    }


    // retrieves all records from the mahasiswa table
    public function getAllMahasiswa()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    // retrieves a single record from the mahasiswa table by id
    public function getMahasiswaById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // adds a new record to the mahasiswa table
    public function tambahDataMahasiswa($data)
    {
        $query = "INSERT INTO " . $this->table . " (nama, nrp, email, jurusan) VALUES (:nama, :nrp, :email, :jurusan)";

        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('nrp', $data['nrp']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('jurusan', $data['jurusan']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    // deletes a record from the mahasiswa table by id
    public function hapusDataMahasiswa($id)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // updates a record from the mahasiswa table
    public function ubahDataMahasiswa($data)
    {
        $query = "UPDATE " . $this->table . " SET nama = :nama,
        nrp = :nrp,
        email = :email,
        jurusan = :jurusan
        WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('nrp', $data['nrp']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('jurusan', $data['jurusan']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    // searchs a record from the mahasiswa table by name
    public function cariDataMahasiswa()
    {
        $keyword = $_POST["keyword"];
        $query = 'SELECT * FROM ' . $this->table . ' WHERE nama LIKE :keyword';
        $this->db->query($query);
        $this->db->bind("keyword", "%$keyword%");
        return $this->db->resultSet();
    }
}
