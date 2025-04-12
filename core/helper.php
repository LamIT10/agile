<?php
function renderStar($rating)
{
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
    $emptyStars = 5 - ($fullStars + $halfStar);
    $output = '';
    for ($i = 0; $i < $fullStars; $i++) {
        $output .= ' <i class="bi bi-star-fill text-warning"></i> ';
    }
    if ($halfStar) {
        $output .= ' <i class="bi bi-star-half text-warning"></i> ';
    }
    for ($i = 0; $i < $emptyStars; $i++) {
        $output .= ' <i class="bi bi-star text-warning"></i> ';
    }
    return $output;
}
function authLogin($controller)
{
    $listNeedLogin = [
        'cart',
        'checkout',
        'account',
        'comment',
        'logout',
        'order',
        'voucher',
    ];
    if (in_array($controller, $listNeedLogin)) {
        if (!isset($_SESSION['user'])) {
            $_SESSION['success'] = false;
            $_SESSION['message'] = 'Vui lòng đăng nhập để sử dụng chức năng này';
            header('Location: ?controller=login');
        }
    }
}
function divideAdmin($controller){
    $listOwnerOnly = [
        'banner',
        'user'
    ];
    if (in_array($controller, $listOwnerOnly)) {
        if(isset($_SESSION['user']) && $_SESSION['user']['role_id'] != 1){
            header('Location: ?role=admin');
        }
    }
}

