<?php
class Tour {
    private $conn;
    private $table = "tours";

    public $id;
    public $ten_tour;
    public $mo_ta;
    public $diem_khoi_hanh;
    public $diem_den;
    public $ngay_khoi_hanh;
    public $so_ngay;
    public $gia_tour;
    public $so_cho;
    public $trang_thai;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy tất cả tour
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY ngay_khoi_hanh DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lấy tour theo ID
    public function getById() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->ten_tour = $row['ten_tour'];
            $this->mo_ta = $row['mo_ta'];
            $this->diem_khoi_hanh = $row['diem_khoi_hanh'];
            $this->diem_den = $row['diem_den'];
            $this->ngay_khoi_hanh = $row['ngay_khoi_hanh'];
            $this->so_ngay = $row['so_ngay'];
            $this->gia_tour = $row['gia_tour'];
            $this->so_cho = $row['so_cho'];
            $this->trang_thai = $row['trang_thai'];
            return true;
        }
        return false;
    }

    // Tạo tour mới
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                SET ten_tour=:ten_tour, mo_ta=:mo_ta, 
                    diem_khoi_hanh=:diem_khoi_hanh, diem_den=:diem_den,
                    ngay_khoi_hanh=:ngay_khoi_hanh, so_ngay=:so_ngay,
                    gia_tour=:gia_tour, so_cho=:so_cho, trang_thai=:trang_thai";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":ten_tour", $this->ten_tour);
        $stmt->bindParam(":mo_ta", $this->mo_ta);
        $stmt->bindParam(":diem_khoi_hanh", $this->diem_khoi_hanh);
        $stmt->bindParam(":diem_den", $this->diem_den);
        $stmt->bindParam(":ngay_khoi_hanh", $this->ngay_khoi_hanh);
        $stmt->bindParam(":so_ngay", $this->so_ngay);
        $stmt->bindParam(":gia_tour", $this->gia_tour);
        $stmt->bindParam(":so_cho", $this->so_cho);
        $stmt->bindParam(":trang_thai", $this->trang_thai);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Cập nhật tour
    public function update() {
        $query = "UPDATE " . $this->table . " 
                SET ten_tour=:ten_tour, mo_ta=:mo_ta,
                    diem_khoi_hanh=:diem_khoi_hanh, diem_den=:diem_den,
                    ngay_khoi_hanh=:ngay_khoi_hanh, so_ngay=:so_ngay,
                    gia_tour=:gia_tour, so_cho=:so_cho, trang_thai=:trang_thai
                WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":ten_tour", $this->ten_tour);
        $stmt->bindParam(":mo_ta", $this->mo_ta);
        $stmt->bindParam(":diem_khoi_hanh", $this->diem_khoi_hanh);
        $stmt->bindParam(":diem_den", $this->diem_den);
        $stmt->bindParam(":ngay_khoi_hanh", $this->ngay_khoi_hanh);
        $stmt->bindParam(":so_ngay", $this->so_ngay);
        $stmt->bindParam(":gia_tour", $this->gia_tour);
        $stmt->bindParam(":so_cho", $this->so_cho);
        $stmt->bindParam(":trang_thai", $this->trang_thai);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Xóa tour
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>