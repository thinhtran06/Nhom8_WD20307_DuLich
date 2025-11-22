<?php
// controllers/UserController.php

// Đảm bảo file Model được tải (hoặc dùng Autoloading)
require_once 'models/User.php'; 

class UserController {
    private $userModel;

    // LỖI 1: KHẮC PHỤC - Thêm tham số $db để khởi tạo Model
    public function __construct($db) {
        // LỖI 2: KHẮC PHỤC - Khởi tạo lớp User
        $this->userModel = new User($db); 
    }

    // 1. INDEX: Hiển thị danh sách người dùng
    public function index() {
        // LỖI: KHẮC PHỤC - Đổi tên phương thức từ getAllUsers() thành getAll()
        $users = $this->userModel->getAll(); 
        
        require_once 'views/users/index.php'; 
    }

    // 2. CREATE: Hiển thị form tạo mới
    public function create() {
        require_once 'views/users/create.php';
    }

    // 3. STORE: Xử lý dữ liệu từ form tạo mới và lưu vào DB
  // controllers/UserController.php (Phương thức store)

public function store() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;
        
        // Lấy username để kiểm tra, sử dụng ?? '' để tránh lỗi
        $username = $data['username'] ?? '';
        
        // KIỂM TRA TRÙNG LẶP
        if ($this->userModel->isUsernameExists($username)) {
            // Chuyển hướng trở lại form tạo mới với thông báo lỗi
            header("Location: index.php?action=user_create&error=Tên đăng nhập '$username' đã tồn tại, vui lòng chọn tên khác.");
            exit();
        }
            
        // 1. ĐỊNH NGHĨA VÀ KIỂM TRA VAI TRÒ HỢP LỆ
        $validRoles = ['Admin', 'Staff'];
        $submittedRole = $data['role'] ?? '';
        
        if (in_array($submittedRole, $validRoles)) {
            $roleToAssign = $submittedRole;
        } else {
            // Gán vai trò mặc định là Staff nếu không hợp lệ hoặc bị thiếu
            $roleToAssign = 'Staff'; 
        }

        // 2. Gán dữ liệu vào Model (Đảm bảo sử dụng ?? '' cho tất cả các trường)
        $this->userModel->username = $username;
        $this->userModel->email = $data['email'] ?? '';
        $this->userModel->password = $data['password'] ?? ''; // Mật khẩu sẽ được hash trong Model
        $this->userModel->ho_ten = ''; // Trường ho_ten rỗng như bạn yêu cầu
        $this->userModel->role = $roleToAssign; // Gán vai trò đã được kiểm tra
        $this->userModel->trang_thai = $data['trang_thai'] ?? 'active'; // Gán trạng thái

        // 3. Thực hiện tạo user
        if ($this->userModel->create()) {
            header("Location: index.php?action=user_index&message=Thêm người dùng thành công!");
            exit();
        } else {
            header("Location: index.php?action=user_create&error=Lỗi khi thêm người dùng.");
            exit();
        }
    }
}

    // 4. SHOW: Hiển thị chi tiết 1 người dùng
    public function show($id) {
        // LỖI: KHẮC PHỤC - Đổi tên phương thức từ getUserById() thành getById()
        $user = $this->userModel->getById($id); 
        
        if (!$user) {
            header("Location: index.php?action=user_index&error=Người dùng không tồn tại.");
            exit();
        }
        require_once 'views/users/detail.php';
    }

    // 5. EDIT: Hiển thị form sửa
    public function edit($id) {
        // LỖI: KHẮC PHỤC - Đổi tên phương thức từ getUserById() thành getById()
        $user = $this->userModel->getById($id);
        
        if (!$user) {
            header("Location: index.php?action=user_index&error=Người dùng không tồn tại.");
            exit();
        }
        require_once 'views/users/edit.php';
    }

    // 6. UPDATE: Xử lý dữ liệu từ form sửa và cập nhật DB
// controllers/UserController.php (Phương thức update)

public function update($id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;
        
        // 1. Định nghĩa và kiểm tra vai trò hợp lệ
        $validRoles = ['Admin', 'Staff'];
        $submittedRole = $data['role'] ?? '';
        
        if (in_array($submittedRole, $validRoles)) {
            $roleToAssign = $submittedRole;
        } else {
            // Gán vai trò mặc định là Staff nếu không hợp lệ hoặc bị thiếu
            $roleToAssign = 'Staff'; 
        }

        // 2. Gán dữ liệu vào Model
        $this->userModel->id = $id; // RẤT QUAN TRỌNG: ID của user cần cập nhật
        
        // SỬA LỖI: Sử dụng ?? '' để tránh lỗi Deprecated khi gọi strip_tags(null) trong Model
        $this->userModel->username = $data['username'] ?? ''; 
        $this->userModel->email = $data['email'] ?? '';
        
        // Mật khẩu có thể null nếu không nhập gì, nên giữ nguyên logic ?? null
        $this->userModel->password = $data['password'] ?? null; 
        
        // BỎ TRƯỜNG ho_ten: Gán rỗng vì bạn không dùng nó khi thêm/sửa
        $this->userModel->ho_ten = ''; 
        
        $this->userModel->role = $roleToAssign; // Gán vai trò đã được kiểm tra
        $this->userModel->trang_thai = $data['trang_thai'] ?? 'active';

        // 3. Thực hiện cập nhật
        if ($this->userModel->update()) {
            header("Location: index.php?action=user_show&id=$id&message=Cập nhật thành công!");
            exit();
        } else {
            header("Location: index.php?action=user_edit&id=$id&error=Lỗi khi cập nhật.");
            exit();
        }
    }
}

    // 7. DESTROY: Xử lý xóa 1 người dùng
    public function destroy($id) {
        // Gán ID vào Model
        $this->userModel->id = $id;
        
        // LỖI: KHẮC PHỤC - Đổi tên phương thức từ deleteUser() thành delete()
        if ($this->userModel->delete()) {
            header("Location: index.php?action=user_index&message=Xóa người dùng thành công.");
        } else {
            header("Location: index.php?action=user_index&error=Lỗi khi xóa người dùng.");
        }
        exit();
    }
}