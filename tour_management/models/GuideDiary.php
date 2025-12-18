<?php
class GuideDiary {

    private $conn;
    private $table = "tour_diary";

    public function __construct($db){
        $this->conn = $db;
    }

    public function getByTour($tour_id){
        $sql = "SELECT *
                FROM {$this->table}
                WHERE tour_id = ?
                ORDER BY ngay ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByTourAndGuide($tour_id, $guide_id){
        $sql = "SELECT *
                FROM {$this->table}
                WHERE tour_id = ?
                  AND guide_id = ?
                ORDER BY ngay DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tour_id, $guide_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id){
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data){
        $sql = "INSERT INTO {$this->table}
                (tour_id, guide_id, ngay, tieu_de, noi_dung, hinh_anh, phan_hoi_khach, su_co, cach_xu_ly)
                VALUES (?,?,?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['tour_id'],
            $data['guide_id'],
            $data['ngay'],
            $data['tieu_de'],
            $data['noi_dung'],
            $data['hinh_anh'],
            $data['phan_hoi_khach'],
            $data['su_co'],
            $data['cach_xu_ly']
        ]);
    }

    public function update($id, $data){
        $sql = "UPDATE {$this->table}
                SET ngay=?, tieu_de=?, noi_dung=?, hinh_anh=?, phan_hoi_khach=?, su_co=?, cach_xu_ly=?
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['ngay'],
            $data['tieu_de'],
            $data['noi_dung'],
            $data['hinh_anh'],
            $data['phan_hoi_khach'],
            $data['su_co'],
            $data['cach_xu_ly'],
            $id
        ]);
    }
    public function delete($id)
{
    $sql = "DELETE FROM {$this->table} WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id]);
}

}