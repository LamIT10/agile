<?php
class LoginController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->loadModel("UserModel");
        $this->user = new UserModel();
    }
    public function index()
    {
        $title = "Login";
        $layoutPath = "login_layout";
        $this->renderView($layoutPath, "", ["title" => $title]);
    }
    public function checkLogin()
    {
        try {
            $data = $_POST;
            $_SESSION['data']['email'] = $data['email'];
            if ($data['email'] == "") {
                throw new Exception("Vui lòng nhập email");
            }
            $email = $this->user->select("*", "email = :email", ["email" => $data['email']]);
            if (empty($email)) {
                throw new Exception("Email không tồn tại");
            }
            if ($data['password'] == "") {
                throw new Exception("Vui lòng nhập mật khẩu");
            }
            $user = $this->user->select("*", "email = :email AND password = :password", ["email" => $data['email'], "password" => $data['password']]);
            if (empty($user)) {
                throw new Exception("Sai mật khẩu");
            } else if ($user[0]['status'] == 0) {
                throw new Exception("Tài khoản đang bị khoá");
            }
            $_SESSION['success'] = true;
            $_SESSION['message'] = "Đăng nhập thành công";
            $_SESSION['user'] = $user[0];
            $_SESSION['cart'] = [];
            header("Location:index.php");
            exit();
        } catch (\Throwable $th) {
            header("Location:?controller=login");
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            exit();
        }
    }
    public function forgotPass()
    {
        $title = "Quên mật khẩu";
        $layoutPath = "forgot_layout";
        $this->renderView($layoutPath, "", ["title" => $title]);
    }
    public function renderFormOtp()
    {
        if (!isset($_SESSION['otp'])) {
            header("Location: ?controller=login&action=forgotPass");
            die;
        } else {
            $title = "Đặt lại mật khẩu";
            $layoutPath = "checkotp_layout";
            $this->renderView($layoutPath, "", ["title" => $title]);
        }
    }
    public function checkOtp()
    {
        try {
            if (!isset($_SESSION['otp'])) {
                header("Location: ?controller=login&action=forgotPass");
                exit();
            }
            if (isset($_POST['btn-to-otp'])) {
                $otp = $_POST['otp'];
                if ($otp == "") {
                    throw new Exception("Vui lòng nhập OTP");
                } else if ($otp != $_SESSION['otp']) {
                    throw new Exception("Mã OTP không chính xác");
                } else {
                    $_SESSION['success'] = true;
                    $_SESSION['message'] = "Mã OTP chính xác, bạn đã có thể đặt lại mật khẩu";
                    header("Location: ?controller=login&action=renderFormPass");
                }
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("Location: ?controller=login&action=renderFormOtp");
        }
    }
    public function renderFormPass()
    {
        $title = "Đặt lại mật khẩu";
        $layoutPath = "resetpass_layout";
        $this->renderView($layoutPath, "", ["title" => $title]);
    }
    public function resetPass()
    {
        try {
            $email = $_SESSION['email'];
            $data = $_POST;
            if ($data['newPassword'] == "") {
                throw new Exception("Vui lòng nhập mật khẩu mới");
            } else if ($data['confirmPassword'] == "") {
                throw new Exception("Vui lòng xác nhận lại mật khẩu mới");
            } else if ($data['newPassword'] != $data['confirmPassword']) {
                throw new Exception("Mật khẩu được xác nhận không khớp");
            }
            $updatePass = $this->user->update(["password" => $data['newPassword']], "email = :email", ["email" => $email]);
            if ($updatePass > 0) {
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Mật khẩu được đặt lại thành công";
                unset($_SESSION['otp']);
                unset($_SESSION['email']);
                header("Location: ?controller=login");
                exit();
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("Location: ?controller=login&action=renderFormPass");
            exit();
        }
    }
}
