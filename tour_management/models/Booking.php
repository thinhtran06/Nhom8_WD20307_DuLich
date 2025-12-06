<?php

class Booking {

    private $conn;
    private $table = "bookings";

    public function __construct($db){
        $this->conn = $db;
    }

    /* ============================
        LẤY DANH SÁCH KHÁCH THEO TOUR
    ============================ */
    public function getCustomersByTour($tour_id) {
        try {
            $tour_id = (int)$tour_id;

            $sql = "
                SELECT 
                    c.id AS customer_id,
                    c.ho_ten,
                    c.email,
                    c.dien_thoai,
                    c.gioi_tinh,
                    c.quoc_tich,
                    c.ghi_chu,
                    t.ten_tour
                FROM bookings b
                JOIN customers c ON c.id = b.customer_id
                JOIN tours t ON t.id = b.tour_id
                WHERE b.tour_id = ?
                ORDER BY c.ho_ten ASC
            ";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$tour_id]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Booking getCustomersByTour error: " . $e->getMessage());
            return [];
        }
    }

    /* ============================
        THÊM BOOKING
    ============================ */
    public function create($data){
        try {
            $sql = "
                INSERT INTO {$this->table}
                (tour_id, customer_id, user_id, ma_dat_tour, ngay_dat, 
                so_nguoi_lon, so_tre_em, tong_tien, da_thanh_toan, trang_thai, ghi_chu)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";

            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([
                (int)$data['tour_id'],
                (int)$data['customer_id'],
                $data['user_id'] ?? null,
                $data['ma_dat_tour'],
                $data['ngay_dat'],
                $data['so_nguoi_lon'],
                $data['so_tre_em'],
                $data['tong_tien'],
                $data['da_thanh_toan'],
                $data['trang_thai'] ?? 'Đã xác nhận',
                $data['ghi_chu'] ?? null
            ]);

        } catch (PDOException $e) {
            error_log("Booking create error: " . $e->getMessage());
            return false;
        }
    }

    /* ============================
        THÊM KHÁCH VÀO TOUR (HDV)
    ============================ */
    public function addCustomer($data){
    try {

        // 1) Thêm khách
        $sql1 = "INSERT INTO customers 
                    (ho_ten, email, dien_thoai, gioi_tinh, quoc_tich, ghi_chu)
                 VALUES (?, ?, ?, ?, ?, ?)";

        $stmt1 = $this->conn->prepare($sql1);
        $stmt1->execute([
            $data['ho_ten'],
            $data['email'],
            $data['dien_thoai'],
            $data['gioi_tinh'],
            $data['quoc_tich'],
            $data['ghi_chu']
        ]);

        $customer_id = $this->conn->lastInsertId();


        // 2) Tạo mã đặt tour
        $ma_dat_tour = "MDT" . date("YmdHis") . $customer_id;


        // 3) Thêm booking (KHÔNG CÒN NULL)
        $sql2 = "INSERT INTO bookings
                 (tour_id, customer_id, user_id, ma_dat_tour, so_nguoi_lon, so_tre_em, tong_tien, da_thanh_toan, trang_thai)
                 VALUES (?, ?, NULL, ?, 1, 0, 0, 0, 'Đã xác nhận')";

        $stmt2 = $this->conn->prepare($sql2);

        return $stmt2->execute([
            $data['tour_id'],
            $customer_id,
            $ma_dat_tour
        ]);

    } catch (PDOException $e) {
        echo "<pre>LỖI SQL: ".$e->getMessage()."</pre>";
        return false;
    }
}




    /* ============================
        XOÁ KHÁCH KHỎI TOUR
    ============================ */
     public function deleteCustomerFromTour($tour_id, $customer_id) {
        try {
            $sql = "DELETE FROM bookings WHERE tour_id = ? AND customer_id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([(int)$tour_id, (int)$customer_id]);

        } catch (PDOException $e) {
            error_log("deleteCustomerFromTour error: " . $e->getMessage());
            return false;
        }
    }
}
?>
