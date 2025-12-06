<?php
class GuideSchedule {

    private $conn;
    private $table = "guide_schedule";

    public function __construct($db){
        $this->conn = $db;
    }

    // ============================
    // LẤY LỊCH LÀM VIỆC THEO HDV
    // ============================
    public function getScheduleByGuide($guide_id){
        $sql = "
            SELECT 
                gs.*,
                t.ten_tour,
                t.diem_khoi_hanh,
                t.diem_den,
                t.ngay_khoi_hanh,
                t.so_ngay
            FROM guide_schedule gs
            JOIN tours t ON t.id = gs.tour_id
            WHERE gs.guide_id = ?
            ORDER BY t.ngay_khoi_hanh ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$guide_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // ============================
    // LẤY LỊCH THEO TOUR
    // ============================
    public function getScheduleByTour($tour_id){
        $sql = "
            SELECT gs.*, g.ho_ten, g.dien_thoai
            FROM guide_schedule gs
            JOIN guides g ON g.id = gs.guide_id
            WHERE gs.tour_id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // ============================
    // THÊM PHÂN CÔNG
    // ============================
    public function add($data){
        $sql = "
            INSERT INTO guide_schedule
            (guide_id, tour_id, ngay_bat_dau, ngay_ket_thuc, ghi_chu)
            VALUES (?, ?, ?, ?, ?)
        ";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data["guide_id"],
            $data["tour_id"],
            $data["ngay_bat_dau"],
            $data["ngay_ket_thuc"],
            $data["ghi_chu"] ?? null
        ]);
    }

    // ============================
    // XÓA PHÂN CÔNG
    // ============================
    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM guide_schedule WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
