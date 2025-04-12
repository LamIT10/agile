<?php
session_start();

require 'bootstrap.php';

$role = $_GET['role'] ?? 'client';

if ($role == 'admin') {
    if (!isset($_SESSION['user'])) {
        $_SESSION['success'] = false;
        $_SESSION['message'] = 'Bạn chưa đăng nhập';
        header("Location: index.php");
    } else {
        if ($_SESSION['user']['role_id'] ==  3) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = 'Bạn không có quyền truy cập';
            header("Location: ./");
        }
    }
}

$controllerCheckAuth = $_GET['controller'] ?? 'home';

if ($role == 'admin') {
    divideAdmin($controllerCheckAuth);
}

authLogin($controllerCheckAuth);


$controllerName = ucfirst(strtolower($controllerCheckAuth)) . "Controller";

$controllerPath = "controllers/$role/$controllerName.php";

$action = $_GET['action'] ?? 'index';

if (file_exists("$controllerPath")) {
    require "$controllerPath";
    $controllerObject = new $controllerName();
    if (method_exists($controllerObject, $action)) {
        $controllerObject->$action();
    } else {
        $controllerObject->index();
    }
}
