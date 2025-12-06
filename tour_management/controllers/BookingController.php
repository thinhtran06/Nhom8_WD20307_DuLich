<?php

require_once "models/Booking.php";
require_once "models/Tour.php";
require_once "models/Customer.php";

class BookingController 
{
    private $conn;
    private $bookingModel;
    private $tourModel;
    private $customerModel;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->bookingModel  = new Booking($this->conn);
        $this->tourModel     = new Tour($this->conn);
        $this->customerModel = new Customer($this->conn);
    }

    // =============================
    // 1. DANH SÁCH BOOKING
    // =============================
    public function index()
    {
        $bookings = $this->bookingModel->getAll();
        require_once "views/bookings/index.php";
    }

    // =============================
    // 2. FORM TẠO BOOKING
    // =============================
    public function create()
    {
        $tours = $this->tourModel->getAll();
        $customers = $this->customerModel->getAll();

        require_once "views/bookings/create.php";
    }

    // =============================
    // 3. LƯU BOOKING
    // =============================
    public function store()
    {
        $tour_id = $_POST["tour_id"];
        $so_nguoi_lon = (int)$_POST["so_nguoi_lon"];
        $so_tre_em    = (int)$_POST["so_tre_em"];

        // Lấy tour
        $tour = $this->tourModel->find($tour_id);
        if (!$tour) die("Tour không tồn tại!");

        $tongNguoi = $so_nguoi_lon + $so_tre_em;

        if ($tour["so_cho"] < $tongNguoi) {
            die("❌ Không đủ số chỗ trống!");
        }

        // =============================
        // 3. TẠO KHÁCH HÀNG TỰ ĐỘNG
        // =============================
        $customerData = [
            "ho_ten"     => $_POST["customer_name"],
            "dien_thoai" => $_POST["dien_thoai"],
            "cmnd_cccd"  => $_POST["cmnd_cccd"],
            "dia_chi"    => $_POST["dia_chi"],
            "ngay_sinh"  => $_POST["ngay_sinh"],
            "gioi_tinh"  => $_POST["gioi_tinh"] ?? null,
            "quoc_tich"  => $_POST["quoc_tich"] ?? null,
            "ghi_chu"    => $_POST["ghi_chu_khach"] ?? ""
        ];

        $customer_id = $this->customerModel->store($customerData);
        if (!$customer_id) die("❌ Lỗi tạo khách hàng!");

        // =============================
        // 4. TÍNH TIỀN
        // =============================
        $tong_tien      = (int)$_POST["tong_tien"];
        $da_thanh_toan  = (int)$_POST["da_thanh_toan"];
        $con_lai        = $tong_tien - $da_thanh_toan;
        if ($con_lai < 0) $con_lai = 0;

        // =============================
        // 5. DỮ LIỆU BOOKING
        // =============================
        $data = [
            "tour_id"       => $tour_id,
            "customer_id"   => $customer_id,
            "user_id"       => $_SESSION["user_id"],
            "loai_khach"    => $_POST["loai_khach"],
            "ma_dat_tour"   => uniqid("BOOK_"),
            "so_nguoi_lon"  => $so_nguoi_lon,
            "so_tre_em"     => $so_tre_em,
            "tong_tien"     => $tong_tien,
            "da_thanh_toan" => $da_thanh_toan,
            "con_lai"       => $con_lai,
            "trang_thai"    => "Chờ xác nhận",
            "ghi_chu"       => $_POST["ghi_chu"]
        ];

        // Lưu Booking
        $this->bookingModel->store($data);

        // Cập nhật chỗ
        $this->tourModel->updateSeats($tour_id, $tongNguoi);

        header("Location: index.php?action=booking_index");
        exit;
    }

    // =============================
    // 4. CẬP NHẬT TRẠNG THÁI
    // =============================
    public function updateStatus($id)
    {
        if ($_SESSION["role"] !== "admin") {
            die("❌ Bạn không có quyền!");
        }

        $this->bookingModel->updateStatus($id, $_POST["status"]);

        header("Location: index.php?action=booking_index");
        exit;
    }

    // =============================
    // 5. XOÁ BOOKING
    // =============================
    public function delete($id)
    {
        if ($_SESSION["role"] !== "admin") {
            die("❌ Bạn không có quyền xoá!");
        }

        $this->bookingModel->destroy($id);

        header("Location: index.php?action=booking_index");
        exit;
    }
}
    