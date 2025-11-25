<?php
// models/Tour.php

class Tour {
    private $conn;
    private $table = "tours";

    public $id;
    // THÊM THUỘC TÍNH MỚI CHO DANH MỤC (Nếu bạn có ý định dùng)
    public $loai_danh_muc; 
    public $ten_danh_muc; // Thêm thuộc tính này để lưu tên danh mục khi JOIN
    public $category_id; 
    public $ten_tour;
    public $mo_ta;
    public $diem_khoi_hanh;
    public $diem_den;
    public $ngay_khoi_hanh;
    public $so_ngay;
    public $gia_tour;
    public $so_cho;
    public $trang_thai;
    public $lich_trinh; // ĐÃ THÊM

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy tất cả tour (Sắp xếp theo ID ASC & JOIN Danh mục)
    public function getAll() {
        $query = "SELECT t.*, c.ten_danh_muc 
                  FROM " . $this->table . " t
                  LEFT JOIN tour_categories c ON t.category_id = c.id
                  ORDER BY t.id ASC"; // SẮP XẾP THEO ID TĂNG DẦN

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lấy tour theo ID
    public function getById() {
        $query = "SELECT t.*, c.ten_danh_muc 
                  FROM " . $this->table . " t
                  LEFT JOIN tour_categories c ON t.category_id = c.id
                  WHERE t.id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            // Gán thuộc tính từ DB
            $this->category_id = $row['category_id'] ?? null;
            $this->ten_danh_muc = $row['ten_danh_muc'] ?? 'Không rõ'; // Lấy tên danh mục
            $this->ten_tour = $row['ten_tour'];
            $this->mo_ta = $row['mo_ta'];
            $this->diem_khoi_hanh = $row['diem_khoi_hanh'];
            $this->diem_den = $row['diem_den'];
            $this->ngay_khoi_hanh = $row['ngay_khoi_hanh'];
            $this->so_ngay = $row['so_ngay'];
            $this->gia_tour = $row['gia_tour'];
            $this->so_cho = $row['so_cho'];
            $this->trang_thai = $row['trang_thai'];
            $this->lich_trinh = $row['lich_trinh']; // LỊCH TRÌNH
            
            return true;
        }
        return false;
    }

    // Tạo tour mới (ĐÃ THÊM lich_trinh)
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET category_id=:category_id, ten_tour=:ten_tour, mo_ta=:mo_ta, 
                      diem_khoi_hanh=:diem_khoi_hanh, diem_den=:diem_den,
                      ngay_khoi_hanh=:ngay_khoi_hanh, so_ngay=:so_ngay,
                      gia_tour=:gia_tour, so_cho=:so_cho, trang_thai=:trang_thai, 
                      lich_trinh=:lich_trinh"; // THÊM lich_trinh

        $stmt = $this->conn->prepare($query);

        // Bind category_id
        // Sử dụng ?? null để đảm bảo category_id được bind dù là null (nếu bạn chưa dùng danh mục)
        $category_id = $this->category_id ?? null;
        $stmt->bindParam(":category_id", $category_id);
        
        // Bind các tham số khác
        $stmt->bindParam(":ten_tour", $this->ten_tour);
        $stmt->bindParam(":mo_ta", $this->mo_ta);
        $stmt->bindParam(":diem_khoi_hanh", $this->diem_khoi_hanh);
        $stmt->bindParam(":diem_den", $this->diem_den);
        
        $ngay_khoi_hanh = $this->ngay_khoi_hanh ?? null; // Đảm bảo bind là NULL nếu không có giá trị
        $stmt->bindParam(":ngay_khoi_hanh", $ngay_khoi_hanh);
        
        $stmt->bindParam(":so_ngay", $this->so_ngay);
        $stmt->bindParam(":gia_tour", $this->gia_tour);
        $stmt->bindParam(":so_cho", $this->so_cho);
        $stmt->bindParam(":trang_thai", $this->trang_thai);
        
        // BIND LỊCH TRÌNH
        $stmt->bindParam(":lich_trinh", $this->lich_trinh); 

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Cập nhật tour (ĐÃ THÊM lich_trinh)
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET category_id=:category_id, ten_tour=:ten_tour, mo_ta=:mo_ta,
                      diem_khoi_hanh=:diem_khoi_hanh, diem_den=:diem_den,
                      ngay_khoi_hanh=:ngay_khoi_hanh, so_ngay=:so_ngay,
                      gia_tour=:gia_tour, so_cho=:so_cho, trang_thai=:trang_thai,
                      lich_trinh=:lich_trinh  
                  WHERE id=:id"; // THÊM lich_trinh

        $stmt = $this->conn->prepare($query);

        // Bind category_id
        $category_id = $this->category_id ?? null;
        $stmt->bindParam(":category_id", $category_id);
        
        // Bind các tham số khác
        $stmt->bindParam(":ten_tour", $this->ten_tour);
        $stmt->bindParam(":mo_ta", $this->mo_ta);
        $stmt->bindParam(":diem_khoi_hanh", $this->diem_khoi_hanh);
        $stmt->bindParam(":diem_den", $this->diem_den);
        
        $ngay_khoi_hanh = $this->ngay_khoi_hanh ?? null; // Đảm bảo bind là NULL nếu không có giá trị
        $stmt->bindParam(":ngay_khoi_hanh", $ngay_khoi_hanh);
        
        $stmt->bindParam(":so_ngay", $this->so_ngay);
        $stmt->bindParam(":gia_tour", $this->gia_tour);
        $stmt->bindParam(":so_cho", $this->so_cho);
        $stmt->bindParam(":trang_thai", $this->trang_thai);

        // BIND LỊCH TRÌNH
        $stmt->bindParam(":lich_trinh", $this->lich_trinh);
        
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    // models/Tour.php (THÊM PHƯƠNG THỨC MỚI)

    // Lấy tour theo loại (Trong nước/Ngoài nước)
    public function getByLoaiTour($loai_tour) {
        $query = "SELECT t.* FROM " . $this->table . " t
                  WHERE t.loai_tour = :loai_tour
                  ORDER BY t.id ASC";

        $stmt = $this->conn->prepare($query);
        // LÀM SẠCH DỮ LIỆU
        $loai_tour_clean = htmlspecialchars(strip_tags($loai_tour));
        $stmt->bindParam(":loai_tour", $loai_tour_clean);
        $stmt->execute();
        return $stmt;
    }

    // Xóa tour (Giữ nguyên)
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        // LÀM SẠCH DỮ LIỆU
        $this->id = htmlspecialchars(strip_tags($this->id)); 
        
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>