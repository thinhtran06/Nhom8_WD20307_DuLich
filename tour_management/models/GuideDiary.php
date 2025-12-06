<?php
class GuideDiary {

    private $conn;
    private $table = "guide_diary";

    public function __construct($db){
        $this->conn = $db;
    }

    /* Lấy tất cả nhật ký theo tour */
    public function getAllByTour($tour_id, $guide_id){
        $sql = "SELECT * FROM {$this->table} 
                WHERE tour_id = ? AND guide_id = ?
                ORDER BY ngay ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id, $guide_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Lấy 1 nhật ký */
    public function getById($id){
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* Thêm nhật ký */
    public function create($data){
        $sql = "INSERT INTO {$this->table}
                (tour_id, guide_id, ngay, su_kien, su_co, xu_ly, phan_hoi, hinh_anh)
                VALUES (?,?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['tour_id'],
            $data['guide_id'],
            $data['ngay'],
            $data['su_kien'],
            $data['su_co'],
            $data['xu_ly'],
            $data['phan_hoi'],
            $data['hinh_anh'] ?? null
        ]);
    }

    /* Cập nhật nhật ký */
    public function update($data){
        $sql = "UPDATE {$this->table}
                SET ngay=?, su_kien=?, su_co=?, xu_ly=?, phan_hoi=?, hinh_anh=?
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['ngay'],
            $data['su_kien'],
            $data['su_co'],
            $data['xu_ly'],
            $data['phan_hoi'],
            $data['hinh_anh'] ?? null,
            $data['id']
        ]);
    }
}
