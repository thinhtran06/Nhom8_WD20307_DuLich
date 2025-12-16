<?php

class Tour {
    // Kết nối CSDL và tên bảng
    private $conn;
    private $table = "tours";

    // Thuộc tính đối tượng
    public $id;
    public $ten_tour;
    public $mo_ta;
    public $diem_khoi_hanh;
    public $diem_den;
    public $loai_tour;
    public $ngay_khoi_hanh;
    public $ngay_ket_thuc;
    public $so_ngay;
    public $gia_tour;
    public $so_cho;
    public $trang_thai;
    public $lich_trinh;

    // Constructor với $db
    public function __construct($db) {
        $this->conn = $db;
    }

    // --- PHƯƠNG THỨC CRUD CƠ BẢN ---

    // 1. Lấy tất cả tour
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 2. Lấy tour theo ID
    public function getById($id) {
    $query = "SELECT * FROM tours WHERE id = ? LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

    // 3. Tạo tour mới (ĐÃ CÂN CHỈNH LẠI LOGIC XỬ LÝ NULL)
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                     SET ten_tour=:ten_tour, mo_ta=:mo_ta, 
                         diem_khoi_hanh=:diem_khoi_hanh, diem_den=:diem_den,
                         loai_tour=:loai_tour, 
                         ngay_khoi_hanh=:ngay_khoi_hanh, so_ngay=:so_ngay,
                         ngay_ket_thuc=:ngay_ket_thuc,
                         gia_tour=:gia_tour, so_cho=:so_cho, trang_thai=:trang_thai, 
                         lich_trinh=:lich_trinh"; 

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->ten_tour = htmlspecialchars(strip_tags($this->ten_tour));
        $this->mo_ta = htmlspecialchars(strip_tags($this->mo_ta));
        $this->diem_khoi_hanh = htmlspecialchars(strip_tags($this->diem_khoi_hanh));
        $this->diem_den = htmlspecialchars(strip_tags($this->diem_den));
        $this->loai_tour = htmlspecialchars(strip_tags($this->loai_tour));
        
        // Xử lý NULL cho ngay_khoi_hanh (Nếu là NULL, không strip_tags)
        $ngay_khoi_hanh_clean = $this->ngay_khoi_hanh ? htmlspecialchars(strip_tags($this->ngay_khoi_hanh)) : null;
        $ngay_ket_thuc_clean = $this->ngay_ket_thuc ? htmlspecialchars(strip_tags($this->ngay_ket_thuc)) : null;
        $this->so_ngay = htmlspecialchars(strip_tags($this->so_ngay));
        $this->gia_tour = htmlspecialchars(strip_tags($this->gia_tour));
        $this->so_cho = htmlspecialchars(strip_tags($this->so_cho));
        $this->trang_thai = htmlspecialchars(strip_tags($this->trang_thai));
        $this->lich_trinh = htmlspecialchars(strip_tags($this->lich_trinh ?? ''));


        $stmt->bindParam(":ten_tour", $this->ten_tour);
        $stmt->bindParam(":mo_ta", $this->mo_ta);
        $stmt->bindParam(":diem_khoi_hanh", $this->diem_khoi_hanh);
        $stmt->bindParam(":diem_den", $this->diem_den);
        $stmt->bindParam(":loai_tour", $this->loai_tour);
        $stmt->bindParam(":ngay_khoi_hanh", $ngay_khoi_hanh_clean);
        $stmt->bindParam(":ngay_ket_thuc", $ngay_ket_thuc_clean); // BIND GIÁ TRỊ ĐÃ XỬ LÝ NULL
        $stmt->bindParam(":so_ngay", $this->so_ngay);
        $stmt->bindParam(":gia_tour", $this->gia_tour);
        $stmt->bindParam(":so_cho", $this->so_cho);
        $stmt->bindParam(":trang_thai", $this->trang_thai);
        $stmt->bindParam(":lich_trinh", $this->lich_trinh);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // 4. Cập nhật tour (ĐÃ CÂN CHỈNH LẠI LOGIC XỬ LÝ NULL VÀ LÀM SẠCH DỮ LIỆU)
    public function update() {
        $query = "UPDATE " . $this->table . " 
                     SET ten_tour=:ten_tour, mo_ta=:mo_ta,
                         diem_khoi_hanh=:diem_khoi_hanh, diem_den=:diem_den,
                         loai_tour=:loai_tour, 
                         ngay_khoi_hanh=:ngay_khoi_hanh, so_ngay=:so_ngay,
                         ngay_ket_thuc=:ngay_ket_thuc,
                         gia_tour=:gia_tour, so_cho=:so_cho, trang_thai=:trang_thai,
                         lich_trinh=:lich_trinh  
                     WHERE id=:id"; 

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->ten_tour = htmlspecialchars(strip_tags($this->ten_tour));
        $this->mo_ta = htmlspecialchars(strip_tags($this->mo_ta));
        $this->diem_khoi_hanh = htmlspecialchars(strip_tags($this->diem_khoi_hanh));
        $this->diem_den = htmlspecialchars(strip_tags($this->diem_den));
        $this->loai_tour = htmlspecialchars(strip_tags($this->loai_tour)); 
        
        // Xử lý NULL cho ngay_khoi_hanh (QUAN TRỌNG: tránh lỗi "Incorrect date value: ''")
        // Nếu giá trị là NULL, không strip_tags, chỉ cần gán NULL
        $ngay_khoi_hanh_clean = $this->ngay_khoi_hanh ? htmlspecialchars(strip_tags($this->ngay_khoi_hanh)) : null;
        $ngay_ket_thuc_clean = $this->ngay_ket_thuc ? htmlspecialchars(strip_tags($this->ngay_ket_thuc)) : null;
        $this->so_ngay = htmlspecialchars(strip_tags($this->so_ngay));
        $this->gia_tour = htmlspecialchars(strip_tags($this->gia_tour));
        $this->so_cho = htmlspecialchars(strip_tags($this->so_cho));
        $this->trang_thai = htmlspecialchars(strip_tags($this->trang_thai));
        $this->lich_trinh = htmlspecialchars(strip_tags($this->lich_trinh ?? ''));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":ten_tour", $this->ten_tour);
        $stmt->bindParam(":mo_ta", $this->mo_ta);
        $stmt->bindParam(":diem_khoi_hanh", $this->diem_khoi_hanh);
        $stmt->bindParam(":diem_den", $this->diem_den);
        $stmt->bindParam(":loai_tour", $this->loai_tour);
        $stmt->bindParam(":ngay_khoi_hanh", $ngay_khoi_hanh_clean);
        $stmt->bindParam(":ngay_ket_thuc", $ngay_ket_thuc_clean); // BIND GIÁ TRỊ ĐÃ XỬ LÝ NULL
        $stmt->bindParam(":so_ngay", $this->so_ngay);
        $stmt->bindParam(":gia_tour", $this->gia_tour);
        $stmt->bindParam(":so_cho", $this->so_cho);
        $stmt->bindParam(":trang_thai", $this->trang_thai);
        $stmt->bindParam(":lich_trinh", $this->lich_trinh);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // 5. Xóa tour
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // 6. Lấy tour theo loại (Cho Router listByLoaiTour)
    public function getByLoaiTour($loai_tour) {
        $query = "SELECT t.* FROM " . $this->table . " t
                  WHERE t.loai_tour = :loai_tour
                  ORDER BY t.id ASC";

        $stmt = $this->conn->prepare($query);
        $loai_tour_clean = htmlspecialchars(strip_tags($loai_tour));
        $stmt->bindParam(":loai_tour", $loai_tour_clean);
        $stmt->execute();
        return $stmt;
    }

    // --- PHƯƠNG THỨC BỔ SUNG CHO CHỨC NĂNG ĐIỂM DANH/BÁO CÁO ---

    // 7. Lấy tất cả tour đang Hoạt Động (Cần cho chức năng Điểm danh)
    public function getAllActive() {
        $query = "SELECT id, ten_tour, ngay_khoi_hanh, so_ngay 
                  FROM " . $this->table . " 
                  WHERE trang_thai = 'Đang hoạt động' 
                  ORDER BY ngay_khoi_hanh ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    // models/Tour.php (BỔ SUNG PHƯƠNG THỨC NÀY)

public function getPriceById($tour_id) {
    $query = "SELECT gia_tour FROM " . $this->table . " WHERE id = ? LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $tour_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? (float)$row['gia_tour'] : 0.00;
}
}
?>