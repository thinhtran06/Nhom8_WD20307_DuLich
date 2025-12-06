<?php
// Bắt buộc phải có các file này
require_once 'config/database.php'; 
require_once 'models/TourRequest.php'; 

class TourRequestController {
    
    private $db;
    private $request; // Model TourRequest
    
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->request = new TourRequest($this->db);
    }

    // ------------------------------------------------------------------
    // 1. DANH SÁCH YÊU CẦU TOUR
    // ------------------------------------------------------------------
    public function index() {
        $stmt = $this->request->getAll();
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/tour_requests/index.php';
    }

    // ------------------------------------------------------------------
    // 2. HIỂN THỊ CHI TIẾT
    // ------------------------------------------------------------------
    public function detail() {
        $id = $_GET['id'] ?? 0;
        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "ID không hợp lệ!";
            header("Location: index.php?action=tour_request_index");
            exit;
        }

        $data = $this->request->findById($id);
        if (!$data) {
            $_SESSION['error'] = "Không tìm thấy yêu cầu tour!";
            header("Location: index.php?action=tour_request_index");
            exit;
        }

        $tourRequest = $data; // để view dùng biến $tourRequest
        require_once 'views/tour_requests/detail.php';
    }

    // ------------------------------------------------------------------
    // 3. XÓA YÊU CẦU
    // ------------------------------------------------------------------
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
            $_SESSION['error'] = "Yêu cầu không hợp lệ!";
            header("Location: index.php?action=tour_request_index");
            exit;
        }

        $id = (int)$_POST['id'];
        if ($this->request->delete($id)) {
            $_SESSION['success'] = "Xóa thành công!";
        } else {
            $_SESSION['error'] = "Xóa thất bại!";
        }
        header("Location: index.php?action=tour_request_index");
        exit;
    }

    // ------------------------------------------------------------------
    // 4. HIỂN THỊ FORM SỬA (GET)
    // ------------------------------------------------------------------
    public function edit() {
        $id = $_GET['id'] ?? 0;
        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "ID không hợp lệ!";
            header("Location: index.php?action=tour_request_index");
            exit;
        }

        $tourRequest = $this->request->findById($id);
        if (!$tourRequest) {
            $_SESSION['error'] = "Yêu cầu tour không tồn tại!";
            header("Location: index.php?action=tour_request_index");
            exit;
        }

        require_once 'views/tour_requests/edit.php';
    }

    // ------------------------------------------------------------------
    // 5. XỬ LÝ CẬP NHẬT (POST) – ĐÃ FIX HOÀN TOÀN
    // ------------------------------------------------------------------
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=tour_request_index");
            exit;
        }

        // LẤY ID TỪ FORM (bắt buộc có input hidden name="id")
        $id = $_POST['id'] ?? 0;
        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "ID yêu cầu không hợp lệ!";
            header("Location: index.php?action=tour_request_index");
            exit;
        }

        // KIỂM TRA BẢN GHI CÓ TỒN TẠI KHÔNG
        if (!$this->request->findById($id)) {
            $_SESSION['error'] = "Yêu cầu tour không tồn tại hoặc đã bị xóa!";
            header("Location: index.php?action=tour_request_index");
            exit;
        }

        // GÁN DỮ LIỆU VÀO MODEL
        $this->request->id = (int)$id;
        $this->request->ten_khach_hang     = trim($_POST['ten_khach_hang'] ?? '');
        $this->request->dien_thoai         = trim($_POST['dien_thoai'] ?? '');
        $this->request->email              = !empty(trim($_POST['email'] ?? '')) ? trim($_POST['email']) : null;
        $this->request->so_luong_khach     = (int)($_POST['so_luong_khach'] ?? 1);
        $this->request->diem_den_mong_muon = trim($_POST['diem_den_mong_muon'] ?? '');
        $this->request->ngay_khoi_hanh_mong_luon = !empty($_POST['ngay_khoi_hanh_mong_luon']) ? $_POST['ngay_khoi_hanh_mong_luon'] : null;
        $this->request->yeu_cau_chi_tiet   = trim($_POST['yeu_cau_chi_tiet'] ?? '') ?: null;
        $this->request->trang_thai         = trim($_POST['trang_thai'] ?? 'Mới');

        // XỬ LÝ NGÂN SÁCH (loại bỏ dấu phẩy, chấm)
        $ngan_sach_raw = preg_replace('/[^0-9]/', '', $_POST['ngan_sach'] ?? '');
        $this->request->ngan_sach = ($ngan_sach_raw === '' || $ngan_sach_raw === '0') ? null : (int)$ngan_sach_raw;

        // THỰC HIỆN CẬP NHẬT
        if ($this->request->update()) {
            $_SESSION['success'] = "Cập nhật yêu cầu tour thành công!";
        } else {
            $_SESSION['error'] = "Cập nhật thất bại! Vui lòng thử lại.";
        }

        header("Location: index.php?action=tour_request_index");
        exit;
    }

    // ------------------------------------------------------------------
    // 6. TẠO MỚI – HIỂN THỊ FORM
    // ------------------------------------------------------------------
    public function create() {
        require_once 'views/tour_requests/create.php';
    }

    // ------------------------------------------------------------------
    // 7. LƯU YÊU CẦU MỚI
    // ------------------------------------------------------------------
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=tour_request_create");
            exit;
        }

        $this->request->ten_khach_hang     = trim($_POST['ten_khach_hang'] ?? '');
        $this->request->dien_thoai         = trim($_POST['dien_thoai'] ?? '');
        $this->request->email              = !empty(trim($_POST['email'] ?? '')) ? trim($_POST['email']) : null;
        $this->request->so_luong_khach     = (int)($_POST['so_luong_khach'] ?? 1);
        $this->request->diem_den_mong_muon = trim($_POST['diem_den_mong_muon'] ?? '');
        $this->request->ngay_khoi_hanh_mong_luon = !empty($_POST['ngay_khoi_hanh_mong_luon']) ? $_POST['ngay_khoi_hanh_mong_luon'] : null;
        $this->request->yeu_cau_chi_tiet   = trim($_POST['yeu_cau_chi_tiet'] ?? '') ?: null;
        $this->request->trang_thai         = trim($_POST['trang_thai'] ?? 'Mới');

        // Xử lý ngân sách
        $ngan_sach_raw = preg_replace('/[^0-9]/', '', $_POST['ngan_sach'] ?? '');
        $this->request->ngan_sach = ($ngan_sach_raw === '' || $ngan_sach_raw === '0') ? null : (int)$ngan_sach_raw;

        if ($this->request->create()) {
            $_SESSION['success'] = "Tạo yêu cầu tour thành công!";
            header("Location: index.php?action=tour_request_index");
        } else {
            $_SESSION['error'] = "Lỗi khi lưu yêu cầu tour!";
            header("Location: index.php?action=tour_request_create");
        }
        exit;
    }

    // ------------------------------------------------------------------
    // 8. CẬP NHẬT TRẠNG THÁI (nếu cần dùng riêng)
    // ------------------------------------------------------------------
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['trang_thai'])) {
            $this->request->id = (int)$_POST['id'];
            $new_status = trim($_POST['trang_thai']);
            if ($this->request->updateStatus($new_status)) {
                $_SESSION['success'] = "Cập nhật trạng thái thành công!";
            } else {
                $_SESSION['error'] = "Cập nhật trạng thái thất bại!";
            }
        }
        header("Location: index.php?action=tour_request_index");
        exit;
    }
}
?>