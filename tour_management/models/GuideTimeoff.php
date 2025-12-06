<?php
class GuideTimeoff {

    private $conn;
    private $table = "guide_timeoff";

    public function __construct($db){
        $this->conn = $db;
    }

    /* ============================
       LẤY TẤT CẢ NGÀY NGHỈ
    ============================ */
    public function getAll(){
        $sql = "
            SELECT t.*, g.ho_ten 
            FROM {$this->table} t
            JOIN guides g ON g.id = t.guide_id
            ORDER BY t.ngay_bat_dau DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /* ============================
       LẤY NGÀY NGHỈ THEO HDV
    ============================ */
    public function getByGuide($guide_id){
        $sql = "
            SELECT t.*, g.ho_ten
            FROM {$this->table} t
            JOIN guides g ON g.id = t.guide_id
            WHERE t.guide_id = ?
            ORDER BY t.ngay_bat_dau DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$guide_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /* ============================
       TÌM 1 NGÀY NGHỈ
    ============================ */
    public function find($id){
        $sql = "SELECT * FROM {$this->table} WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /* ============================
       KIỂM TRA NGÀY NGHỈ BỊ TRÙNG
    ============================ */
    public function hasOverlap($guide_id, $start, $end, $exclude_id = null){
        $sql = "
            SELECT COUNT(*) AS total
            FROM {$this->table}
            WHERE guide_id = ?
              AND (
                    (ngay_bat_dau <= ? AND ngay_ket_thuc >= ?) OR
                    (ngay_bat_dau <= ? AND ngay_ket_thuc >= ?)
                  )
        ";

        if ($exclude_id) {
            $sql .= " AND id != " . intval($exclude_id);
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$guide_id, $start, $start, $end, $end]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total'] > 0;
    }

    /* ============================
       THÊM NGÀY NGHỈ
    ============================ */
    public function store($data){
        $sql = "
            INSERT INTO {$this->table}
            (guide_id, ngay_bat_dau, ngay_ket_thuc, ghi_chu)
            VALUES (?, ?, ?, ?)
        ";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['guide_id'],
            $data['ngay_bat_dau'],
            $data['ngay_ket_thuc'],
            $data['ghi_chu'] ?? null
        ]);
    }

    /* ============================
       CẬP NHẬT NGÀY NGHỈ
    ============================ */
    public function update($id, $data){
        $sql = "
            UPDATE {$this->table}
            SET guide_id      = ?,
                ngay_bat_dau  = ?,
                ngay_ket_thuc = ?,
                ghi_chu       = ?
            WHERE id = ?
        ";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['guide_id'],
            $data['ngay_bat_dau'],
            $data['ngay_ket_thuc'],
            $data['ghi_chu'] ?? null,
            $id
        ]);
    }

    /* ============================
       XÓA NGÀY NGHỈ
    ============================ */
    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
