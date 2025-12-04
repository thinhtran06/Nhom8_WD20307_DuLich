<?php

class Tour {

    private $conn;
    private $table = "tours";

    // Thuộc tính tương ứng CSDL
    public $id;
    public $ten_tour;
    public $mo_ta;
    public $diem_khoi_hanh;
    public $diem_den;
    public $loai_tour;
    public $ngay_khoi_hanh;
    public $so_ngay;
    public $gia_tour;
    public $so_cho;
    public $trang_thai;
    public $lich_trinh;

    public function __construct($db){
        $this->conn = $db;
    }

    /* ========================
        LẤY DANH SÁCH TOUR
    ======================== */
    public function getAll(){
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Tour getAll error: " . $e->getMessage());
            return false;
        }
    }

    /* ========================
        LẤY 1 TOUR THEO ID (ĐÃ FIX)
    ======================== */
    public function getById($id = null) {
   
    $id = $id ?? $this->id;

    if (!$id) return null;

    $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_OBJ);
}


    /* ========================
          THÊM TOUR MỚI
    ======================== */
    public function create(){
        try {
            $sql = "INSERT INTO {$this->table}
                (ten_tour, mo_ta, diem_khoi_hanh, diem_den, loai_tour,
                 ngay_khoi_hanh, so_ngay, gia_tour, so_cho, trang_thai, lich_trinh)
                VALUES (?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([
                $this->ten_tour,
                $this->mo_ta,
                $this->diem_khoi_hanh,
                $this->diem_den,
                $this->loai_tour,
                $this->ngay_khoi_hanh,
                $this->so_ngay,
                $this->gia_tour,
                $this->so_cho,
                $this->trang_thai,
                $this->lich_trinh
            ]);

        } catch (PDOException $e) {
            error_log("Tour create error: " . $e->getMessage());
            return false;
        }
    }

    /* ========================
           CẬP NHẬT TOUR
    ======================== */
    public function update(){
        try {
            $sql = "UPDATE {$this->table}
                SET 
                    ten_tour=?, mo_ta=?, diem_khoi_hanh=?, diem_den=?,
                    loai_tour=?, ngay_khoi_hanh=?, so_ngay=?, gia_tour=?,
                    so_cho=?, trang_thai=?, lich_trinh=?
                WHERE id=?";

            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([
                $this->ten_tour,
                $this->mo_ta,
                $this->diem_khoi_hanh,
                $this->diem_den,
                $this->loai_tour,
                $this->ngay_khoi_hanh,
                $this->so_ngay,
                $this->gia_tour,
                $this->so_cho,
                $this->trang_thai,
                $this->lich_trinh,
                $this->id
            ]);

        } catch (PDOException $e) {
            error_log("Tour update error: " . $e->getMessage());
            return false;
        }
    }

    /* ========================
            XÓA TOUR
    ======================== */
    public function delete(){
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$this->id]);

        } catch (PDOException $e) {
            error_log("Tour delete error: " . $e->getMessage());
            return false;
        }
    }

    /* ========================
     LẤY TOUR THEO LOẠI
    ======================== */
    public function getByLoaiTour($loai){
        try {
            $sql = "SELECT * FROM {$this->table}
                    WHERE loai_tour = ?
                    ORDER BY id DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$loai]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);

        } catch (PDOException $e) {
            error_log("Tour getByLoaiTour error: " . $e->getMessage());
            return false;
        }
    }
}
