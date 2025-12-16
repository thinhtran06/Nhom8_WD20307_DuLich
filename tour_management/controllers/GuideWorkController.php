<?php

require_once 'config/database.php';

class GuideWorkController
{
    private $db;
    private $guideWork;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->guideWork = new GuideWork($this->db);
    }

    // B1: Chọn HDV
    public function selectGuide()
    {
        $sql = "
            SELECT id, ho_ten
            FROM guides
            WHERE trang_thai = 'Đang hoạt động'
            ORDER BY ho_ten
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $guides = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require 'views/guide_work/select_guide.php';
    }

    // B2: Xem danh sách tour của 1 HDV
    public function toursByGuide()
    {
        if (!isset($_GET['guide_id'])) {
            header("Location: index.php?action=guide_work_select");
            exit;
        }

        $guide_id = (int) $_GET['guide_id'];

        // Thông tin HDV
        $stmt = $this->db->prepare("SELECT * FROM guides WHERE id = :id");
        $stmt->execute([':id' => $guide_id]);
        $guide = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$guide) {
            header("Location: index.php?action=guide_work_select");
            exit;
        }

        // Tour được phân công
        $tours = $this->guideWork->getToursByGuide($guide_id);

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
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $guide_id  = $_POST['guide_id'];
            $tour_id   = $_POST['tour_id'];
            $work_date = $_POST['work_date'];

            $this->guideWork->create($guide_id, $tour_id, $work_date);

            header("Location: index.php?action=guide_work_select");
            exit;
        }

        // Load data cho form
        $guides = $this->db->query("SELECT * FROM guides")->fetchAll(PDO::FETCH_ASSOC);
        $tours  = $this->db->query("SELECT * FROM tours")->fetchAll(PDO::FETCH_ASSOC);

        require 'views/guide_work/create.php';
    }
    public function assignFromTour()
{
    if (!isset($_GET['id'])) {
        die("Thiếu tour_id");
    }

    $tour_id = $_GET['id'];

    // Lấy danh sách HDV
    $guides = $this->db->query("SELECT * FROM guides")->fetchAll(PDO::FETCH_ASSOC);

    // Lấy thông tin tour
    $stmt = $this->db->prepare("SELECT * FROM tours WHERE id = :id");
    $stmt->bindParam(':id', $tour_id);
    $stmt->execute();
    $tour = $stmt->fetch(PDO::FETCH_ASSOC);

    require 'views/guide_work/assign_from_tour.php';
}
public function assignForm()
{
    $tour_id = $_GET['tour_id'];

    // Lấy danh sách HDV
    $guides = $this->db->query("SELECT * FROM guides")->fetchAll(PDO::FETCH_ASSOC);

    // Lấy thông tin tour
    $stmt = $this->db->prepare("SELECT * FROM tours WHERE id = :id");
    $stmt->bindParam(':id', $tour_id);
    $stmt->execute();
    $tour = $stmt->fetch(PDO::FETCH_ASSOC);

    require 'views/guide_work/assign_form.php';
}

public function assignSave()
{
    if (!isset($_POST['guide_id']) || empty($_POST['guide_id'])) {
        die("Lỗi: Không nhận được ID hướng dẫn viên");
    }

    $guide_id  = $_POST['guide_id'];
    $tour_id   = $_POST['tour_id'];
    $work_date = $_POST['work_date'];

    // Kiểm tra trùng ngày
    if ($this->guideWork->existsOnDate($tour_id, $work_date)) {
        die("Tour này đã có HDV vào ngày $work_date");
    }

    // Lưu phân công
    $this->guideWork->create($guide_id, $tour_id, $work_date);

    // ✅ Redirect đúng tham số mà schedule() cần
    header("Location: index.php?action=guide_schedule&id=$guide_id");
    exit;
}
}
