<?php
class Guide {

    private $conn;
    private $table = "guides";

    public function __construct($db){
        $this->conn = $db;
    }

    // ============================
    // LẤY TẤT CẢ HDV
    // ============================
    public function getAll(){
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // ============================
    // LẤY 1 HDV THEO ID
    // ============================
    public function getById($id){
        $sql = "SELECT * FROM {$this->table} WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // ============================
    // TẠO MỚI HDV
    // ============================
    public function store($data){
        $sql = "INSERT INTO {$this->table}
                (ho_ten, ngay_sinh, gioi_tinh, dien_thoai, email, dia_chi,
                 trinh_do, chung_chi, ngon_ngu, loai_hdv, chuyen_tuyen,
                 suc_khoe, trang_thai, ghi_chu)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $data['ho_ten'],
            $data['ngay_sinh'],
            $data['gioi_tinh'],
            $data['dien_thoai'],
            $data['email'],
            $data['dia_chi'],
            $data['trinh_do'],
            $data['chung_chi'],
            $data['ngon_ngu'],
            $data['loai_hdv'],
            $data['chuyen_tuyen'],
            $data['suc_khoe'],
            $data['trang_thai'],
            $data['ghi_chu'] ?? null
        ]);
    }

    // ============================
    // CẬP NHẬT HDV
    // ============================
    public function update($id, $data){
        $sql = "UPDATE {$this->table}
                SET ho_ten = ?, ngay_sinh = ?, gioi_tinh = ?, dien_thoai = ?, email = ?, dia_chi = ?,
                    trinh_do = ?, chung_chi = ?, ngon_ngu = ?, loai_hdv = ?, chuyen_tuyen = ?,
                    suc_khoe = ?, trang_thai = ?, ghi_chu = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $data['ho_ten'],
            $data['ngay_sinh'],
            $data['gioi_tinh'],
            $data['dien_thoai'],
            $data['email'],
            $data['dia_chi'],
            $data['trinh_do'],
            $data['chung_chi'],
            $data['ngon_ngu'],
            $data['loai_hdv'],
            $data['chuyen_tuyen'],
            $data['suc_khoe'],
            $data['trang_thai'],
            $data['ghi_chu'] ?? null,
            $id
        ]);
    }

    // ============================
    // XÓA HDV
    // ============================
    public function delete($id){
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
