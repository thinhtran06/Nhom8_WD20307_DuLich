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
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    /* ============================
       LẤY TẤT CẢ HDV
    ============================ */
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ============================
       TẠO HDV MỚI
    ============================ */
    public function create($data) {
    $query = "INSERT INTO " . $this->table . " 
              (ho_ten, ngay_sinh, gioi_tinh, dien_thoai, email, trang_thai, dia_chi, ngon_ngu, loai_hdv, chuyen_tuyen, ghi_chu)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->conn->prepare($query);

    return $stmt->execute([
        $data['ho_ten'],
        $data['ngay_sinh'],
        $data['gioi_tinh'],
        $data['dien_thoai'],
        $data['email'],
        $data['trang_thai'],
        $data['dia_chi'],
        $data['ngon_ngu'],
        $data['loai_hdv'],
        $data['chuyen_tuyen'],
        $data['ghi_chu']
    ]);
}

    /* ============================
       CẬP NHẬT HDV
    ============================ */
    public function update($data) {
    $query = "UPDATE " . $this->table . "
              SET ho_ten=?, ngay_sinh=?, gioi_tinh=?, dien_thoai=?, email=?, trang_thai=?, dia_chi=?, ngon_ngu=?, loai_hdv=?, chuyen_tuyen=?, ghi_chu=?
              WHERE id=?";

    $stmt = $this->conn->prepare($query);

    return $stmt->execute([
        $data['ho_ten'],
        $data['ngay_sinh'],
        $data['gioi_tinh'],
        $data['dien_thoai'],
        $data['email'],
        $data['trang_thai'],
        $data['dia_chi'],
        $data['ngon_ngu'],
        $data['loai_hdv'],
        $data['chuyen_tuyen'],
        $data['ghi_chu'],
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
    /* ============================
   STORE = CREATE + UPDATE
============================ */
public function store($data) {
    // Nếu có ID → cập nhật
    if (!empty($data['id'])) {
        return $this->update($data);
    }

    // Nếu không có ID → thêm mới
    return $this->create($data);
}

}

?>