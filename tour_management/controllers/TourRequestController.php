<?php
// Bắt buộc phải có các file này
require_once 'config/database.php'; 
require_once 'models/TourRequest.php'; 

class TourRequestController {
    
    // Khai báo thuộc tính ở cấp độ Class (private)
    private $db;
    private $request; // Thuộc tính Model TourRequest
    
    // Sửa Constructor để tự khởi tạo kết nối và Model
    public function __construct() {
        // 1. Khởi tạo kết nối DB
        $database = new Database();
        $this->db = $database->getConnection();
        
        // 2. Khởi tạo Model 
        $this->request = new TourRequest($this->db);
    }

    // ------------------------------------------------------------------
    ## Hiển thị Danh sách và Chi tiết
    // ------------------------------------------------------------------
    
    /**
     * Hiển thị danh sách yêu cầu (Action: tour_request_index)
     */
    public function index() {
        // Lấy dữ liệu thực tế từ Model
        $stmt = $this->request->getAll();
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'views/tour_requests/index.php';
    }

    /**
     * Hiển thị chi tiết yêu cầu (Action: tour_request_show)
     */
    public function show($id) {
        $this->request->id = $id;
        if($this->request->getById()) {
            // Biến $this->request chứa dữ liệu đã load, dùng trong views/tour_requests/show.php
            require_once 'views/tour_requests/show.php';
        } else {
            echo "Yêu cầu ID " . htmlspecialchars($id) . " không tồn tại.";
        }
    }

    // ------------------------------------------------------------------
    ## CREATE (Tạo Yêu cầu Mới)
    // ------------------------------------------------------------------

    /**
     * Hiển thị form tạo yêu cầu mới (Action: tour_request_create)
     */
    public function create() {
        require_once 'views/tour_requests/create.php';
    }

    /**
     * Xử lý lưu yêu cầu tour mới (Action: tour_request_store)
     */
    public function store() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Gán dữ liệu vào đối tượng Model ($this->request)
            $this->request->ten_khach_hang = $_POST['ten_khach_hang'] ?? ''; 
            $this->request->dien_thoai = $_POST['dien_thoai'] ?? '';
            $this->request->so_luong_khach = $_POST['so_luong_khach'] ?? 1;

            // Xử lý các trường có thể là NULL trong DB
            $this->request->email = $_POST['email'] ?? null;
           $this->request->diem_den_mong_muon = $_POST['diem_den_mong_muon'] ?? null;
            
            // Xử lý Ngày khởi hành: Nếu rỗng ('') thì gán NULL
            $this->request->ngay_khoi_hanh_mong_luon = !empty($_POST['ngay_khoi_hanh_mong_luon']) ? $_POST['ngay_khoi_hanh_mong_luon'] : null;
            
            // Xử lý Ngân sách: Nếu rỗng ('') thì gán NULL
            $this->request->ngan_sach = !empty($_POST['ngan_sach']) ? $_POST['ngan_sach'] : null; 
            
            $this->request->yeu_cau_chi_tiet = $_POST['yeu_cau_chi_tiet'] ?? null;
            $this->request->trang_thai = $_POST['trang_thai'] ?? 'Mới'; 
            
            if($this->request->create()) {
                header("Location: index.php?action=tour_request_index&message=Tạo yêu cầu tour mới thành công!");
                exit();
            } else {
                // Quay lại form nếu lưu thất bại
                header("Location: index.php?action=tour_request_create&message=Lỗi khi lưu yêu cầu tour! Vui lòng kiểm tra log.");
                exit();
            }
        }
    }
    
    // ------------------------------------------------------------------
    ## DELETE
    // ------------------------------------------------------------------

    /**
     * Xóa yêu cầu (Action: tour_request_delete)
     */
    public function destroy($id) {
        $this->request->id = $id;
        if ($this->request->delete()) {
            header("Location: index.php?action=tour_request_index&message=Đã xóa yêu cầu ID " . htmlspecialchars($id) . ".");
        } else {
            header("Location: index.php?action=tour_request_index&message=Lỗi khi xóa yêu cầu ID " . htmlspecialchars($id) . ".");
        }
        exit();
    }
    
    // ------------------------------------------------------------------
    ## Chức năng hỗ trợ (Tùy chọn)
    // ------------------------------------------------------------------

    /**
     * Cập nhật trạng thái yêu cầu
     */
    public function updateStatus($id) {
        // Cần thêm logic xử lý POST request để lấy trạng thái mới
        // if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trang_thai'])) {
        //     $this->request->id = $id;
        //     $new_status = $_POST['trang_thai'];
        //     if ($this->request->updateStatus($new_status)) {
        //         // Redirect hoặc thông báo thành công
        //     }
        // }
    }
    
    /**
     * Xử lý chuyển dữ liệu yêu cầu sang form tạo Tour chính thức
     */
    public function showCreateTourForm($request_id) {
        // Logic chuyển đổi dữ liệu yêu cầu thành dữ liệu pre-fill cho TourController
        $this->request->id = $request_id;
        if($this->request->getById()) {
            $_SESSION['prefill_tour_data'] = [
                'ten_tour' => "Tour tùy chỉnh cho " . $this->request->ten_khach_hang,
                'so_nguoi' => $this->request->so_luong_khach,
                'ghi_chu' => "Yêu cầu gốc: " . $this->request->yeu_cau_chi_tiet,
                // ... map các trường khác
            ];
            header("Location: index.php?action=tour_create&type=request&request_id=" . $request_id);
            exit();
        } else {
            header("Location: index.php?action=tour_request_index&message=Không tìm thấy yêu cầu để chuyển đổi.");
            exit();
        }
    }
}
?>