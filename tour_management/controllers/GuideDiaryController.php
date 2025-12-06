<?php
class GuideDiaryController {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    /* =====================
       DANH SÁCH NHẬT KÝ
    ====================== */
    public function index(){
        if (!isset($_GET['tour_id']) || !isset($_GET['guide_id'])) {
            die("Thiếu tham số tour_id hoặc guide_id");
        }

        $tour_id = intval($_GET['tour_id']);
        $guide_id = intval($_GET['guide_id']);

        require_once "models/Tour.php";
        require_once "models/Guide.php";
        require_once "models/GuideDiary.php";

        $tourModel = new Tour($this->conn);
        $tourModel->id = $tour_id;
        $tour = $tourModel->getById();

        $guideModel = new Guide($this->conn);
        $guide = $guideModel->getById($guide_id);

        $diaryModel = new GuideDiary($this->conn);
        $diaries = $diaryModel->getAllByTour($tour_id, $guide_id);

        include "views/guides/diary_list.php";
    }

    /* =====================
       FORM THÊM NHẬT KÝ
    ====================== */
    public function add(){
        $tour_id = $_GET['tour_id'];
        $guide_id = $_GET['guide_id'];

        $diary = null;

        include "views/guides/diary_form.php";
    }

    /* =====================
       FORM SỬA NHẬT KÝ
    ====================== */
    public function edit(){
        if (!isset($_GET['id'])) die("Thiếu id nhật ký");

        require_once "models/GuideDiary.php";

        $diaryModel = new GuideDiary($this->conn);
        $diary = $diaryModel->getById($_GET['id']);

        $tour_id = $diary['tour_id'];
        $guide_id = $diary['guide_id'];

        include "views/guides/diary_form.php";
    }

    /* =====================
       LƯU NHẬT KÝ (CREATE + UPDATE)
    ====================== */
    public function save(){
        require_once "models/GuideDiary.php";

        $data = [
            "id"        => $_POST["id"] ?? null,
            "tour_id"   => $_POST["tour_id"],
            "guide_id"  => $_POST["guide_id"],
            "ngay"      => $_POST["ngay"],
            "su_kien"   => $_POST["su_kien"],
            "su_co"     => $_POST["su_co"],
            "xu_ly"     => $_POST["xu_ly"],
            "phan_hoi"  => $_POST["phan_hoi"],
            "hinh_anh"  => null
        ];

        /* ===== Upload hình ảnh ===== */
        $uploadedFiles = [];

        if (!empty($_FILES['hinh_anh']['name'][0])) {
            foreach ($_FILES['hinh_anh']['tmp_name'] as $i => $tmp) {
                $filename = time() . "_" . basename($_FILES['hinh_anh']['name'][$i]);
                move_uploaded_file($tmp, "uploads/diary/" . $filename);
                $uploadedFiles[] = $filename;
            }
        }

        // Nếu edit thì giữ lại ảnh cũ
        if (!empty($data["id"])) {
            require_once "models/GuideDiary.php";
            $diaryModel = new GuideDiary($this->conn);
            $old = $diaryModel->getById($data["id"]);

            if (!empty($old['hinh_anh'])) {
                $uploadedFiles = array_merge(explode(",", $old['hinh_anh']), $uploadedFiles);
            }
        }

        $data["hinh_anh"] = implode(",", $uploadedFiles);

        $diaryModel = new GuideDiary($this->conn);

        // Update
        if (!empty($data["id"])) {
            $diaryModel->update($data);
        }
        // Insert
        else {
            $diaryModel->create($data);
        }

        header("Location: index.php?action=guide_diary&tour_id={$data['tour_id']}&guide_id={$data['guide_id']}");
        exit;
    }
}
