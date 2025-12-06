<?php
require_once 'config/database.php';
require_once 'config/session.php';
require_once 'models/Supplier.php';

class SupplierController {
    private $db;
    private $supplier;

    public function __construct() {
        requireLogin();
        $database = new Database();
        $this->db = $database->getConnection();
        $this->supplier = new Supplier($this->db);
    }

    // Hiển thị danh sách nhà cung cấp
    public function index() {
        $stmt = $this->supplier->getAll();
        $suppliers = $stmt->fetchAll();
        require_once 'views/suppliers/index.php';
    }

    // Hiển thị form tạo nhà cung cấp
    public function create() {
        require_once 'views/suppliers/create.php';
    }

    // Xử lý tạo nhà cung cấp mới
    public function store() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->supplier->ten_ncc = trim($_POST['ten_ncc']);
            $this->supplier->loai_dich_vu = $_POST['loai_dich_vu'];
            $this->supplier->dia_chi = trim($_POST['dia_chi']);
            $this->supplier->thanh_pho = trim($_POST['thanh_pho']);
            $this->supplier->dien_thoai = trim($_POST['dien_thoai']);
            $this->supplier->email = trim($_POST['email']);
            $this->supplier->website = trim($_POST['website']);
            $this->supplier->nguoi_lien_he = trim($_POST['nguoi_lien_he']);
            $this->supplier->chuc_vu_lien_he = trim($_POST['chuc_vu_lien_he']);
            $this->supplier->dien_thoai_lien_he = trim($_POST['dien_thoai_lien_he']);
            $this->supplier->thong_tin_thanh_toan = trim($_POST['thong_tin_thanh_toan']);
            $this->supplier->trang_thai = $_POST['trang_thai'];
            $this->supplier->ghi_chu = trim($_POST['ghi_chu']);

            if($this->supplier->create()) {
                header("Location: index.php?action=supplier_index&message=Thêm nhà cung cấp thành công");
                exit();
            } else {
                header("Location: index.php?action=supplier_create&error=Có lỗi xảy ra");
                exit();
            }
        }
    }

    // Hiển thị chi tiết nhà cung cấp
    public function show($id) {
        $this->supplier->id = $id;
        if($this->supplier->getById()) {
            require_once 'views/suppliers/detail.php';
        } else {
            header("Location: index.php?action=supplier_index&error=Nhà cung cấp không tồn tại");
            exit();
        }
    }

    // Hiển thị form chỉnh sửa
    public function edit($id) {
        $this->supplier->id = $id;
        if($this->supplier->getById()) {
            require_once 'views/suppliers/edit.php';
        } else {
            header("Location: index.php?action=supplier_index&error=Nhà cung cấp không tồn tại");
            exit();
        }
    }

    // Xử lý cập nhật nhà cung cấp
    public function update($id) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->supplier->id = $id;
            $this->supplier->ten_ncc = trim($_POST['ten_ncc']);
            $this->supplier->loai_dich_vu = $_POST['loai_dich_vu'];
            $this->supplier->dia_chi = trim($_POST['dia_chi']);
            $this->supplier->thanh_pho = trim($_POST['thanh_pho']);
            $this->supplier->dien_thoai = trim($_POST['dien_thoai']);
            $this->supplier->email = trim($_POST['email']);
            $this->supplier->website = trim($_POST['website']);
            $this->supplier->nguoi_lien_he = trim($_POST['nguoi_lien_he']);
            $this->supplier->chuc_vu_lien_he = trim($_POST['chuc_vu_lien_he']);
            $this->supplier->dien_thoai_lien_he = trim($_POST['dien_thoai_lien_he']);
            $this->supplier->thong_tin_thanh_toan = trim($_POST['thong_tin_thanh_toan']);
            $this->supplier->trang_thai = $_POST['trang_thai'];
            $this->supplier->ghi_chu = trim($_POST['ghi_chu']);

            if($this->supplier->update()) {
                header("Location: index.php?action=supplier_index&message=Cập nhật thành công");
                exit();
            } else {
                header("Location: index.php?action=supplier_edit&id=$id&error=Có lỗi xảy ra");
                exit();
            }
        }
    }

    // Xóa nhà cung cấp
    public function destroy($id) {
        $this->supplier->id = $id;
        if($this->supplier->delete()) {
            header("Location: index.php?action=supplier_index&message=Xóa nhà cung cấp thành công");
            exit();
        } else {
            header("Location: index.php?action=supplier_index&error=Có lỗi xảy ra");
            exit();
        }
    }
}
?>