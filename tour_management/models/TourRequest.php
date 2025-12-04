<?php

class TourRequest
{
    private $conn;
    private $table = "tour_requests";

    // Thuộc tính
    public $id;
    public $ten_khach_hang;
    public $dien_thoai;
    public $email;
    public $so_luong_khach;
    public $diem_den_mong_muon;
    public $ngay_khoi_hanh_mong_luon;
    public $ngan_sach;
    public $yeu_cau_chi_tiet;
    public $trang_thai;
    public $ngay_tao;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ==================== READ ====================
    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY ngay_tao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function findById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            foreach ($row as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value === null ? null : $value;
                }
            }
            return true;
        }
        return false;
    }

    // ==================== CREATE ====================
    public function create()
    {
        $query = "INSERT INTO " . $this->table . " 
                  SET ten_khach_hang = :ten_khach_hang,
                      dien_thoai = :dien_thoai,
                      email = :email,
                      so_luong_khach = :so_luong_khach,
                      diem_den_mong_muon = :diem_den_mong_muon,
                      ngay_khoi_hanh_mong_luon = :ngay_khoi_hanh_mong_luon,
                      ngan_sach = :ngan_sach,
                      yeu_cau_chi_tiet = :yeu_cau_chi_tiet,
                      trang_thai = :trang_thai,
                      ngay_tao = NOW()";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->ten_khach_hang     = htmlspecialchars(strip_tags($this->ten_khach_hang ?? ''));
        $this->dien_thoai         = htmlspecialchars(strip_tags($this->dien_thoai ?? ''));
        $this->email              = $this->email ? htmlspecialchars(strip_tags($this->email)) : null;
        $this->so_luong_khach     = htmlspecialchars(strip_tags($this->so_luong_khach ?? '1'));
        $this->diem_den_mong_muon = htmlspecialchars(strip_tags($this->diem_den_mong_muon ?? ''));
        $this->yeu_cau_chi_tiet   = $this->yeu_cau_chi_tiet ? htmlspecialchars(strip_tags($this->yeu_cau_chi_tiet)) : null;
        $this->trang_thai         = htmlspecialchars(strip_tags($this->trang_thai ?? 'Mới'));

        $this->ngay_khoi_hanh_mong_luon = !empty(trim($this->ngay_khoi_hanh_mong_luon))
            ? $this->ngay_khoi_hanh_mong_luon : null;

        // Xử lý ngân sách
        $budget = preg_replace('/[^0-9]/', '', $this->ngan_sach ?? '');
        $this->ngan_sach = ($budget === '' || $budget === '0') ? null : (int)$budget;

        // Bind
        $stmt->bindParam(':ten_khach_hang', $this->ten_khach_hang);
        $stmt->bindParam(':dien_thoai', $this->dien_thoai);
        $stmt->bindParam(':email', $this->email, $this->email === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':so_luong_khach', $this->so_luong_khach);
        $stmt->bindParam(':diem_den_mong_muon', $this->diem_den_mong_muon);
        $stmt->bindParam(':ngay_khoi_hanh_mong_luon', $this->ngay_khoi_hanh_mong_luon,
                         $this->ngay_khoi_hanh_mong_luon === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':ngan_sach', $this->ngan_sach,
                         $this->ngan_sach === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindParam(':yeu_cau_chi_tiet', $this->yeu_cau_chi_tiet,
                         $this->yeu_cau_chi_tiet === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':trang_thai', $this->trang_thai);

        return $stmt->execute();
    }

    // ==================== UPDATE ====================
    public function update()
    {
        $query = "UPDATE " . $this->table . " 
                  SET ten_khach_hang = :ten_khach_hang,
                      dien_thoai = :dien_thoai,
                      email = :email,
                      so_luong_khach = :so_luong_khach,
                      diem_den_mong_muon = :diem_den_mong_muon,
                      ngay_khoi_hanh_mong_luon = :ngay_khoi_hanh_mong_luon,
                      ngan_sach = :ngan_sach,
                      yeu_cau_chi_tiet = :yeu_cau_chi_tiet,
                      trang_thai = :trang_thai
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Ép kiểu ID thành INT – BẮT BUỘC!
        $this->id = (int)($this->id ?? 0);

        // Làm sạch dữ liệu
        $this->ten_khach_hang     = htmlspecialchars(strip_tags($this->ten_khach_hang ?? ''));
        $this->dien_thoai         = htmlspecialchars(strip_tags($this->dien_thoai ?? ''));
        $this->email              = $this->email ? htmlspecialchars(strip_tags($this->email)) : null;
        $this->so_luong_khach     = htmlspecialchars(strip_tags($this->so_luong_khach ?? '1'));
        $this->diem_den_mong_muon = htmlspecialchars(strip_tags($this->diem_den_mong_muon ?? ''));
        $this->yeu_cau_chi_tiet   = $this->yeu_cau_chi_tiet ? htmlspecialchars(strip_tags($this->yeu_cau_chi_tiet)) : null;
        $this->trang_thai         = htmlspecialchars(strip_tags($this->trang_thai ?? 'Mới'));

        $this->ngay_khoi_hanh_mong_luon = !empty(trim($this->ngay_khoi_hanh_mong_luon))
            ? $this->ngay_khoi_hanh_mong_luon : null;

        // Xử lý ngân sách
        $budget = preg_replace('/[^0-9]/', '', $this->ngan_sach ?? '');
        $this->ngan_sach = ($budget === '' || $budget === '0') ? null : (int)$budget;

        // Bind
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':ten_khach_hang', $this->ten_khach_hang);
        $stmt->bindParam(':dien_thoai', $this->dien_thoai);
        $stmt->bindParam(':email', $this->email, $this->email === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':so_luong_khach', $this->so_luong_khach);
        $stmt->bindParam(':diem_den_mong_muon', $this->diem_den_mong_muon);
        $stmt->bindParam(':ngay_khoi_hanh_mong_luon', $this->ngay_khoi_hanh_mong_luon,
                         $this->ngay_khoi_hanh_mong_luon === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':ngan_sach', $this->ngan_sach,
                         $this->ngan_sach === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindParam(':yeu_cau_chi_tiet', $this->yeu_cau_chi_tiet,
                         $this->yeu_cau_chi_tiet === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':trang_thai', $this->trang_thai);

        return $stmt->execute() && $stmt->rowCount() > 0;
    }

    // ==================== DELETE ====================
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // ==================== UPDATE STATUS ====================
    public function updateStatus($new_status)
    {
        $query = "UPDATE " . $this->table . " SET trang_thai = :trang_thai WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = (int)($this->id ?? 0); // Ép kiểu int
        $new_status = htmlspecialchars(strip_tags($new_status ?? ''));

        $stmt->bindParam(':trang_thai', $new_status);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT); // BẮT BUỘC!

        return $stmt->execute();
    }
}