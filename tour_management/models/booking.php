<?php

class Booking
{
    private $conn;
    private $table = "bookings";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $sql = "SELECT b.*, t.ten_tour, c.ho_ten AS customer_name, u.username AS user_name
                FROM bookings b
                LEFT JOIN tours t ON b.tour_id = t.id
                LEFT JOIN customers c ON b.customer_id = c.id
                LEFT JOIN users u ON b.user_id = u.id
                ORDER BY b.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM bookings WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkAvailability($tour_id, $soNguoi)
    {
        $sql = "SELECT so_cho FROM tours WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);
        $tour = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$tour) return false;

        return $tour["so_cho"] >= $soNguoi;
    }

    public function store($data)
    {
        $sql = "INSERT INTO bookings 
            (tour_id, customer_id, user_id, loai_khach, ma_dat_tour, ngay_dat,
             so_nguoi_lon, so_tre_em, tong_tien, da_thanh_toan, con_lai,
             trang_thai, ghi_chu)
            VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $data['tour_id'],
            $data['customer_id'],
            $data['user_id'],
            $data['loai_khach'],
            $data['ma_dat_tour'],
            $data['so_nguoi_lon'],
            $data['so_tre_em'],
            $data['tong_tien'],
            $data['da_thanh_toan'],
            $data['con_lai'],
            $data['trang_thai'],
            $data['ghi_chu']
        ]);
    }

    public function updateStatus($id, $newStatus)
    {
        $stmt = $this->conn->prepare("SELECT trang_thai FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
        $oldStatus = $stmt->fetchColumn();

        $sql = "UPDATE bookings SET trang_thai = ?, updated_at = NOW() WHERE id = ?";
        $stmt2 = $this->conn->prepare($sql);
        $stmt2->execute([$newStatus, $id]);

        $sqlLog = "INSERT INTO booking_logs (booking_id, old_status, new_status, changed_by)
                   VALUES (?, ?, ?, ?)";

        $stmt3 = $this->conn->prepare($sqlLog);
        $stmt3->execute([
            $id,
            $oldStatus,
            $newStatus,
            $_SESSION["user_id"] ?? null
        ]);

        return true;
    }

    public function destroy($id)
    {
        $sql1 = "DELETE FROM booking_logs WHERE booking_id = ?";
        $stmt1 = $this->conn->prepare($sql1);
        $stmt1->execute([$id]);

        $sql2 = "DELETE FROM bookings WHERE id = ?";
        $stmt2 = $this->conn->prepare($sql2);
        return $stmt2->execute([$id]);
    }
    public function getCustomersByTour($tour_id) {
    // Lấy danh sách khách theo tour từ bảng bookings + customers
    $sql = "SELECT c.*
            FROM bookings b
            JOIN customers c ON c.id = b.customer_id
            WHERE b.tour_id = ?";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$tour_id]);

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

}

?>
