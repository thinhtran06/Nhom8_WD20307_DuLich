<?php

class CustomerCheckin {

    private $conn;
    private $table = "customer_checkin";

    public function __construct($db){
        $this->conn = $db;
    }

    /**
     * LẤY TRẠNG THÁI MỚI NHẤT CỦA TỪNG KHÁCH THEO TOUR & ĐIỂM TẬP TRUNG
     * Tối ưu bằng cách GROUP BY (chỉ lấy dòng mới nhất mỗi khách)
     */
    public function getLatestStatusesByTourAndPoint($tour_id, $diem_tap_trung = null) {

        try {
            $tour_id = (int)$tour_id;

            if ($diem_tap_trung === null || trim($diem_tap_trung) === "") {

                $sql = "
                    SELECT cc.customer_id, cc.trang_thai
                    FROM {$this->table} cc
                    INNER JOIN (
                        SELECT customer_id, MAX(thoi_gian) AS latest_time
                        FROM {$this->table}
                        WHERE tour_id = ?
                        GROUP BY customer_id
                    ) t ON 
                        t.customer_id = cc.customer_id
                        AND t.latest_time = cc.thoi_gian
                    WHERE cc.tour_id = ?
                ";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$tour_id, $tour_id]);

            } else {

                $sql = "
                    SELECT cc.customer_id, cc.trang_thai
                    FROM {$this->table} cc
                    INNER JOIN (
                        SELECT customer_id, MAX(thoi_gian) AS latest_time
                        FROM {$this->table}
                        WHERE tour_id = ? AND diem_tap_trung = ?
                        GROUP BY customer_id
                    ) t ON 
                        t.customer_id = cc.customer_id
                        AND t.latest_time = cc.thoi_gian
                    WHERE cc.tour_id = ? AND cc.diem_tap_trung = ?
                ";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$tour_id, $diem_tap_trung, $tour_id, $diem_tap_trung]);
            }

            $map = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $map[$row["customer_id"]] = $row["trang_thai"];
            }

            return $map;

        } catch (PDOException $e) {
            error_log("Checkin latest status error: " . $e->getMessage());
            return [];
        }
    }


    /**
     * LƯU 1 DÒNG CHECK-IN (GHI LỊCH SỬ)
     */
    public function upsert($tour_id, $customer_id, $guide_id, $diem_tap_trung, $trang_thai){

        try {
            $tour_id     = (int)$tour_id;
            $customer_id = (int)$customer_id;
            $guide_id    = (int)$guide_id;

            // Validate trạng thái
            $validStatus = ["Da_den", "Chua_den", "Vang"];
            if (!in_array($trang_thai, $validStatus)) {
                $trang_thai = "Chua_den";
            }

            // Giới hạn độ dài điểm tập trung
            $diem_tap_trung = trim($diem_tap_trung);
            if (strlen($diem_tap_trung) > 100) {
                $diem_tap_trung = substr($diem_tap_trung, 0, 100);
            }

            $sql = "INSERT INTO {$this->table}
                    (tour_id, customer_id, guide_id, diem_tap_trung, trang_thai, thoi_gian)
                    VALUES (?, ?, ?, ?, ?, NOW())";

            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([
                $tour_id,
                $customer_id,
                $guide_id,
                $diem_tap_trung,
                $trang_thai
            ]);

        } catch (PDOException $e) {
            error_log("Checkin upsert error: " . $e->getMessage());
            return false;
        }
    }


    /**
     * LỊCH SỬ CHECK-IN THEO TOUR
     */
    public function getHistoryByTour($tour_id){
        try {
            $tour_id = (int)$tour_id;

            $sql = "
                SELECT cc.*, c.ho_ten
                FROM {$this->table} cc
                JOIN customers c ON c.id = cc.customer_id
                WHERE cc.tour_id = ?
                ORDER BY cc.thoi_gian DESC
            ";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$tour_id]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Checkin history error: " . $e->getMessage());
            return [];
        }
    }
}
