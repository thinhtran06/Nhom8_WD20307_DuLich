<?php

class TourDiary {

    private $conn;
    private $table = "tour_diary";

    public function __construct($db){
        $this->conn = $db;
    }

    public function getByTour($tour_id) {
        try {
            $sql = "SELECT * FROM tour_diary WHERE tour_id = ? ORDER BY ngay DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$tour_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("TourDiary getByTour error: " . $e->getMessage());
            return [];
        }
    }

    public function getById($id) {
        try {
            $sql = "SELECT * FROM tour_diary WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("TourDiary getById error: " . $e->getMessage());
            return null;
        }
    }

    public function create($data) {
        try {
            $sql = "INSERT INTO tour_diary 
                        (tour_id, guide_id, ngay, tieu_de, noi_dung, su_co, phan_hoi_khach, cach_xu_ly, hinh_anh)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([
                $data['tour_id'],
                $data['guide_id'],
                $data['ngay'],
                $data['tieu_de'],
                $data['noi_dung'],
                $data['su_co'],
                $data['phan_hoi_khach'],
                $data['cach_xu_ly'],
                $data['hinh_anh']
            ]);

        } catch (PDOException $e) {
            error_log("TourDiary create error: " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $data) {
        try {
            $sql = "UPDATE tour_diary SET
                        ngay = ?, 
                        tieu_de = ?,
                        noi_dung = ?, 
                        su_co = ?, 
                        phan_hoi_khach = ?, 
                        cach_xu_ly = ?, 
                        hinh_anh = ?
                    WHERE id = ?";

            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([
                $data['ngay'],
                $data['tieu_de'],
                $data['noi_dung'],
                $data['su_co'],
                $data['phan_hoi_khach'],
                $data['cach_xu_ly'],
                $data['hinh_anh'],
                $id
            ]);

        } catch (PDOException $e) {
            error_log("TourDiary update error: " . $e->getMessage());
            return false;
        }
    }
    public function delete($id)
{
    $sql = "DELETE FROM tour_diary WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id]);
}
}
