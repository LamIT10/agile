<?php
class UserController extends Controller
{
    public $user;
    public $order;
    public function __construct()
    {
        $this->loadModel("UserModel");
        $this->user = new UserModel();
        $this->loadModel("OrderModel");
        $this->order = new OrderModel();
    }
    public function index()
    {
        $param = $_GET['view'] == 'customer' ? '=3' : '!=3';
        $user = $this->user->getAllUser($param);
        $title = "Danh sách khách hàng";
        $content = "admin/user/index";
        $layoutPath = "admin_layout";
        $this->renderView($layoutPath, $content, ["title" => $title, "user" => $user]);
    }
    public function add()
    {
        $title = "Thêm người dùng";
        $content = "admin/user/add";
        $layoutPath = "admin_layout";
        $this->renderView($layoutPath, $content, ["title" => $title]);
    }
    public function store()
    {
        $type = $_GET['type'];
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
            if ($type == 'admin') {
                if (!$dataPost['role_id']) {
                    $_SESSION['error']['role_id'] = "*Chọn 1 quyền quản trị";
                }
            }
            if ($dataPost['email'] == '' || !filter_var($dataPost['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error']['email'] = "*Yêu cầu nhập email và đúng định dạng";
            }
            $emailCheck = $this->user->selectOne("*", "email=:email", ["email" => $dataPost['email']]);
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
                header("location:?role=admin&controller=user&action=add&type=admin");
            }
            if ($dataFile['avatar']['size'] > 0) {
                $dataPost['avatar'] = $imageName;
                move_uploaded_file($dataFile['avatar']['tmp_name'], "uploads/" . $imageName);
            }
            $insertId = $this->user->insert($dataPost);
            if ($insertId > 0) {
                unset($_SESSION['data']);
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Thêm mới thành công!";
                header("location:?role=admin&controller=user&view=$type");
            } else {
                throw new Exception("Thêm mới không thành công");
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("location:?role=admin&controller=user&action=add&type=$type");
            exit();
        }
    }
    public function edit()
    {
        try {
            $type = $_GET['type'];
            $roleId = $type == 'admin' ? "!=3" : "=3";
            if (!$_GET['id']) {
                throw new Exception("URL thiếu tham số ID", 10);
            }
            $id = $_GET['id'];
            $user = $this->user->select("*", "user_id=:user_id and role_id $roleId", ["user_id" => $id]);
            if (empty($user)) {
                throw new Exception("Không tìm thấy user có vai trò $type và ID = $id");
            }
            $title = "Cập nhật người dùng";
            $user = $this->user->selectOne("*", "user_id=:user_id", ["user_id" => $id]);
            $content = "admin/user/edit";
            $layoutPath = "admin_layout";
            $this->renderView($layoutPath, $content, ["title" => $title, "user" => $user]);
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("location:?role=admin&controller=user&view=$type");
        }
    }
    public function update()
    {
        try {
            $type = $_GET['type'];
            $roleId = $type == 'admin' ? "!=3" : "=3";
            if ($_SERVER['REQUEST_METHOD'] != "POST") {
                throw new Exception("Yêu cầu phương thức là POST", 9);
            }
            if (!$_GET['id']) {
                throw new Exception("URL thiếu tham số ID", 10);
            }
            $id = $_GET['id'];
            $user = $this->user->select("*", "user_id=:user_id and role_id $roleId", ["user_id" => $id]);
            if (empty($user)) {
                throw new Exception("Không tìm thấy user có vai trò $type và ID = $id", 11);
            }
            $dataPost = $_POST;
            $dataFile = $_FILES;
            $_SESSION['data'] = $dataPost;
            $imageName = $dataFile['avatar']['name'];
            $_SESSION['error'] = [];
            if ($dataPost['username'] == '' || strlen($dataPost['username']) > 20) {
                $_SESSION['error']['username'] = "*Username không để trống và không quá 20 kí tự";
            }
            if ($dataPost['password']) {
                if ($dataPost['password'] == '' || strlen($dataPost['password']) > 20 || strlen($dataPost['password']) < 6) {
                    $_SESSION['error']['password'] = "*Mật khẩu không để trống và phải có từ 6 -> 20 kí tự";
                }
            }
            if (!$dataPost['role_id']) {
                $_SESSION['error']['role_id'] = "*Chọn 1 quyền quản trị";
            }
            if ($dataPost['email'] == '' || !filter_var($dataPost['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error']['email'] = "*Yêu cầu nhập email và đúng định dạng";
                throw new Exception("Yêu cầu nhập email và đúng định dạng");
            }
            $emailCheck = $this->user->selectOne("*", "email=:email and user_id != :user_id", ["email" => $dataPost['email'], "user_id" => $id]);
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
                header("location:?role=admin&controller=user&action=add&type=admin");
            }
            if ($dataFile['avatar']['size'] > 0) {
                $dataPost['avatar'] = $imageName;
                move_uploaded_file($dataFile['avatar']['tmp_name'], "uploads/" . $imageName);
            }
            $rowCount = $this->user->update($dataPost, "user_id = :user_id", ["user_id" => $id]);
            if ($rowCount > 0) {
                unset($_SESSION['data']);
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Cập nhật thành công!";
                header("location:?role=admin&controller=user&view=$type");
            } else {
                throw new Exception("Cập nhật không thành công");
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            if ($th->getCode() == 10 || $th->getCode() == 11 || $th->getCode() == 9) {
                header("location:?role=admin&controller=user&view=$type");
                exit();
            }
            header("location:?role=admin&controller=user&action=edit&type=$type&id=$id");
            exit();
        }
    }
    public function changeStatus()
    {
        try {
            $type = $_GET['type'];
            $status = $_GET['status'];
            if (!$_GET['id']) {
                throw new Exception("URL thiếu tham số ID", 10);
            }
            $id = $_GET['id'];
            $isHaveOrder = $this->order->checkUseHaveOrder($id);
            if ($status == 1) {
                if (!empty($isHaveOrder)) {
                    throw new Exception("Người dùng này đang có sản phẩm đang xử lý");
                }
            }
            $rowCount = $this->user->changeStatus($status, "user_id = :user_id", ["user_id" => $id]);
            if ($rowCount > 0) {
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Thay đổi trạng thái thành công";
                header("location:?role=admin&controller=user&view=$type");
            } else {
                throw new Exception("Thay đổi trạng thái không thành công");
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("location:?role=admin&controller=user&view=$type");
        }
    }
    public function show()
    {
        $title = "Chi tiết người dùng";
        $id = $_GET['id'];
        $user = $this->user->selectOne("*", "user_id=:user_id", ["user_id" => $id]);
        $content = "admin/user/show";
        $layoutPath = "admin_layout";
        $this->renderView($layoutPath, $content, ["title" => $title, 'user' => $user]);
    }
}
