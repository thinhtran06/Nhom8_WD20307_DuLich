<?php
require_once 'config/database.php';
require_once 'models/Tour.php';

class TourController {
    private $db;
    private $tour;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->tour = new Tour($this->db);
    }

    // Hiển thị danh sách tour
    public function index() {
        $stmt = $this->tour->getAll();
        $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/tours/index.php';
    }

    // Hiển thị form tạo tour
    public function create() {
        require_once 'views/tours/create.php';
    }

    // Xử lý tạo tour mới
    public function store() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->tour->ten_tour = $_POST['ten_tour'];
            $this->tour->mo_ta = $_POST['mo_ta'];
            $this->tour->diem_khoi_hanh = $_POST['diem_khoi_hanh'];
            $this->tour->diem_den = $_POST['diem_den'];
            $this->tour->ngay_khoi_hanh = $_POST['ngay_khoi_hanh'];
            $this->tour->so_ngay = $_POST['so_ngay'];
            $this->tour->gia_tour = $_POST['gia_tour'];
            $this->tour->so_cho = $_POST['so_cho'];
            $this->tour->trang_thai = $_POST['trang_thai'];
            $this->tour->lich_trinh = $_POST['lich_trinh'] ?? null;

            if($this->tour->create()) {
               header("Location: index.php?action=tour_index&message=Tạo tour thành công!");
                exit();
            } else {
                echo "Có lỗi xảy ra!";
            }
        }
    }

    // Hiển thị chi tiết tour
    public function show($id) {
        $this->tour->id = $id;
        if($this->tour->getById()) {
            require_once 'views/tours/detail.php';
        } else {
            echo "Tour không tồn tại!";
        }
    }

    // Hiển thị form chỉnh sửa
    public function edit($id) {
        $this->tour->id = $id;
        if($this->tour->getById()) {
            require_once 'views/tours/edit.php';
        } else {
            echo "Tour không tồn tại!";
        }
    }

    // Xử lý cập nhật tour
    public function update($id) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->tour->id = $id;
            $this->tour->ten_tour = $_POST['ten_tour'];
            $this->tour->mo_ta = $_POST['mo_ta'];
            $this->tour->diem_khoi_hanh = $_POST['diem_khoi_hanh'];
            $this->tour->diem_den = $_POST['diem_den'];
            $this->tour->ngay_khoi_hanh = $_POST['ngay_khoi_hanh'];
            $this->tour->so_ngay = $_POST['so_ngay'];
            $this->tour->gia_tour = $_POST['gia_tour'];
            $this->tour->so_cho = $_POST['so_cho'];
            $this->tour->trang_thai = $_POST['trang_thai'];

            if($this->tour->update()) {
               header("Location: index.php?action=tour_index&message=Cập nhật tour ID $id thành công!");
                exit();
            } else {
                echo "Có lỗi xảy ra!";
            }
        }
    }
    // controllers/TourController.php (THÊM PHƯƠNG THỨC MỚI)

    // Phương thức này nhận tham số loại tour từ Router và hiển thị danh sách
    public function listByLoaiTour($loai_tour) {
        // Lấy dữ liệu tour đã được lọc
        $stmt = $this->tour->getByLoaiTour($loai_tour);
        $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Truyền biến tiêu đề để View hiển thị đúng
        $page_title = "Quản lý Tour $loai_tour"; 
        
        require_once 'views/tours/index.php';
    }

// ...

    // Xóa tour
    public function destroy($id) {
        $this->tour->id = $id;
        if($this->tour->delete()) {
            header("Location: index.php?action=tour_index&message=Xóa tour ID $id thành công!");
            exit();
        } else {
            echo "Có lỗi xảy ra!";
        }
    }
}
?>