<?php
require_once __DIR__ . '/../config/database.php';

class AttendanceController
{
    public function checkin()
    {
        if (!isset($_SESSION['user_id'])) {
            echo "Bạn cần đăng nhập!";
            return;
        }

        $schedule_id = $_GET['schedule_id'];
        $user_id = $_SESSION['user_id'];

        // Kết nối DB đúng cách
        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->prepare("
            INSERT INTO attendance (schedule_id, user_id, status)
            VALUES (:sid, :uid, 'present')
        ");

        $stmt->bindParam(":sid", $schedule_id);
        $stmt->bindParam(":uid", $user_id);

        if ($stmt->execute()) {
            header("Location: index.php?action=tour_detail&id=" . $_GET['tour_id']);
            exit;
        } else {
            echo "Lỗi điểm danh!";
        }
    }
}
