<?php
class Supplier {
    private $conn;
    private $table = "suppliers";

    public $id;
    public $ten_ncc;
    public $loai_dich_vu;
    public $dia_chi;
    public $thanh_pho;
    public $dien_thoai;
    public $email;
    public $website;
    public $nguoi_lien_he;
    public $chuc_vu_lien_he;
    public $dien_thoai_lien_he;
    public $thong_tin_thanh_toan;
    public $trang_thai;
    public $ghi_chu;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy tất cả nhà cung cấp
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY ten_ncc ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lấy nhà cung cấp theo loại dịch vụ
    public function getByService($loai_dich_vu) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE loai_dich_vu = :loai_dich_vu AND trang_thai = 'Đang hợp tác' 
                  ORDER BY ten_ncc ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':loai_dich_vu', $loai_dich_vu);
        $stmt->execute();
        return $stmt;
    }

    // Lấy nhà cung cấp theo ID
    public function getById() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $this->ten_ncc = $row['ten_ncc'];
            $this->loai_dich_vu = $row['loai_dich_vu'];
            $this->dia_chi = $row['dia_chi'];
            $this->thanh_pho = $row['thanh_pho'];
            $this->dien_thoai = $row['dien_thoai'];
            $this->email = $row['email'];
            $this->website = $row['website'];
            $this->nguoi_lien_he = $row['nguoi_lien_he'];
            $this->chuc_vu_lien_he = $row['chuc_vu_lien_he'];
            $this->dien_thoai_lien_he = $row['dien_thoai_lien_he'];
            $this->thong_tin_thanh_toan = $row['thong_tin_thanh_toan'];
            $this->trang_thai = $row['trang_thai'];
            $this->ghi_chu = $row['ghi_chu'];
            return true;
        }
        return false;
    }

    // Tạo nhà cung cấp mới
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                SET ten_ncc=:ten_ncc, loai_dich_vu=:loai_dich_vu, 
                    dia_chi=:dia_chi, thanh_pho=:thanh_pho,
                    dien_thoai=:dien_thoai, email=:email, website=:website,
                    nguoi_lien_he=:nguoi_lien_he, chuc_vu_lien_he=:chuc_vu_lien_he,
                    dien_thoai_lien_he=:dien_thoai_lien_he, 
                    thong_tin_thanh_toan=:thong_tin_thanh_toan,
                    trang_thai=:trang_thai, ghi_chu=:ghi_chu";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":ten_ncc", $this->ten_ncc);
        $stmt->bindParam(":loai_dich_vu", $this->loai_dich_vu);
        $stmt->bindParam(":dia_chi", $this->dia_chi);
        $stmt->bindParam(":thanh_pho", $this->thanh_pho);
        $stmt->bindParam(":dien_thoai", $this->dien_thoai);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":website", $this->website);
        $stmt->bindParam(":nguoi_lien_he", $this->nguoi_lien_he);
        $stmt->bindParam(":chuc_vu_lien_he", $this->chuc_vu_lien_he);
        $stmt->bindParam(":dien_thoai_lien_he", $this->dien_thoai_lien_he);
        $stmt->bindParam(":thong_tin_thanh_toan", $this->thong_tin_thanh_toan);
        $stmt->bindParam(":trang_thai", $this->trang_thai);
        $stmt->bindParam(":ghi_chu", $this->ghi_chu);

        return $stmt->execute();
    }

    // Cập nhật nhà cung cấp
    public function update() {
        $query = "UPDATE " . $this->table . " 
                SET ten_ncc=:ten_ncc, loai_dich_vu=:loai_dich_vu,
                    dia_chi=:dia_chi, thanh_pho=:thanh_pho,
                    dien_thoai=:dien_thoai, email=:email, website=:website,
                    nguoi_lien_he=:nguoi_lien_he, chuc_vu_lien_he=:chuc_vu_lien_he,
                    dien_thoai_lien_he=:dien_thoai_lien_he,
                    thong_tin_thanh_toan=:thong_tin_thanh_toan,
                    trang_thai=:trang_thai, ghi_chu=:ghi_chu
                WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":ten_ncc", $this->ten_ncc);
        $stmt->bindParam(":loai_dich_vu", $this->loai_dich_vu);
        $stmt->bindParam(":dia_chi", $this->dia_chi);
        $stmt->bindParam(":thanh_pho", $this->thanh_pho);
        $stmt->bindParam(":dien_thoai", $this->dien_thoai);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":website", $this->website);
        $stmt->bindParam(":nguoi_lien_he", $this->nguoi_lien_he);
        $stmt->bindParam(":chuc_vu_lien_he", $this->chuc_vu_lien_he);
        $stmt->bindParam(":dien_thoai_lien_he", $this->dien_thoai_lien_he);
        $stmt->bindParam(":thong_tin_thanh_toan", $this->thong_tin_thanh_toan);
        $stmt->bindParam(":trang_thai", $this->trang_thai);
        $stmt->bindParam(":ghi_chu", $this->ghi_chu);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    // Xóa nhà cung cấp
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Thống kê theo loại dịch vụ
    public function countByService() {
        $query = "SELECT loai_dich_vu, COUNT(*) as total 
                  FROM " . $this->table . " 
                  WHERE trang_thai = 'Đang hợp tác'
                  GROUP BY loai_dich_vu";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>