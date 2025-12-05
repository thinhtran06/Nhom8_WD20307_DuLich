<?php

require_once 'config/database.php';

class GuideWorkController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // B1: Chọn HDV
    public function selectGuide()
    {
        $sql = "SELECT id, ho_ten 
                FROM guides 
                WHERE trang_thai = 'Đang hoạt động'
                ORDER BY ho_ten";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $guides = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require 'views/guide_work/select_guide.php';
    }

    // B2: Xem danh sách tour của 1 HDV
    public function toursByGuide()
    {
        if (!isset($_GET['guide_id']) || !is_numeric($_GET['guide_id'])) {
            header("Location: index.php?action=guide_work_select");
            exit;
        }

        $guide_id = (int) $_GET['guide_id'];

        // Lấy thông tin HDV
        $stmt = $this->db->prepare("SELECT * FROM guides WHERE id = :id");
        $stmt->bindParam(':id', $guide_id);
        $stmt->execute();
        $guide = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$guide) {
            header("Location: index.php?action=guide_work_select");
            exit;
        }

        // Lấy danh sách tour được phân công
        $sql = "SELECT t.id, t.ten_tour, t.ngay_bat_dau, t.ngay_ket_thuc, t.dia_diem_khoi_hanh
                FROM tours t
                JOIN tour_assignments ta ON ta.tour_id = t.id
                WHERE ta.guide_id = :guide_id
                ORDER BY t.ngay_bat_dau";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':guide_id', $guide_id);
        $stmt->execute();
        $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require 'views/guide_work/tours.php';
    }

    // B3: Xem chi tiết lịch trình tour + nhiệm vụ HDV
    public function tourDetail()
    {
        if (!isset($_GET['tour_id']) || !isset($_GET['guide_id'])) {
            header("Location: index.php?action=guide_work_select");
            exit;
        }

        $tour_id  = (int) $_GET['tour_id'];
        $guide_id = (int) $_GET['guide_id'];

        // Lấy thông tin tour
        $stmt = $this->db->prepare("SELECT * FROM tours WHERE id = :id");
        $stmt->bindParam(':id', $tour_id);
        $stmt->execute();
        $tour = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$tour) {
            header("Location: index.php?action=guide_work_select");
            exit;
        }

        // Lấy thông tin HDV (để hiển thị header)
        $stmt = $this->db->prepare("SELECT * FROM guides WHERE id = :id");
        $stmt->bindParam(':id', $guide_id);
        $stmt->execute();
        $guide = $stmt->fetch(PDO::FETCH_ASSOC);

        // Lấy lịch trình từng ngày + nhiệm vụ HDV
        // Đổi tên cột cho đúng với bảng tour_schedule của bạn
        $sql = "SELECT day_number, ngay, dia_diem, hoat_dong, nhiem_vu_hdv
                FROM tour_schedule
                WHERE tour_id = :tour_id
                ORDER BY day_number ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':tour_id', $tour_id);
        $stmt->execute();
        $schedule = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require 'views/guide_work/tour_detail.php';
    }
}
