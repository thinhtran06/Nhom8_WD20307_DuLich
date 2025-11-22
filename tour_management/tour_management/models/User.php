<?php
// models/User.php - Hoàn chỉnh các chức năng CRUD

class User {
    private $conn;
    private $table = "users";

    // Khai báo các thuộc tính (properties)
    public $id;
    public $username;
    public $email;
    public $password; // Chỉ dùng khi tạo mới hoặc cập nhật
    public $ho_ten;
    public $role;
    public $trang_thai;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // =================================================================
    //                            A. AUTHENTICATION
    // =================================================================

    // Đăng nhập (Giữ nguyên logic của bạn)
    public function login($username, $password) {
        $query = "SELECT id, username, email, ho_ten, role, password, trang_thai 
                  FROM " . $this->table . " 
                  WHERE username = :username AND trang_thai = 'active' 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Kiểm tra password đã hash
            if(password_verify($password, $row['password'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->email = $row['email'];
                $this->ho_ten = $row['ho_ten'];
                $this->role = $row['role'];
                return true;
            }
        }
        return false;
    }

    // =================================================================
    //                            B. READ OPERATIONS (R)
    // =================================================================

    // 1. Lấy tất cả người dùng (Dùng cho action user_index)
    public function getAll() {
        $query = "SELECT id, username, email, ho_ten, role, trang_thai, created_at
                  FROM " . $this->table . " 
                  ORDER BY id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        // Trả về tất cả kết quả dưới dạng mảng kết hợp
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // 2. Lấy user theo ID (Dùng cho action user_show và user_edit)
// models/User.php (Sửa phương thức getById)

public function getById($id = null) {
    $id_to_fetch = $id ?? $this->id; 

    // BỎ CỘT updated_at nếu nó không tồn tại trong DB
    $query = "SELECT id, username, email, ho_ten, role, trang_thai, created_at
              FROM " . $this->table . " 
              WHERE id = :id LIMIT 1";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id_to_fetch);
    $stmt->execute(); // <--- Dòng 82

    if($stmt->rowCount() > 0) {
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    return false;
}

    // =================================================================
    //                            C. CREATE OPERATION (C)
    // =================================================================

    // 3. Thêm người dùng mới (Dùng cho action user_store)
    public function create() {
        // Query INSERT
        $query = "INSERT INTO " . $this->table . " 
                  (username, email, password, ho_ten, role, trang_thai) 
                  VALUES (:username, :email, :password, :ho_ten, :role, :trang_thai)";

        $stmt = $this->conn->prepare($query);

        // Làm sạch và gán giá trị cho các tham số
        $username = htmlspecialchars(strip_tags($this->username));
        $email = htmlspecialchars(strip_tags($this->email));
        $ho_ten = htmlspecialchars(strip_tags($this->ho_ten));
        $role = htmlspecialchars(strip_tags($this->role));
        // Giả sử Controller/Form luôn cung cấp trang_thai (mặc định 'active')
        $trang_thai = htmlspecialchars(strip_tags($this->trang_thai)); 
        
        // Hash mật khẩu (BẮT BUỘC)
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
        
        // Bind Data
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password); // Bind mật khẩu đã hash
        $stmt->bindParam(':ho_ten', $ho_ten);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':trang_thai', $trang_thai);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // =================================================================
    //                            D. UPDATE OPERATION (U)
    // =================================================================

    // 4. Cập nhật người dùng (Dùng cho action user_update)
    public function update() {
        // Kiểm tra xem có mật khẩu mới được cung cấp không
       $password_sql = '';
    if (!empty($this->password)) {
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
        $password_sql = "password = :password, ";
    }

    $query = "UPDATE " . $this->table . "
              SET 
                  username = :username,
                  email = :email,
                  ho_ten = :ho_ten,
                  role = :role,
                  trang_thai = :trang_thai
                  $password_sql
                  -- BỎ DÒNG SAU NẾU updated_at KHÔNG TỒN TẠI
                  -- updated_at = NOW()
              WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        // Làm sạch và gán giá trị
        $id = htmlspecialchars(strip_tags($this->id));
        $username = htmlspecialchars(strip_tags($this->username));
        $email = htmlspecialchars(strip_tags($this->email));
        $ho_ten = htmlspecialchars(strip_tags($this->ho_ten));
        $role = htmlspecialchars(strip_tags($this->role));
        $trang_thai = htmlspecialchars(strip_tags($this->trang_thai));
        
        // Bind ID (quan trọng)
        $stmt->bindParam(':id', $id);

        // Bind các trường dữ liệu
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':ho_ten', $ho_ten);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':trang_thai', $trang_thai);

        // Bind mật khẩu nếu nó được cung cấp
        if (!empty($this->password)) {
            $stmt->bindParam(':password', $hashed_password);
        }

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // =================================================================
    //                            E. DELETE OPERATION (D)
    // =================================================================

    // 5. Xóa người dùng (Dùng cho action user_delete/destroy)
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        // Làm sạch và bind ID
        $id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    // models/User.php (Phương thức bổ sung)

public function isUsernameExists($username) {
    $query = "SELECT id FROM " . $this->table . " WHERE username = :username LIMIT 1";
    $stmt = $this->conn->prepare($query);
    
    $username = htmlspecialchars(strip_tags($username));
    $stmt->bindParam(':username', $username);
    
    $stmt->execute();
    
    // Trả về true nếu có dòng dữ liệu (tên đăng nhập đã được sử dụng)
    return $stmt->rowCount() > 0;
}
}