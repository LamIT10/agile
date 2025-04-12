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
    public function sendEmail()
    {
        try {
            $emailTo = $_POST['email'];
            if (empty($emailTo)) {
                throw new Exception("Vui lòng nhập email");
            }
            if (!filter_var($emailTo, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Vui lòng nhập đúng định dạng email");
            }
            $email = $this->user->select("*", "email = :email", ["email" => $emailTo]);
            if (empty($email)) {
                throw new Exception("Email này chưa được đăng kí trong hệ thống");
            }
            $otp = rand(100000, 999999);
            $sendMailSuccess = sendMail(
                $emailTo,
                "Mã OTP để đặt lại mật khẩu của bạn",
                "<html>
    <head>
        <title>Mã OTP Đặt Lại Mật Khẩu</title>
    </head>
    <body>
        <h2>Xin chào,</h2>
        <p>Hệ thống hỗ trợ của ROYAL Shop đã nhận được yêu cầu lấy lại mật khẩu của bạn. Để tiếp tục, vui lòng nhập mã OTP dưới đây:</p>
        <h3 style='color: #4CAF50;'>Mã OTP: $otp</h3>
        <p>Chú ý: <span style='color: red;'>Không chia sẻ mã OTP này cho người khác</span>. Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
        <p>Trân trọng,<br>Đội ngũ hỗ trợ ROYAL</p>
    </body>
    </html>",
                "Hệ thống nhận được yêu cầu lấy lại mật khẩu bạn, mã OTP của bạn à $otp",
                "$otp"
            );
            if ($sendMailSuccess) {
                $_SESSION['success'] = true;
                $_SESSION['message'] = "Mã OTP đã được gửi đến email của bạn, vui lòng kiểm tra email của bạn";
                $_SESSION['otp'] = $otp;
                $_SESSION['email'] = $emailTo;
                header("Location: ?controller=login&action=renderFormOtp");
                exit();
            }
        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = $th->getMessage();
            header("Location: ?controller=login&action=forgotPass");
            exit();
        }
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
