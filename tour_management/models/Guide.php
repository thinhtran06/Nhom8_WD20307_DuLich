<?php

class Guide {

    private $conn;
    private $table = "guides";

    // ✅ Khai báo đầy đủ thuộc tính (tránh lỗi deprecated PHP 8.2)
    public $id;
    public $ho_ten;
    public $loai_hdv;
    public $chuyen_tuyen;
    public $ngon_ngu;
    public $so_dien_thoai;
    public $email;
    public $dia_chi;
    public $trang_thai;

    public function __construct($db) {
        $this->conn = $db;
    }

    /* ============================
       LẤY HDV THEO ID (CHUẨN)
    ============================ */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_OBJ); // ✅ Trả về object
    }

    /* ============================
       LẤY TẤT CẢ HDV
    ============================ */
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /* ============================
       TẠO HDV MỚI
    ============================ */
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (ho_ten, loai_hdv, chuyen_tuyen, ngon_ngu, so_dien_thoai, email, dia_chi, trang_thai)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            $data['ho_ten'],
            $data['loai_hdv'],
            $data['chuyen_tuyen'],
            $data['ngon_ngu'],
            $data['so_dien_thoai'],
            $data['email'],
            $data['dia_chi'],
            $data['trang_thai']
        ]);
    }

    /* ============================
       CẬP NHẬT HDV
    ============================ */
    public function update($data) {
        $query = "UPDATE " . $this->table . "
                  SET ho_ten=?, loai_hdv=?, chuyen_tuyen=?, ngon_ngu=?, 
                      so_dien_thoai=?, email=?, dia_chi=?, trang_thai=?
                  WHERE id=?";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            $data['ho_ten'],
            $data['loai_hdv'],
            $data['chuyen_tuyen'],
            $data['ngon_ngu'],
            $data['so_dien_thoai'],
            $data['email'],
            $data['dia_chi'],
            $data['trang_thai'],
            $data['id']
        ]);
    }

    /* ============================
       XÓA HDV
    ============================ */
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}

?>