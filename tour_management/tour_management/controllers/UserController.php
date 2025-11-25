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
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            $username = $data['username'] ?? '';
            
            // KIỂM TRA TRÙNG LẶP
            if ($this->userModel->isUsernameExists($username)) {
                header("Location: index.php?action=user_create&error=Tên đăng nhập '$username' đã tồn tại, vui lòng chọn tên khác.");
                exit();
            }
                
            // 1. ĐỊNH NGHĨA VÀ KIỂM TRA VAI TRÒ HỢP LỆ
            $validRoles = ['Admin', 'Staff'];
            $submittedRole = $data['role'] ?? '';
            
            if (in_array($submittedRole, $validRoles)) {
                $roleToAssign = $submittedRole;
            } else {
                $roleToAssign = 'Staff'; 
            }

            // 2. Gán dữ liệu vào Model
            $this->userModel->username = $username;
            $this->userModel->email = $data['email'] ?? '';
            $this->userModel->password = $data['password'] ?? ''; 
            $this->userModel->ho_ten = ''; 
            $this->userModel->role = $roleToAssign; 
            $this->userModel->trang_thai = $data['trang_thai'] ?? 'active'; 

            // 3. Thực hiện tạo user
            if ($this->userModel->create()) {
                // CHUYỂN HƯỚNG VỀ DANH SÁCH USER
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
        $user = $this->userModel->getById($id); 
        
        if (!$user) {
            header("Location: index.php?action=user_index&error=Người dùng không tồn tại.");
            exit();
        }
        require_once 'views/users/detail.php';
    }

    // 5. EDIT: Hiển thị form sửa
    public function edit($id) {
        $user = $this->userModel->getById($id);
        
        if (!$user) {
            header("Location: index.php?action=user_index&error=Người dùng không tồn tại.");
            exit();
        }
        require_once 'views/users/edit.php';
    }

    // 6. UPDATE: Xử lý dữ liệu từ form sửa và cập nhật DB
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            
            // 1. Định nghĩa và kiểm tra vai trò hợp lệ
            $validRoles = ['Admin', 'Staff'];
            $submittedRole = $data['role'] ?? '';
            
            if (in_array($submittedRole, $validRoles)) {
                $roleToAssign = $submittedRole;
            } else {
                $roleToAssign = 'Staff'; 
            }

            // 2. Gán dữ liệu vào Model
            $this->userModel->id = $id;
            $this->userModel->username = $data['username'] ?? ''; 
            $this->userModel->email = $data['email'] ?? '';
            $this->userModel->password = $data['password'] ?? null; 
            $this->userModel->ho_ten = ''; 
            $this->userModel->role = $roleToAssign; 
            $this->userModel->trang_thai = $data['trang_thai'] ?? 'active';

            // 3. Thực hiện cập nhật
            if ($this->userModel->update()) {
                // ĐÃ SỬA: CHUYỂN HƯỚNG VỀ DANH SÁCH USER (user_index)
                header("Location: index.php?action=user_index&message=Cập nhật người dùng ID $id thành công!");
                exit();
            } else {
                // Giữ nguyên: Trở lại trang edit nếu lỗi
                header("Location: index.php?action=user_edit&id=$id&error=Lỗi khi cập nhật người dùng.");
                exit();
            }
        }
    }

    // 7. DESTROY: Xử lý xóa 1 người dùng
    public function destroy($id) {
        $this->userModel->id = $id;
        
        if ($this->userModel->delete()) {
            // ĐÃ CHÍNH XÁC: CHUYỂN HƯỚNG VỀ DANH SÁCH USER
            header("Location: index.php?action=user_index&message=Xóa người dùng thành công.");
        } else {
            // ĐÃ CHÍNH XÁC: CHUYỂN HƯỚNG VỀ DANH SÁCH USER
            header("Location: index.php?action=user_index&error=Lỗi khi xóa người dùng.");
        }
        exit();
    }
}