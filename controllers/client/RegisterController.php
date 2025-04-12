<?php
class RegisterController extends Controller
{
    public $account;
    public function __construct()
    {
        $this->loadModel('UserModel');
        $this->account = new UserModel();
    }
    public function index()
    {
        $title = "Đăng ký";
        $content = "";
        $layoutPath = "register_layout";
        $this->renderView($layoutPath, $content, ['title' => $title]);
    }
    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] != "POST") {
                throw new Exception("Yêu cầu phương thức là POST");
            }
            $dataPost = $_POST;
            $dataFile = $_FILES;
            $_SESSION['data'] = $dataPost;
            $imageName = $dataFile['avatar']['name'];
            $_SESSION['error'] = [];
            if ($dataPost['username'] == '' || strlen($dataPost['username']) > 20) {
                $_SESSION['error']['username'] = "*Username không để trống và không quá 20 kí tự";
            }
            if ($dataPost['password'] == '' || strlen($dataPost['password']) > 20 || strlen($dataPost['password']) < 6) {
                $_SESSION['error']['password'] = "*Mật khẩu không để trống và phải có từ 6 -> 20 kí tự";
            }
            if ($dataPost['email'] == '' || !filter_var($dataPost['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error']['email'] = "*Yêu cầu nhập email và đúng định dạng";
            }
            $emailCheck = $this->account->selectOne("*", "email=:email", ["email" => $dataPost['email']]);
            if (!empty($emailCheck)) {
                $_SESSION['error']['email'] = "*Email này đã được sử dụng, vui lòng kiểm tra lại";
            }
            if ($dataPost['address'] == '') {
                $_SESSION['error']['address'] = "*Địa chỉ không được trống";
            }
            if ($dataPost['date_of_birth'] == '') {
                $_SESSION['error']['date_of_birth'] = "*Ngày sinh không được để trống";
            }
            if ($dataPost['full_name'] == '' || strlen($dataPost['full_name']) > 30) {
                $_SESSION['error']['full_name'] = "*Họ và tên không được để trống và không quá 30 kí tự";
            }
            if ($dataPost['phone'] == '' || strlen($dataPost['phone']) != 10) {
                $_SESSION['error']['phone'] = "*Số điện thoại không để trống và phải đúng định dạng";
            }
            if ($dataFile['avatar']['size'] > 0) {
                if ($dataFile['avatar']['size'] > 2 * 1024 * 1024) {
                    $_SESSION['error']['avatar'] = "Dung lượng hình ảnh phải nhỏ hơn 2MB";
                }
                $allowType = array("image/jpeg", "image/png", "image/gif", "image/jpg", "image/webp");
                $typeFile = $dataFile['avatar']['type'];
                if (!in_array($typeFile, $allowType)) {
                    $_SESSION['error']['avatar'] = "Định dạng hình ảnh không phù hợp, cho phép jpeg, png, gif, jpg, webp";
                }
            }
            if (!empty($_SESSION['error'])) {
                throw new Exception("Dữ liệu lỗi!");
                header("location:?controller=register");
            }
            if ($dataFile['avatar']['size'] > 0) {
                $dataPost['avatar'] = $imageName;
                move_uploaded_file($dataFile['avatar']['tmp_name'], "uploads/" . $imageName);
            }
            $insertId = $this->account->insert($dataPost);
            if ($insertId > 0) {
                unset($_SESSION['data']);
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Đăng kí thành công!";
                $_SESSION['user'] = $this->account->selectOne("*", "user_id=:id", ["id" => $insertId]);
                header("location:index.php");
            } else {
                throw new Exception("Đăng kí không thành công");
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("location:?controller=register");
            exit();
        }
    }
}
