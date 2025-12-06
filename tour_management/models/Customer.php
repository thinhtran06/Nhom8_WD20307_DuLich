<?php
class Customer
{
    private $conn;
    private $table = "customers";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy 1 khách theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Lấy tất cả khách
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Tạo khách hàng mới => trả về ID mới tạo
    public function store($data)
    {
        $sql = "INSERT INTO {$this->table}
                (ho_ten, dien_thoai, cmnd_cccd, dia_chi, ngay_sinh, gioi_tinh, quoc_tich, ghi_chu)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $data['ho_ten']     ?? '',
            $data['dien_thoai'] ?? '',
            $data['cmnd_cccd']  ?? '',
            $data['dia_chi']    ?? '',
            $data['ngay_sinh']  ?? null,
            $data['gioi_tinh']  ?? null,
            $data['quoc_tich']  ?? null,
            $data['ghi_chu']    ?? null,
        ]);

        return $this->conn->lastInsertId();
    }
}
