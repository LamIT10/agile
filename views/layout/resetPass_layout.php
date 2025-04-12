<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        /* Custom CSS */
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url(uploads/bg-login2.jpg);
            background-size: cover;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
            background-color: rgb(255, 255, 255, 0.5);
            border-radius: 5px;
        }

        .login-container h3 {
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-custom {
            background: linear-gradient(to right, black, #555B6B, #504E3C, #C6B3A2);
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background: #555;
        }

        .link-custom {
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }

        .link-custom:hover {
            text-decoration: underline;
        }

        .toas {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            z-index: 1000;
            background-color: #ffffff;
            overflow: hidden;
            animation: slideInOut 7s ease-out forwards;
            border-radius: 0px;
            min-width: 300px;
        }

        @keyframes slideInOut {
            0% {
                opacity: 1;
                transform: translateX(100%);
            }

            5% {
                opacity: 1;
                transform: translateX(0);
            }

            70% {
                opacity: 1;
                transform: translateX(0);
            }

            100% {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        .fa-circle-check,
        .fa-triangle-exclamation {
            margin-right: 15px;
            font-size: 25px;
            border-radius: 4px;
            padding: 5px 7px;
        }

        .fa-circle-check {
            color: green;
            background-color: white;

        }

        .fa-triangle-exclamation {
            color: red;
            background-color: white;
        }

        input {
            padding: 5px;

        }
    </style>
</head>

<body>
    <?= getToast() ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Đặt Lại Mật Khẩu</h4>
                    </div>
                    <div class="card-body">
                        <form action="?controller=login&action=resetPass" method="POST">
                            <!-- Nhập mật khẩu mới -->
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="Nhập mật khẩu mới">
                            </div>

                            <!-- Nhập lại mật khẩu -->
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Nhập lại mật khẩu">
                            </div>

                            <!-- Nút gửi -->
                            <div class="d-grid">
                                <button type="submit" name="btn-reset" class="btn btn-primary">Cập Nhật Mật Khẩu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php
if (!empty($_SESSION['error'])) unset($_SESSION['error']);
?>

</html>