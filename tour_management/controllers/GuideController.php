<?php
class GuideController {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    /* ============================
       DANH SÁCH HƯỚNG DẪN VIÊN
    ============================ */
    public function index(){
        require_once "models/Guide.php";
        $model = new Guide($this->conn);
        $guides = $model->getAll();
        include "views/guides/index.php";
    }

    /* ============================
        TẠO HDV
    ============================ */
    public function create() {
        include "views/guides/create.php";
    }

    public function store() {
        require_once "models/Guide.php";
        $model = new Guide($this->conn);

        $model->store([
            'ho_ten'        => $_POST['ho_ten'],
            'ngay_sinh'     => $_POST['ngay_sinh'],
            'gioi_tinh'     => $_POST['gioi_tinh'],
            'dien_thoai'    => $_POST['dien_thoai'],
            'email'         => $_POST['email'],
            'dia_chi'       => $_POST['dia_chi'],
            'trinh_do'      => $_POST['trinh_do'],
            'chung_chi'     => $_POST['chung_chi'],
            'ngon_ngu'      => $_POST['ngon_ngu'],
            'loai_hdv'      => $_POST['loai_hdv'],
            'chuyen_tuyen'  => $_POST['chuyen_tuyen'],
            'suc_khoe'      => $_POST['suc_khoe'],
            'trang_thai'    => $_POST['trang_thai'],
            'ghi_chu'       => $_POST['ghi_chu'] ?? null
        ]);

        header("Location: index.php?action=guide_index");
        exit;
    }

    /* ============================
        SỬA HDV
    ============================ */
    public function edit($id) {
        require_once "models/Guide.php";
        $model = new Guide($this->conn);
        $guide = $model->getById($id);
        if (!$guide) die("Không tìm thấy HDV");

        include "views/guides/edit.php";
    }

    public function update() {
        require_once "models/Guide.php";
        $model = new Guide($this->conn);

        $id = intval($_POST['id']);

        $model->update($id, [
            'ho_ten'        => $_POST['ho_ten'],
            'ngay_sinh'     => $_POST['ngay_sinh'],
            'gioi_tinh'     => $_POST['gioi_tinh'],
            'dien_thoai'    => $_POST['dien_thoai'],
            'email'         => $_POST['email'],
            'dia_chi'       => $_POST['dia_chi'],
            'trinh_do'      => $_POST['trinh_do'],
            'chung_chi'     => $_POST['chung_chi'],
            'ngon_ngu'      => $_POST['ngon_ngu'],
            'loai_hdv'      => $_POST['loai_hdv'],
            'chuyen_tuyen'  => $_POST['chuyen_tuyen'],
            'suc_khoe'      => $_POST['suc_khoe'],
            'trang_thai'    => $_POST['trang_thai'],
            'ghi_chu'       => $_POST['ghi_chu'] ?? null
        ]);

        header("Location: index.php?action=guide_index");
        exit;
    }

    /* ============================
        XOÁ HDV
    ============================ */
    public function destroy($id) {
        require_once "models/Guide.php";
        $model = new Guide($this->conn);

        if (!$model->getById($id)) die("Hướng dẫn viên không tồn tại!");

        $model->delete($id);
        header("Location: index.php?action=guide_index");
        exit;
    }

    /* ============================
      LỊCH LÀM VIỆC HDV
    ============================ */
    public function schedule() {

    if (!isset($_GET['guide_id']) && !isset($_GET['id'])) {
        die("Thiếu ID hướng dẫn viên");
    }

    // Ưu tiên guide_id nếu hợp lệ, nếu không dùng id
    $guide_id = (isset($_GET['guide_id']) && intval($_GET['guide_id']) > 0)
        ? intval($_GET['guide_id'])
        : intval($_GET['id']);

    require_once "models/Guide.php";
    require_once "models/Booking.php";

    $guide = (new Guide($this->conn))->getById($guide_id);

    if (!$guide) {
        die("Không tìm thấy hướng dẫn viên");
    }

    $schedule = (new Booking($this->conn))->getBookingsByGuide($guide_id);

    include "views/guides/schedule.php";
}

    /* ============================
      CHI TIẾT TOUR
    ============================ */
    public function tourDetail() {

    if (!isset($_GET['tour_id']) || !isset($_GET['guide_id'])) {
        die("Thiếu tour_id hoặc guide_id");
    }

    $tour_id  = intval($_GET['tour_id']);
    $guide_id = intval($_GET['guide_id']);

    require_once "models/Tour.php";
    require_once "models/Booking.php";
    require_once "models/Guide.php";
    require_once "models/TourCustomer.php";

    // ✅ Lấy thông tin tour
    $tourModel = new Tour($this->conn);
    $tour = $tourModel->getById($tour_id);

    // ✅ Lấy thông tin HDV
    $guideModel = new Guide($this->conn);
    $guide = $guideModel->getById($guide_id);

    // ✅ Lấy booking duy nhất của tour
    $bookingModel = new Booking($this->conn);
    $booking = $bookingModel->getByTourId($tour_id);

    if (!$booking) {
        die("Tour này chưa có booking");
    }

    // ✅ Lấy khách theo booking_id
    $tourCustomerModel = new TourCustomer($this->conn);
    $sql = "SELECT c.*
        FROM tour_customers tc
        JOIN customers c ON tc.customer_id = c.id
        WHERE tc.booking_id = ?";

$stmt = $this->conn->prepare($sql);
$stmt->execute([$booking['id']]);
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include "views/guides/tour_detail.php";
}
    /* ============================
      DANH SÁCH KHÁCH
    ============================ */
public function customers() {

    if (!isset($_GET['tour_id']) || !isset($_GET['guide_id'])) {
        die("Thiếu tour_id hoặc guide_id");
    }

    $tour_id  = intval($_GET['tour_id']);
    $guide_id = intval($_GET['guide_id']);

    require_once "models/Booking.php";
    require_once "models/TourCustomer.php";

    // ✅ Lấy booking duy nhất theo tour
    $bookingModel = new Booking($this->conn);
    $booking = $bookingModel->getByTourId($tour_id);

    if (!$booking || !isset($booking['id'])) {
        die("Tour này chưa có booking");
    }

    // ✅ Lấy khách theo booking_id
    $tourCustomerModel = new TourCustomer($this->conn);
    $customers = $tourCustomerModel
                    ->getGuestsByBookingId($booking['id'])
                    ->fetchAll(PDO::FETCH_ASSOC);

    include "views/guides/customers.php";
}

    /* ============================
      NHẬT KÝ TOUR
    ============================ */
    public function diary() {
    $tour_id  = intval($_GET['tour_id'] ?? 0);
    $guide_id = intval($_GET['guide_id'] ?? 0);

    if (!$tour_id || !$guide_id) {
        die("Thiếu hoặc sai tour_id / guide_id");
    }

    // Lấy thông tin tour
    require_once "models/Tour.php";
    $tourModel = new Tour($this->conn);
    $tour = $tourModel->getById($tour_id);

    // Lấy thông tin hướng dẫn viên
    require_once "models/Guide.php";
    $guideModel = new Guide($this->conn);
    $guide = $guideModel->getById($guide_id);

    // Lấy lịch làm việc từ bảng guide_schedule
    $query = "SELECT * FROM guide_schedule 
              WHERE tour_id = :tour_id AND guide_id = :guide_id";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([
        ':tour_id' => $tour_id,
        ':guide_id' => $guide_id
    ]);
    $diary = $stmt->fetch(PDO::FETCH_ASSOC);

    include "views/guides/diary_list.php";
}

    /* ============================
      THÊM KHÁCH HÀNG
    ============================ */
    public function addCustomerForm() {
    $tour_id = $_GET['tour_id'];
    $guide_id = $_GET['guide_id'];
    $booking_id = $_GET['booking_id']; // ✅ BẮT BUỘC PHẢI CÓ

    include "views/guides/add_customer.php";
}

    /* ============================
      LƯU KHÁCH HÀNG
    ============================ */
    public function addCustomerStore() {
    require_once "models/Customer.php";
    require_once "models/TourCustomer.php";

    $customerModel = new Customer($this->conn);
    $tourCustomerModel = new TourCustomer($this->conn);

    // Lấy dữ liệu từ form
    $data = [
        'ho_ten' => $_POST['ho_ten'],
        'email' => $_POST['email'],
        'dien_thoai' => $_POST['dien_thoai'],
        'cmnd_cccd' => $_POST['cmnd_cccd']
    ];

    // ✅ Tạo khách mới
    $customer_id = $customerModel->createCustomer($data);

    // ✅ Gắn khách vào tour (booking_id)
    $booking_id = $_POST['booking_id'];
    $tourCustomerModel->createGuestEntry($booking_id, $customer_id);

    header("Location: index.php?action=guide_tour_detail&tour_id=".$_POST['tour_id']."&guide_id=".$_POST['guide_id']);
    exit;
}

    /* ============================
      XOÁ KHÁCH KHỎI TOUR
    ============================ */
   public function customerDelete() {

    if (!isset($_GET['tour_id']) || !isset($_GET['customer_id'])) {
        die("Thiếu tour_id hoặc customer_id");
    }

    $tour_id = intval($_GET['tour_id']);
    $guide_id = intval($_GET['guide_id']);
    $customer_id = intval($_GET['customer_id']);

    require_once "models/Booking.php";
    $bookingModel = new Booking($this->conn);

    // XÓA BOOKING
    $bookingModel->deleteCustomerFromTour($tour_id, $customer_id);

    header("Location: index.php?action=guide_customers&tour_id=$tour_id&guide_id=$guide_id");
    exit;
}
public function deleteCustomer() {
    require_once "models/Customer.php";
    require_once "models/TourCustomer.php";

    $customerModel = new Customer($this->conn);
    $tourCustomerModel = new TourCustomer($this->conn);

    $customer_id = $_GET['customer_id'];

    // Xóa trong tour_customers trước
    $tourCustomerModel->deleteByCustomer($customer_id);

    // Xóa trong customers
    $customerModel->deleteCustomer($customer_id);

    header("Location: index.php?action=guide_tour_detail&tour_id=".$_GET['tour_id']."&guide_id=".$_GET['guide_id']);
    exit;
}

}
?>
