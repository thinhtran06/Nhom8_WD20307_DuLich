<?php
require_once 'config/database.php';
require_once 'models/GuideWork.php';

class GuideWorkController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // ============================================
    // B1: HIỂN THỊ FORM PHÂN CÔNG HDV CHO TOUR
    // ============================================
    public function assignForm()
    {
        if (!isset($_GET['tour_id'])) {
            die("Thiếu tour_id!");
        }

        $tour_id = intval($_GET['tour_id']);

        // Lấy tour
        $stmt = $this->db->prepare("SELECT * FROM tours WHERE id = ?");
        $stmt->execute([$tour_id]);
        $tour = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$tour) die("Tour không tồn tại!");

        // Lấy danh sách HDV đang hoạt động
        $stmt2 = $this->db->prepare("
            SELECT id, ho_ten, chuyen_tuyen 
            FROM guides 
            WHERE trang_thai = 'Đang hoạt động'
        ");
        $stmt2->execute();
        $guides = $stmt2->fetchAll(PDO::FETCH_OBJ);

        require 'views/guide_work/assign_guide.php';
    }

    // ============================================
    // B2: LƯU PHÂN CÔNG
    // ============================================
    public function assignSave()
    {
        if (!isset($_POST['tour_id']) || !isset($_POST['guide_id'])) {
            die("Thiếu dữ liệu phân công!");
        }

        $tour_id  = intval($_POST['tour_id']);
        $guide_id = intval($_POST['guide_id']);

        $gw = new GuideWork($this->db);

        // Kiểm tra tour đã phân công chưa
        if ($gw->exists($tour_id)) {
            die("Tour này đã được phân công HDV trước đó!");
        }

        // Tiến hành lưu
        $gw->assign($guide_id, $tour_id);

        // Điều hướng về lịch làm việc HDV
        header("Location: index.php?action=guide_schedule&id={$guide_id}&msg=assigned");
        exit;
    }

    // ============================================
    // B3: XEM LỊCH LÀM VIỆC CỦA HDV
    // ============================================
    public function schedule()
    {
        if (!isset($_GET['id'])) {
            die("Thiếu ID HDV!");
        }

        $guide_id = intval($_GET['id']);

        // Lấy thông tin HDV
        $stmt = $this->db->prepare("SELECT * FROM guides WHERE id = ?");
        $stmt->execute([$guide_id]);
        $guide = $stmt->fetch(PDO::FETCH_OBJ);
        $msg = $_GET['msg'] ?? null;

        if (!$guide) die("Không tìm thấy HDV!");

        // Lấy danh sách tour được phân công
        $gw = new GuideWork($this->db);
        $schedule = $gw->getAssignedTours($guide_id);

        require "views/guide_work/guide_schedule.php";
    }
}
