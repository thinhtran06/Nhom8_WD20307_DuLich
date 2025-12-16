<?php
class GuideWork {

    private $db;  
    private $table = "guide_tour";

    public function __construct($db){
        $this->db = $db; 
    }

    // Kiểm tra tour đã có HDV chưa
    public function exists($tour_id){
        $sql = "SELECT id FROM {$this->table} WHERE tour_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tour_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Lưu phân công HDV cho tour
    public function assign($guide_id, $tour_id){
        $sql = "INSERT INTO {$this->table} (guide_id, tour_id, created_at)
                VALUES (?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$guide_id, $tour_id]);
    }

    // Lấy danh sách tour mà HDV được phân công
    public function getAssignedTours($guide_id){
        $sql = "
            SELECT 
                t.id AS tour_id,
                t.ten_tour,
                t.ngay_khoi_hanh,
                t.so_ngay,
                t.diem_khoi_hanh,
                t.diem_den
            FROM guide_tour gt
            JOIN tours t ON t.id = gt.tour_id
            WHERE gt.guide_id = ?
            ORDER BY t.ngay_khoi_hanh ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$guide_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Tạo phân công HDV (có ngày làm việc)
    public function create($guide_id, $tour_id, $work_date)
{
    try {
        $sql = "INSERT INTO guide_tour (guide_id, tour_id, work_date, created_at)
                VALUES (:guide_id, :tour_id, :work_date, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':guide_id', $guide_id);
        $stmt->bindParam(':tour_id', $tour_id);
        $stmt->bindParam(':work_date', $work_date);

        return $stmt->execute();
    } catch (PDOException $e) {
        die("Lỗi SQL: " . $e->getMessage());
    }
}

    // Lấy tour theo HDV
    public function getToursByGuide($guide_id){
    $sql = "
        SELECT 
            t.id AS tour_id,
            t.ten_tour,
            t.ngay_khoi_hanh,
            t.so_ngay,
            t.diem_khoi_hanh,
            t.diem_den,
            gt.work_date
        FROM guide_tour gt
        JOIN tours t ON t.id = gt.tour_id
        WHERE gt.guide_id = :guide_id
        ORDER BY gt.work_date
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([':guide_id' => $guide_id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);   // ✅ SỬA Ở ĐÂY
}
    public function existsOnDate($tour_id, $work_date)
{
    $sql = "SELECT id FROM guide_tour WHERE tour_id = :tour_id AND work_date = :work_date";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':tour_id' => $tour_id,
        ':work_date' => $work_date
    ]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}
}