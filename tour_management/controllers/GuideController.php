<?php
class GuideController {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Hiển thị danh sách tất cả hướng dẫn viên
    public function index(){
        require_once "models/Guide.php";
        $model = new Guide($this->conn);
        $guides = $model->getAll();
        include "views/guides/index.php";
    }

    public function create() {
        include "views/guides/create.php";
    }

    public function store() {
        require_once "models/Guide.php";
        $model = new Guide($this->conn);

        $model->store([
            'ho_ten'       => $_POST['ho_ten'] ?? '',
            'ngay_sinh'    => $_POST['ngay_sinh'] ?? null,
            'gioi_tinh'    => $_POST['gioi_tinh'] ?? 'Nam',
            'dien_thoai'   => $_POST['dien_thoai'] ?? '',
            'email'        => $_POST['email'] ?? '',
            'dia_chi'      => $_POST['dia_chi'] ?? '',
            'ngon_ngu'     => $_POST['ngon_ngu'] ?? '',
            'kinh_nghiem'  => $_POST['kinh_nghiem'] ?? 0,
            'ghi_chu'      => $_POST['ghi_chu'] ?? '',
            'trang_thai'   => $_POST['trang_thai'] ?? 'Đang hoạt động',
            'anh_dai_dien' => null 
        ]);

        header("Location: index.php?action=guide_index");
        exit;
    }

    public function edit($id) {
        require_once "models/Guide.php";
        $model = new Guide($this->conn);
        $guide = $model->getById($id);
        if (!$guide) die("Không tìm thấy HDV");

        include "views/guides/edit.php";
    }

    public function update() {
        require_once "models/Guide.php";
        $model = new Guide($this->conn);

        $id = intval($_POST['id']);

        $model->update($id, [
            'ho_ten'     => $_POST['ho_ten'],
            'ngay_sinh'  => $_POST['ngay_sinh'],
            'gioi_tinh'  => $_POST['gioi_tinh'],
            'dien_thoai' => $_POST['dien_thoai'],
            'email'      => $_POST['email'],
            'dia_chi'    => $_POST['dia_chi'],
            'ngon_ngu'   => $_POST['ngon_ngu'],
            'trang_thai' => $_POST['trang_thai']
        ]);

        header("Location: index.php?action=guide_index");
        exit;
    }

    public function destroy($id) {
        require_once "models/Guide.php";
        $model = new Guide($this->conn);
        $model->delete($id);
        header("Location: index.php?action=guide_index");
        exit;
    }

    // Hiển thị lịch làm việc của một HDV cụ thể
    public function schedule() {
        $guide_id = $_GET['guide_id'] ?? null;
        if (!$guide_id) {
            header("Location: index.php?action=guide_index");
            exit;
        }

        require_once "models/Guide.php";
        $model = new Guide($this->conn);
        
        $guide = $model->getById($guide_id);
        $schedules = $model->getSchedule($guide_id);

        include "views/guides/schedule.php";
    }

    /**
     * Hàm xem chi tiết Tour dành cho HDV
     * Tương thích với Model Tour hiện tại (Gán ID trước khi getById)
     */
   public function tourDetail() {
    $tour_id = isset($_GET['tour_id']) ? $_GET['tour_id'] : null;

    if (!$tour_id) {
        header("Location: index.php?action=guide_schedule");
        exit;
    }

    require_once "models/Tour.php";
    $tourModel = new Tour($this->conn);
    
    // Gán ID và lấy dữ liệu từ bảng tours
    $tourModel->id = $tour_id;
    $result = $tourModel->getById();

    if (!$result) {
        die("Không tìm thấy dữ liệu Tour.");
    }

    // Đóng gói dữ liệu để truyền sang View
    $tour = [
        'ten_tour'       => $tourModel->ten_tour,
        'mo_ta'          => $tourModel->mo_ta,
        'diem_khoi_hanh' => $tourModel->diem_khoi_hanh,
        'diem_den'       => $tourModel->diem_den,
        'so_ngay'        => $tourModel->so_ngay,
        'lich_trinh'     => $tourModel->lich_trinh // Đây là nội dung text bạn đã nhập
    ];

    include "views/guides/tour_detail.php";
}
}