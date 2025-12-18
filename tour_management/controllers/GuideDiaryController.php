<?php
class GuideDiaryController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Hiển thị danh sách nhật ký
    public function index() {
        $booking_id = $_GET['booking_id'] ?? null;
        $query = "SELECT * FROM guide_diaries WHERE booking_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$booking_id]);
        $diaries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include "views/guides/diary.php";
    }

    // Hiển thị form thêm
    public function add() {
        include "views/guides/diary_add.php";
    }

    // Lưu vào database
    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $booking_id = $_POST['booking_id'];
            $tieu_de = $_POST['tieu_de'];
            $noi_dung = $_POST['noi_dung'];
            $user_id = $_SESSION['user_id'] ?? null; // Nếu có đăng nhập

            $query = "INSERT INTO guide_diaries (booking_id, user_id, tieu_de, noi_dung, created_at) 
                      VALUES (:booking_id, :user_id, :tieu_de, :noi_dung, NOW())";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':booking_id' => $booking_id,
                ':user_id'    => $user_id,
                ':tieu_de'    => $tieu_de,
                ':noi_dung'   => $noi_dung
            ]);

            header("Location: index.php?action=guide_diary&booking_id=" . $booking_id);
            exit;
        }
    }
}