<?php
class GuideDiaryController {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    /* ============================
       DANH SÁCH NHẬT KÝ THEO TOUR + GUIDE
    ============================ */
    public function index(){

        if (!isset($_GET['tour_id'], $_GET['guide_id'])) {
            die("Thiếu tour_id hoặc guide_id");
        }

        $tour_id  = (int)$_GET['tour_id'];
        $guide_id = (int)$_GET['guide_id'];

        require_once "models/Tour.php";
        require_once "models/Guide.php";
        require_once "models/GuideDiary.php";

        // Tour
        $tourModel = new Tour($this->conn);
        $tourModel->id = $tour_id;
        $tour = $tourModel->getById();

        // Guide
        $guideModel = new Guide($this->conn);
        $guide = $guideModel->getById($guide_id);

        // Diary
        $diaryModel = new GuideDiary($this->conn);
        $diaries = $diaryModel->getByTourAndGuide($tour_id, $guide_id);

        include "views/guides/diary_list.php";
    }

    /* ============================
       FORM THÊM NHẬT KÝ
    ============================ */
    public function add(){

        if (!isset($_GET['tour_id'], $_GET['guide_id'])) {
            die("Thiếu tour_id hoặc guide_id");
        }

        $tour_id  = (int)$_GET['tour_id'];
        $guide_id = (int)$_GET['guide_id'];

        $entry = null; // QUAN TRỌNG: thống nhất với form

        include "views/guides/diary_form.php";
    }

    /* ============================
       FORM SỬA NHẬT KÝ
    ============================ */
    public function edit(){

        if (!isset($_GET['id'])) {
            die("Thiếu id nhật ký");
        }

        require_once "models/GuideDiary.php";

        $model = new GuideDiary($this->conn);
        $entry = $model->getById((int)$_GET['id']);

        if (!$entry) {
            die("Nhật ký không tồn tại");
        }

        $tour_id  = $entry['tour_id'];
        $guide_id = $entry['guide_id'];

        include "views/guides/diary_form.php";
    }

    /* ============================
       LƯU NHẬT KÝ (CREATE + UPDATE)
    ============================ */
    public function save(){

        require_once "models/GuideDiary.php";

        $data = [
            "id"             => $_POST["id"] ?? null,
            "tour_id"        => (int)$_POST["tour_id"],
            "guide_id"       => (int)$_POST["guide_id"],
            "ngay"           => $_POST["ngay"],
            "tieu_de"        => $_POST["tieu_de"],
            "noi_dung"       => $_POST["noi_dung"] ?? "",
            "phan_hoi_khach" => $_POST["phan_hoi_khach"] ?? null,
            "su_co"          => $_POST["su_co"] ?? null,
            "cach_xu_ly"     => $_POST["cach_xu_ly"] ?? null,
            "hinh_anh"       => null
        ];

        /* ===== Upload ảnh ===== */
        $uploaded = [];

        if (!empty($_FILES['hinh_anh']['name'][0])) {
            foreach ($_FILES['hinh_anh']['tmp_name'] as $i => $tmp) {
                if ($tmp) {
                    $filename = time() . "_" . basename($_FILES['hinh_anh']['name'][$i]);
                    move_uploaded_file($tmp, "uploads/diary/" . $filename);
                    $uploaded[] = $filename;
                }
            }
        }

        $model = new GuideDiary($this->conn);

        // Giữ ảnh cũ khi update
        if (!empty($data["id"])) {
            $old = $model->getById($data["id"]);
            if (!empty($old['hinh_anh'])) {
                $uploaded = array_merge(
                    explode(",", $old['hinh_anh']),
                    $uploaded
                );
            }
        }

        $data["hinh_anh"] = implode(",", $uploaded);

        if (!empty($data["id"])) {
            $model->update($data["id"], $data);
        } else {
            $model->create($data);
        }

        header(
            "Location: index.php?action=guide_diary&tour_id={$data['tour_id']}&guide_id={$data['guide_id']}"
        );
        exit;
    }

    /* ============================
       XOÁ NHẬT KÝ
    ============================ */
    public function delete(){

        if (!isset($_GET['id'], $_GET['tour_id'], $_GET['guide_id'])) {
            die("Thiếu tham số");
        }

        require_once "models/GuideDiary.php";

        $id       = (int)$_GET['id'];
        $tour_id  = (int)$_GET['tour_id'];
        $guide_id = (int)$_GET['guide_id'];

        $model = new GuideDiary($this->conn);

        if (!$model->getById($id)) {
            die("Nhật ký không tồn tại");
        }

        $model->delete($id);

        header("Location: index.php?action=guide_diary&tour_id=$tour_id&guide_id=$guide_id");
        exit;
    }
}
