<?php
class CustomerCheckin {

    private $conn;
    private $table = "customer_checkin";

    public function __construct($db){
        $this->conn = $db;
    }

    /**
     * Lấy trạng thái MỚI NHẤT của từng khách trong 1 tour
     * Nếu có truyền điểm tập trung thì lọc theo điểm đó
     */
    public function getLatestStatusesByTourAndPoint($tour_id, $diem_tap_trung = null) {
        if ($diem_tap_trung === null || $diem_tap_trung === '') {
            $sql = "SELECT customer_id, trang_thai 
                    FROM {$this->table}
                    WHERE tour_id = ?
                    ORDER BY thoi_gian DESC";
            $params = [$tour_id];
        } else {
            $sql = "SELECT customer_id, trang_thai 
                    FROM {$this->table}
                    WHERE tour_id = ? AND diem_tap_trung = ?
                    ORDER BY thoi_gian DESC";
            $params = [$tour_id, $diem_tap_trung];
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        $map = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!isset($map[$row['customer_id']])) {
                $map[$row['customer_id']] = $row['trang_thai'];
            }
        }
        return $map;
    }

    /**
     * Lưu 1 bản ghi checkin (ghi lịch sử)
     */
    public function upsert($tour_id, $customer_id, $guide_id, $diem_tap_trung, $trang_thai){
        $sql = "INSERT INTO {$this->table}
                (tour_id, customer_id, guide_id, diem_tap_trung, trang_thai, thoi_gian)
                VALUES (?,?,?,?,?,NOW())";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $tour_id,
            $customer_id,
            $guide_id,
            $diem_tap_trung,
            $trang_thai
        ]);
    }

    /**
     * Lịch sử check-in của 1 tour
     */
    public function getHistoryByTour($tour_id) {
        $sql = "SELECT cc.*, c.ho_ten
                FROM {$this->table} cc
                JOIN customers c ON c.id = cc.customer_id
                WHERE cc.tour_id = ?
                ORDER BY cc.thoi_gian DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
