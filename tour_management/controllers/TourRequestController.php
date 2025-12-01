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
// -----------------------------
    // Hiển thị chi tiết
    // -----------------------------
    public function detail() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?action=tour_request_index&message=Thiếu ID");
            exit;
        }

        $id = intval($_GET['id']);
        $data = $this->request->findById($id);

        if (!$data) {
            header("Location: index.php?action=tour_request_index&message=Không tìm thấy yêu cầu");
            exit;
        }

        require_once 'views/tour_requests/detail.php';
    }

    // -----------------------------
    // Xóa yêu cầu
    // -----------------------------
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
            header("Location: index.php?action=tour_request_index&message=Yêu cầu không hợp lệ");
            exit;
        }

        $id = intval($_POST['id']);

        if ($this->request->delete($id)) {
            header("Location: index.php?action=tour_request_index&message=Xóa thành công");
        } else {
            header("Location: index.php?action=tour_request_index&message=Xóa thất bại");
        }
        exit;
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
    // Hiển thị form edit (GET)
// --- 5. HIỂN THỊ FORM CHỈNH SỬA (GET EDIT FORM) ---
    public function edit($id) {
        // Lấy dữ liệu dưới dạng mảng kết hợp (assoc array)
        $tourRequest = $this->request->findById($id); 
        
        if($tourRequest) {
            require_once 'views/tour_requests/edit.php';
        } else {
            echo "Yêu cầu tour không tồn tại!";
        }
    }

    // --- 6. XỬ LÝ CẬP NHẬT (UPDATE) ---
    public function update($id) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->request->id = $id;
            // Gán dữ liệu POST vào thuộc tính của đối tượng $this->request
            $this->request->ten_khach_hang = $_POST['ten_khach_hang'];
            $this->request->dien_thoai = $_POST['dien_thoai'];
            $this->request->email = $_POST['email'];
            $this->request->so_luong_khach = $_POST['so_luong_khach'] ?? 1;
            $this->request->diem_den_mong_muon = $_POST['diem_den_mong_muon'];
            
            // Xử lý ngày khởi hành có thể NULL
            $this->request->ngay_khoi_hanh_mong_luon = !empty($_POST['ngay_khoi_hanh_mong_luon']) ? $_POST['ngay_khoi_hanh_mong_luon'] : null;
            
            // Xử lý ngân sách có thể NULL
            $this->request->ngan_sach = !empty($_POST['ngan_sach']) ? $_POST['ngan_sach'] : null;
            
            $this->request->yeu_cau_chi_tiet = $_POST['yeu_cau_chi_tiet'];
            $this->request->trang_thai = $_POST['trang_thai'];
            
            if($this->request->update()) {
                // Điều hướng về trang Edit hoặc Show để tải lại dữ liệu mới nhất
                header("Location: index.php?action=tour_request_edit&id=$id&message=Cập nhật yêu cầu tour thành công!");
                exit();
            } else {
                // Điều hướng về trang Edit hiện tại với thông báo lỗi
                header("Location: index.php?action=tour_request_edit&id=$id&error=Có lỗi xảy ra khi cập nhật!");
                exit();
            }
        }
    }



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