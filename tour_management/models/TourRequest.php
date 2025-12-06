<?php

class TourRequest {
    // Kết nối CSDL và tên bảng
    private $conn;
    private $table = "tour_requests";

    // Thuộc tính đối tượng (Đảm bảo các thuộc tính này khớp với các cột trong DB)
    public $id;
    public $ten_khach_hang;
    public $dien_thoai;
    public $email;
    public $so_luong_khach;
    public $diem_den_mong_muon; // <-- SỬA: Đổi 'luon' thành 'muon' để khớp với DB
    public $ngay_khoi_hanh_mong_luon; 
    public $ngan_sach; 
    public $yeu_cau_chi_tiet;
    public $trang_thai;
    public $ngay_tao;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // ------------------------------------------------------------------
    ## Phương thức READ
    // ------------------------------------------------------------------

    /**
     * Lấy tất cả yêu cầu tour.
     * @return PDOStatement
     */
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY ngay_tao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Lấy yêu cầu theo ID và gán vào thuộc tính đối tượng.
     * @return bool
     */
    public function getById() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->ten_khach_hang = $row['ten_khach_hang'];
            $this->email = $row['email'];
            $this->dien_thoai = $row['dien_thoai'];
            $this->so_luong_khach = $row['so_luong_khach'];
            $this->diem_den_mong_muon = $row['diem_den_mong_muon']; // <-- SỬA Tên cột
            $this->ngay_khoi_hanh_mong_luon = $row['ngay_khoi_hanh_mong_luon'];
            $this->ngan_sach = $row['ngan_sach'];
            $this->yeu_cau_chi_tiet = $row['yeu_cau_chi_tiet'];
            $this->trang_thai = $row['trang_thai'];
            $this->ngay_tao = $row['ngay_tao'];
            return true;
        }
        return false;
    }
    
    // ------------------------------------------------------------------
    ## Phương thức CREATE
    // ------------------------------------------------------------------

    /**
     * Tạo yêu cầu tour mới (Dùng cho form nội bộ).
     * @return bool
     */
    public function create() {
        // SỬA: Tên cột trong SQL phải là diem_den_mong_muon
        $query = "INSERT INTO " . $this->table . " 
                  SET ten_khach_hang=:ten_khach_hang, dien_thoai=:dien_thoai, email=:email, 
                      so_luong_khach=:so_luong_khach, diem_den_mong_muon=:diem_den_mong_muon, 
                      ngay_khoi_hanh_mong_luon=:ngay_khoi_hanh_mong_luon, ngan_sach=:ngan_sach, 
                      yeu_cau_chi_tiet=:yeu_cau_chi_tiet, trang_thai=:trang_thai, ngay_tao=NOW()"; 

        $stmt = $this->conn->prepare($query);

  

        // Làm sạch dữ liệu trước khi bind
        // SỬA LỖI DEPRECATED: Dùng '?? '' ' để đảm bảo strip_tags() nhận chuỗi, không phải NULL
        $this->ten_khach_hang = htmlspecialchars(strip_tags($this->ten_khach_hang ?? ''));
        $this->dien_thoai = htmlspecialchars(strip_tags($this->dien_thoai ?? ''));
        
        $this->email = $this->email ? htmlspecialchars(strip_tags($this->email)) : null;
        $this->so_luong_khach = htmlspecialchars(strip_tags($this->so_luong_khach ?? ''));
        $this->diem_den_mong_muon = htmlspecialchars(strip_tags($this->diem_den_mong_muon ?? '')); // <-- SỬA: Tên biến và xử lý NULL
        $this->yeu_cau_chi_tiet = $this->yeu_cau_chi_tiet ? htmlspecialchars(strip_tags($this->yeu_cau_chi_tiet)) : null;
        $this->trang_thai = htmlspecialchars(strip_tags($this->trang_thai ?? ''));
        $this->ngan_sach = $this->ngan_sach ? htmlspecialchars(strip_tags($this->ngan_sach)) : null;

        
        // BIND CÁC THAM SỐ
        $stmt->bindParam(":ten_khach_hang", $this->ten_khach_hang);
        $stmt->bindParam(":dien_thoai", $this->dien_thoai);
        
        // Tham số Email: Sử dụng PDO::PARAM_NULL nếu giá trị là NULL
        $stmt->bindParam(":email", $this->email, $this->email === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $stmt->bindParam(":so_luong_khach", $this->so_luong_khach);
        $stmt->bindParam(":diem_den_mong_muon", $this->diem_den_mong_muon); // <-- SỬA: Tên tham số
        
        // Tham số Ngày khởi hành: Đảm bảo bind NULL khi rỗng
        $stmt->bindParam(":ngay_khoi_hanh_mong_luon", $this->ngay_khoi_hanh_mong_luon, 
            $this->ngay_khoi_hanh_mong_luon === null ? PDO::PARAM_NULL : PDO::PARAM_STR
        );
        
        // Tham số Ngân sách: Đảm bảo bind NULL khi rỗng
        $stmt->bindParam(":ngan_sach", $this->ngan_sach, $this->ngan_sach === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        
        $stmt->bindParam(":yeu_cau_chi_tiet", $this->yeu_cau_chi_tiet);
        $stmt->bindParam(":trang_thai", $this->trang_thai);

        if ($stmt->execute()) {
            return true;
        }
        
        // printf("Error: %s.\n", $stmt->errorInfo()[2]); // Dòng này có thể giúp debug nếu vẫn còn lỗi SQL
        return false;
    }
    
    // ------------------------------------------------------------------
    ## Phương thức UPDATE & DELETE
    // ------------------------------------------------------------------

    /**
     * Cập nhật trạng thái của yêu cầu.
     * @param string $new_status Trạng thái mới.
     * @return bool
     */
    public function updateStatus($new_status) {
        $query = "UPDATE " . $this->table . " SET trang_thai = :trang_thai WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id ?? ''));
        $new_status = htmlspecialchars(strip_tags($new_status ?? ''));

        $stmt->bindParam(':trang_thai', $new_status);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    /**
     * Xóa yêu cầu tour.
     * @return bool
     */
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id ?? ''));
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>