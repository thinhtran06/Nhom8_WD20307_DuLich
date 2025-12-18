<?php
class Guide {
    private $conn;
    private $table = "guides";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (ho_ten, ngay_sinh, gioi_tinh, dien_thoai, email, dia_chi, anh_dai_dien, ngon_ngu, kinh_nghiem, ghi_chu, trang_thai)
                  VALUES (:ho_ten, :ngay_sinh, :gioi_tinh, :dien_thoai, :email, :dia_chi, :anh_dai_dien, :ngon_ngu, :kinh_nghiem, :ghi_chu, :trang_thai)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':ho_ten'       => $data['ho_ten'],
            ':ngay_sinh'    => !empty($data['ngay_sinh']) ? $data['ngay_sinh'] : null,
            ':gioi_tinh'    => $data['gioi_tinh'] ?? 'Nam',
            ':dien_thoai'   => $data['dien_thoai'],
            ':email'        => $data['email'],
            ':dia_chi'      => $data['dia_chi'],
            ':anh_dai_dien' => $data['anh_dai_dien'] ?? null,
            ':ngon_ngu'     => $data['ngon_ngu'],
            ':kinh_nghiem'  => !empty($data['kinh_nghiem']) ? intval($data['kinh_nghiem']) : 0,
            ':ghi_chu'      => $data['ghi_chu'],
            ':trang_thai'   => $data['trang_thai'] ?? 'Đang hoạt động'
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET ho_ten=:ho_ten, ngay_sinh=:ngay_sinh, gioi_tinh=:gioi_tinh, 
                      dien_thoai=:dien_thoai, email=:email, dia_chi=:dia_chi, 
                      anh_dai_dien=:anh_dai_dien, ngon_ngu=:ngon_ngu, 
                      kinh_nghiem=:kinh_nghiem, ghi_chu=:ghi_chu, trang_thai=:trang_thai
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            ':ho_ten'       => $data['ho_ten'],
            ':ngay_sinh'    => !empty($data['ngay_sinh']) ? $data['ngay_sinh'] : null,
            ':gioi_tinh'    => $data['gioi_tinh'],
            ':dien_thoai'   => $data['dien_thoai'],
            ':email'        => $data['email'],
            ':dia_chi'      => $data['dia_chi'],
            ':anh_dai_dien' => $data['anh_dai_dien'] ?? null,
            ':ngon_ngu'     => $data['ngon_ngu'],
            ':kinh_nghiem'  => intval($data['kinh_nghiem']),
            ':ghi_chu'      => $data['ghi_chu'],
            ':trang_thai'   => $data['trang_thai'],
            ':id'           => $id
        ]);
    }

    public function store($data) {
        if (isset($data['id']) && !empty($data['id'])) {
            return $this->update($data['id'], $data);
        }
        return $this->create($data);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        return $this->conn->prepare($query)->execute([$id]);
    }
    /* ==================================
   LẤY LỊCH LÀM VIỆC (BOOKING) CỦA HDV
================================== */
/* ==================================
   LẤY LỊCH LÀM VIỆC (BOOKING) CỦA HDV
================================== */
public function getSchedule($guide_id) {
    // Thêm b.id và t.id AS tour_id vào SELECT
    $query = "SELECT 
                b.id, 
                b.ma_dat_tour, 
                b.trang_thai, 
                b.ngay_dat, 
                b.tour_id,
                t.ten_tour, 
                c.ho_ten AS ten_khach
              FROM bookings b
              LEFT JOIN tours t ON b.tour_id = t.id
              LEFT JOIN customers c ON b.customer_id = c.id
              WHERE b.guide_id = ? 
              ORDER BY b.ngay_dat DESC";
    
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$guide_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}