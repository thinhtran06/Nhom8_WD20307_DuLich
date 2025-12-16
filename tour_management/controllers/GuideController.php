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
    if (!isset($_GET['id'])) die("Thiếu ID hướng dẫn viên");

    $guide_id = intval($_GET['id']);

    require_once "models/Guide.php";
    require_once "models/GuideWork.php"; // ✅ dùng đúng model

    $guide = (new Guide($this->conn))->getById($guide_id);
    $schedule = (new GuideWork($this->conn))->getToursByGuide($guide_id); // ✅ gọi đúng hàm

    include "views/guides/schedule.php";
}

    /* ============================
      CHI TIẾT TOUR
    ============================ */
    public function tourDetail() {

        if (!isset($_GET['tour_id']) || !isset($_GET['guide_id']))
            die("Thiếu tour_id hoặc guide_id");

        $tour_id  = intval($_GET['tour_id']);
        $guide_id = intval($_GET['guide_id']);

        require_once "models/Tour.php";
        require_once "models/Booking.php";
        require_once "models/Guide.php";

        $tour = (new Tour($this->conn))->getById($tour_id);
        $guide = (new Guide($this->conn))->getById($guide_id);
        $customers = (new Booking($this->conn))->getCustomersByTour($tour_id);

        include "views/guides/tour_detail.php";
    }

    /* ============================
      DANH SÁCH KHÁCH
    ============================ */
    public function customers() {

    if (!isset($_GET['tour_id'])) die("Thiếu tour_id");
    if (!isset($_GET['guide_id'])) die("Thiếu guide_id");

    $tour_id = intval($_GET['tour_id']);
    $guide_id = intval($_GET['guide_id']);

    require_once "models/Booking.php";
    require_once "models/Tour.php";

    // Lấy danh sách khách
    $customers = (new Booking($this->conn))->getCustomersByTour($tour_id);

    // Lấy thông tin tour
    $tour = (new Tour($this->conn))->getById($tour_id);

    // Truyền biến sang view
    include "views/guides/customers.php";
}


    /* ============================
      NHẬT KÝ TOUR
    ============================ */
    public function diary() {

        $tour_id = intval($_GET['tour_id'] ?? 0);
        $guide_id = intval($_GET['guide_id'] ?? 0);

        require_once "models/Tour.php";
        require_once "models/Guide.php";
        require_once "models/GuideDiary.php";

        $tour = (new Tour($this->conn))->getById($tour_id);
        $guide = (new Guide($this->conn))->getById($guide_id);
        $entries = (new GuideDiary($this->conn))->getByTour($tour_id);

        include "views/guides/diary_list.php";
    }

    /* ============================
      SPECIAL REQUEST
    ============================ */
    public function specialRequest() {

    require_once "models/Booking.php";
    require_once "models/CustomerSpecialRequest.php";

    $tour_id  = $_GET['tour_id'];
    $guide_id = $_GET['guide_id'];

    $customers = (new Booking($this->conn))->getCustomersByTour($tour_id);
    $requests  = (new CustomerSpecialRequest($this->conn))->getByTour($tour_id);

    // TRUYỀN BIẾN SANG VIEW
    $data = [
        'tour_id'   => $tour_id,
        'guide_id'  => $guide_id,
        'customers' => $customers,
        'requests'  => $requests
    ];

    extract($data); // Giúp view nhận đúng biến
    include "views/guides/special_request.php";
}



    public function saveSpecialRequest() {

        require_once "models/CustomerSpecialRequest.php";

        foreach ($_POST['yeu_cau'] as $customer_id => $yc) {
            (new CustomerSpecialRequest($this->conn))->upsert(
                $_POST['tour_id'],
                $customer_id,
                $_POST['guide_id'],
                $yc,
                $_POST['ghi_chu'][$customer_id] ?? ''
            );
        }

        header("Location: index.php?action=guide_special_request&tour_id={$_POST['tour_id']}&guide_id={$_POST['guide_id']}&saved=1");
        exit;
    }

    /* ============================
       CHECK-IN
    ============================ */
    public function checkin() {

        if (!isset($_GET['tour_id']) || !isset($_GET['guide_id']))
            die("Thiếu tour_id hoặc guide_id");

        $tour_id  = intval($_GET['tour_id']);
        $guide_id = intval($_GET['guide_id']);
        $diem_tap_trung = $_GET['diem'] ?? '';

        require_once "models/Booking.php";
        require_once "models/CustomerCheckin.php";
        require_once "models/Tour.php";

        $customers = (new Booking($this->conn))->getCustomersByTour($tour_id);
        $checkModel = new CustomerCheckin($this->conn);

        $statusMap = $checkModel->getLatestStatusesByTourAndPoint(
            $tour_id,
            $diem_tap_trung !== '' ? $diem_tap_trung : null
        );

        $history = $checkModel->getHistoryByTour($tour_id);
        $tour = (new Tour($this->conn))->getById($tour_id);

        include "views/guides/checkin.php";
    }

    public function saveCheckin() {

        require_once "models/CustomerCheckin.php";

        foreach ($_POST['trang_thai'] as $cid => $status) {
            (new CustomerCheckin($this->conn))->upsert(
                $_POST['tour_id'],
                $cid,
                $_POST['guide_id'],
                $_POST['diem_tap_trung'],
                $status
            );
        }

        header(
            "Location: index.php?action=guide_checkin".
            "&tour_id={$_POST['tour_id']}".
            "&guide_id={$_POST['guide_id']}".
            "&diem={$_POST['diem_tap_trung']}"
        );
        exit;
    }

    /* ============================
      CẬP NHẬT KHÁCH HÀNG
    ============================ */
     public function customerUpdate() {

        require_once "models/Customer.php";

        $customerModel = new Customer($this->conn);

        $customerModel->update($_POST['customer_id'], [
            'ho_ten' => $_POST['ho_ten'],
            'email' => $_POST['email'],
            'dien_thoai' => $_POST['dien_thoai'],
            'gioi_tinh' => $_POST['gioi_tinh'],
            'quoc_tich' => $_POST['quoc_tich'],
            'ghi_chu' => $_POST['ghi_chu']
        ]);

        header("Location: index.php?action=guide_customers&tour_id={$_POST['tour_id']}&guide_id={$_POST['guide_id']}");
        exit;
    }

    /* ============================
      LƯU KHÁCH HÀNG
    ============================ */
    public function customerStore() {

        require_once "models/Booking.php";

        if (empty($_POST['tour_id']) || empty($_POST['ho_ten'])) {
            die("Thiếu dữ liệu cần thiết");
        }

        $bookingModel = new Booking($this->conn);

        $success = $bookingModel->addCustomer([
            'tour_id'    => $_POST['tour_id'],
            'ho_ten'     => $_POST['ho_ten'],
            'email'      => $_POST['email'],
            'dien_thoai' => $_POST['dien_thoai'],
            'gioi_tinh'  => $_POST['gioi_tinh'],
            'quoc_tich'  => $_POST['quoc_tich'],
            'ghi_chu'    => $_POST['ghi_chu']
        ]);

        if ($success) {
            header(
                "Location: index.php?action=guide_customers".
                "&tour_id={$_POST['tour_id']}".
                "&guide_id={$_POST['guide_id']}"
            );
            exit;
        } else {
            die("Lỗi khi thêm khách hàng!");
        }
    }

    /* ============================
      XOÁ KHÁCH KHỎI TOUR
    ============================ */
   public function customerDelete() {

    if (!isset($_GET['tour_id']) || !isset($_GET['customer_id'])) {
        die("Thiếu tour_id hoặc customer_id");
    }

    $tour_id = intval($_GET['tour_id']);
    $customer_id = intval($_GET['customer_id']);
    $guide_id = intval($_GET['guide_id']);

    require_once "models/Booking.php";
    $bookingModel = new Booking($this->conn);

    
    $bookingModel->removeCustomerFromTour($tour_id, $customer_id);

    header("Location: index.php?action=guide_customers&tour_id=$tour_id&guide_id=$guide_id");
    exit;
}
/* ============================
      Sửa KHÁCH KHỎI TOUR
    ============================ */
public function customerEdit() {
        if (!isset($_GET['customer_id']) || !isset($_GET['tour_id'])) {
            die("Thiếu customer_id hoặc tour_id");
        }

        $customer_id = intval($_GET['customer_id']);
        $tour_id = intval($_GET['tour_id']);
        $guide_id = intval($_GET['guide_id']);

        require_once "models/Customer.php";

        $customerModel = new Customer($this->conn);
        $customer = $customerModel->find($customer_id);

        include "views/guides/customer_edit.php";
    }
    /* ============================
    THÊM KHÁCH HÀNG
============================ */
public function addCustomerForm() {

    if (!isset($_GET['tour_id']) || !isset($_GET['guide_id'])) {
        die("Thiếu tour_id hoặc guide_id");
    }

    $tour_id = intval($_GET['tour_id']);
    $guide_id = intval($_GET['guide_id']);

    include "views/guides/customer_add.php";
}

}

?>
