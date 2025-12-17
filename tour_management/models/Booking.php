<?php

class Booking
{
    
    private $conn;
    private $table = "bookings";

    public $id;
public $tour_id;
public $customer_id;
public $user_id;
public $loai_khach;
public $ma_dat_tour;
public $ngay_dat;
public $so_nguoi_lon;
public $so_tre_em;
public $tong_tien;
public $da_thanh_toan;
public $con_lai;
public $trang_thai;
public $ghi_chu;
public $guide_id;
public $created_at;
public $updated_at;

    
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả booking + tour + khách + user + HDV
    public function getAll()
    {
        $sql = "SELECT 
                    b.*, 
                    t.ten_tour, 
                    c.ho_ten AS customer_name, 
                    u.username AS user_name,
                    g.ho_ten AS guide_name
                FROM bookings b
                LEFT JOIN tours t ON b.tour_id = t.id
                LEFT JOIN customers c ON b.customer_id = c.id
                LEFT JOIN users u ON b.user_id = u.id
                LEFT JOIN guides g ON b.guide_id = g.id
                ORDER BY b.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 booking
    public function find($id)
    {
        $sql = "SELECT 
                    b.*, 
                    t.ten_tour, 
                    c.ho_ten AS customer_name,
                    g.ho_ten AS guide_name
                FROM bookings b
                LEFT JOIN tours t ON b.tour_id = t.id
                LEFT JOIN customers c ON b.customer_id = c.id
                LEFT JOIN guides g ON b.guide_id = g.id
                WHERE b.id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Kiểm tra số chỗ còn lại
    public function checkAvailability($tour_id, $soNguoi)
    {
        $sql = "SELECT so_cho FROM tours WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);
        $tour = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$tour) return false;

        return $tour["so_cho"] >= $soNguoi;
    }

    // Tạo booking mới
    public function store($data)
{
    $sql = "INSERT INTO bookings 
        (tour_id, customer_id, user_id, loai_khach, ma_dat_tour, ngay_dat,
         so_nguoi_lon, so_tre_em, tong_tien, da_thanh_toan, con_lai,
         trang_thai, ghi_chu, guide_id)
        VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->conn->prepare($sql);

    if ($stmt->execute([
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
        $data['ghi_chu'],
        $data['guide_id'] ?? null
    ])) {
        return $this->conn->lastInsertId();   // ✅ trả về ID booking
    }

    return false;
}

    // Cập nhật trạng thái
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

    // Xóa booking
    public function destroy($id)
    {
        $sql1 = "DELETE FROM booking_logs WHERE booking_id = ?";
        $stmt1 = $this->conn->prepare($sql1);
        $stmt1->execute([$id]);

        $sql2 = "DELETE FROM bookings WHERE id = ?";
        $stmt2 = $this->conn->prepare($sql2);
        return $stmt2->execute([$id]);
    }

    // Lấy danh sách khách theo tour
    public function getCustomersByTour($tour_id)
    {
        $sql = "SELECT c.*
                FROM bookings b
                JOIN customers c ON c.id = b.customer_id
                WHERE b.tour_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Thêm khách lẻ vào tour
    public function addCustomer($data)
    {
        $sqlCus = "INSERT INTO customers (ho_ten, email, dien_thoai, gioi_tinh, quoc_tich, ghi_chu)
                   VALUES (?, ?, ?, ?, ?, ?)";

        $stmtCus = $this->conn->prepare($sqlCus);
        $stmtCus->execute([
            $data['ho_ten'],
            $data['email'] ?? null,
            $data['dien_thoai'] ?? null,
            $data['gioi_tinh'] ?? null,
            $data['quoc_tich'] ?? null,
            $data['ghi_chu'] ?? null,
        ]);

        $customer_id = $this->conn->lastInsertId();

        $sqlBooking = "INSERT INTO bookings 
            (tour_id, customer_id, user_id, loai_khach, ma_dat_tour, so_nguoi_lon, 
             so_tre_em, tong_tien, da_thanh_toan, con_lai, trang_thai, ghi_chu)
            VALUES (?, ?, NULL, 'Khách lẻ', ?, 1, 0, 0, 0, 0, 'Đã xác nhận', '')";

        $stmtBooking = $this->conn->prepare($sqlBooking);
        $stmtBooking->execute([
            $data['tour_id'],
            $customer_id,
            uniqid('ADD_')
        ]);

        return true;
    }

    // Xóa khách khỏi tour
    public function removeCustomerFromTour($tour_id, $customer_id)
    {
        $sql = "DELETE FROM bookings WHERE tour_id = ? AND customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$tour_id, $customer_id]);
    }

    // Lấy tất cả booking (PDOStatement)
    public function getAllBookingsWithDetails()
    {
        $sql = "SELECT 
                    b.*, 
                    t.ten_tour, 
                    c.ho_ten AS customer_name,
                    g.ho_ten AS guide_name
                FROM bookings b
                LEFT JOIN tours t ON b.tour_id = t.id
                LEFT JOIN customers c ON b.customer_id = c.id
                LEFT JOIN guides g ON b.guide_id = g.id
                ORDER BY b.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    }
    public function create()
{
    return $this->store([
        'tour_id'        => $this->tour_id,
        'customer_id'    => $this->customer_id,
        'user_id'        => $this->user_id,
        'loai_khach'     => $this->loai_khach,
        'ma_dat_tour'    => $this->ma_dat_tour,
        'so_nguoi_lon'   => $this->so_nguoi_lon,
        'so_tre_em'      => $this->so_tre_em,
        'tong_tien'      => $this->tong_tien,
        'da_thanh_toan'  => $this->da_thanh_toan,
        'con_lai'        => $this->con_lai,
        'trang_thai'     => $this->trang_thai,
        'ghi_chu'        => $this->ghi_chu,
        'guide_id'       => $this->guide_id
    ]);
}
public function getById($id)
{
    $sql = "SELECT 
                b.*, 
                t.ten_tour, 
                c.ho_ten AS customer_name,
                g.ho_ten AS guide_name
            FROM bookings b
            LEFT JOIN tours t ON b.tour_id = t.id
            LEFT JOIN customers c ON b.customer_id = c.id
            LEFT JOIN guides g ON b.guide_id = g.id
            WHERE b.id = ?
            LIMIT 1";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function update($id)
{
    $sql = "UPDATE bookings SET 
                tour_id = ?, 
                guide_id = ?, 
                customer_id = ?, 
                ngay_dat = ?, 
                so_nguoi_lon = ?, 
                so_tre_em = ?, 
                loai_khach = ?, 
                trang_thai = ?, 
                ghi_chu = ?, 
                tong_tien = ?, 
                da_thanh_toan = ?, 
                con_lai = ?
            WHERE id = ?";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
        $this->tour_id,
        $this->guide_id,
        $this->customer_id,
        $this->ngay_dat,
        $this->so_nguoi_lon,
        $this->so_tre_em,
        $this->loai_khach,
        $this->trang_thai,
        $this->ghi_chu,
        $this->tong_tien,
        $this->da_thanh_toan,
        $this->con_lai,
        $id
    ]);
}
}

?>