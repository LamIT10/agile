<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="./site.webmanifest">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="./css/sb-admin-2.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
</head>
<style>
    .dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }

    a {
        text-decoration: none;
        color: black;
    }

    .card {
        border: none;
        border-radius: 0px;
    }

    a:hover {
        text-decoration: none;
    }

    .row {
        display: flex;
        justify-content: space-between;
    }

    .container {
        min-width: 90%;
    }
</style>

</head>

<body style="background-color: 
#F2F5F8
;">
    <header class="border-bottom bg-white">
        <div style="background-color: #3b3a4a;" class=" text-warning py-2 text-center fs-6 fw-semibold">
            <span>ĐỔI HÀNG MIỄN PHÍ - TẠI TẤT CẢ CỬA HÀNG TRONG 30 NGÀY</span>
        </div>
        <div class="container p-3 ">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                    <img src="uploads/logo2.png" alt="Logo" class="" width="100" />
                </a>
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 fw-semibold" style=" font-size: 14px">

                    <?php
                    foreach ($category as $key => $value) {
                        $id = $value['category_id'];
                        if (!$value['parent_id']) {
                    ?>
                            <li class="nav-item dropdown">
                                <a href="?controller=product&action=searchByParent&id=<?= $value['category_id'] ?>" class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button">
                                    <?php
                                    echo mb_strtoupper($value['category_name']);
                                    ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <?php
                                    foreach ($category as $key => $value) {
                                        if ($value['parent_id'] == $id) {
                                    ?>
                                            <li><a href="?controller=product&action=searchByCategory&id=<?= $value['category_id'] ?>" class="dropdown-item fw-semibold" style="font-size: 13px" href="#"><?php echo mb_strtoupper($value['category_name']) ?></a></li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </li>
                    <?php
                        }
                    }
                    ?>
                    <li><a href="?controller=voucher" class="nav-link px-2 link-body-emphasis">KHO VOUCHERS</a></li>
                </ul>
                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" method="post" action="?controller=product&action=searchByName">
                    <div class="input-group">
                        <input
                            name="key"
                            type="search"
                            class="form-control"
                            placeholder="Tìm kiếm"
                            aria-label="Tìm kiếm" />
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                <div class="d-flex align-items-center">
                    <a href="?controller=order" class="text-dark text-decoration-none me-4 d-flex flex-column align-items-center">
                        <i class="bi bi-shop fs-6"></i>
                        <small style="font-size: 13px">Đơn hàng</small>
                    </a>
                    <?php
                    if (isset($_SESSION['user'])) {
                    ?>

                        <div class="dropdown">
                            <div class="me-2 btn btn-light dropdown-toggle">
                                <a href="?controller=account"><img src="uploads/<?= $_SESSION['user']['avatar'] ?>" alt="Avatar" class="rounded-circle" width="40" height="40"></a>
                            </div>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?controller=logout">Đăng xuất</a></li>
                                <?php
                                if (($_SESSION['user']['role_id'] == 1 || $_SESSION['user']['role_id'] == 2) && isset($_SESSION['user'])) {
                                ?>
                                    <li><a class="dropdown-item" href="?role=admin">Truy cập trang quản trị</a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    <?php
                    } else {
                    ?>
                        <button class="btn btn-primary me-4">
                            <a href="?controller=login" class="text-light">
                                <small style="font-size: 13px">Đăng nhập</small>
                            </a>
                        </button>
                    <?php
                    }
                    ?>
                    <a href="?controller=cart" class="text-dark text-decoration-none position-relative d-flex flex-column align-items-center">
                        <i class="bi bi-bag fs-6"></i>
                        <small style="font-size: 13px">Giỏ hàng</small>
                    </a>
                </div>
            </div>
        </div>

    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>