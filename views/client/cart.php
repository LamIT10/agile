<?php
$total = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['check'] == 'on') {
        $_SESSION['cart']["$_POST[detail_id]"] = $_POST['detail_id'];
    } else {
        unset($_SESSION['cart']["$_POST[detail_id]"]);
    }
}
$count = count($_SESSION['cart']) > 1 ? '(' . count($_SESSION['cart']) . ')' : '';
?>
<style>
    input:disabled {
        cursor: not-allowed;
    }
</style>
<div class="container my-2">
    <h4 class="bg-white py-3 px-4">Giỏ hàng</h4>

    <div class="row">
        <!-- Cột thông tin giỏ hàng -->
        <div class="col-8 cart ">
            <?php
            if (!empty($cart)) {
                foreach ($cart as $key => $value) : ?>
                    <div>
                        <!-- Sản phẩm trong giỏ -->
                        <div class="card mb-2 py-3">

                            <div class="row g-0">
                                <form action="" method="post" class="col-md-1 d-flex align-items-center">
                                    <input type="hidden" name="detail_id" value="<?= $value['detail_id'] ?>">
                                    <input type="hidden" name="check" value="off">
                                    <input <?php if (in_array($value['detail_id'], $_SESSION['cart'])) echo "checked" ?> onchange="this.form.submit()" type="checkbox" name="check" class="form-check-input ms-2">
                                </form>
                                <div class="col-md-2">
                                    <img src="uploads/<?= $value['image_main'] ?>" class="img-fluid border" alt="Sản phẩm">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body h-100 d-flex flex-column justify-content-between">
                                        <div>
                                            <h5 class="card-title fs-6"><?= $value['product_name'] ?></h5>
                                            <p class="text-danger fs-6 mb-0"><b><?= number_format($value['sale_price']) ?> VNĐ </b><del class="text-secondary"><?= number_format($value['base_price']) ?> VNĐ</del></p>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-light text-dark"><span class="bi bi-circle-fill mr-1" style="color:<?= $value['color_code'] ?>"></span><?= $value['color_name'] ?> | <?= $value['size_name'] ?></span>
                                            <div class="ms-auto">
                                                <form action="?controller=cart&action=changeQuantity&id=<?= $value['detail_id'] ?>" method="post" class="d-flex mt-3">
                                                    <div class="d-flex align-items-center">
                                                        <button type="button" class="btn btn-outline-success" onclick="updateQuantity(-1)">-</button>
                                                        <input type="hidden" name="variant_id" value="<?= $value['variant_id'] ?>">
                                                        <input style="width: 50px;" type="text" id="quantity" name="quantity_cart" class="form-control mx-2 text-center" value="<?= $value['quantity_cart'] ?>">
                                                        <button type="button" class="btn btn-outline-success" onclick="updateQuantity(1)">+</button>
                                                    </div>
                                                    <button id="btn-edit" class="btn btn-outline-primary btn-sm ms-3">
                                                        <i class="fa fa-pencil-alt"></i></button>

                                                </form>

                                            </div>
                                            <a href="?controller=cart&action=delete&id=<?= $value['detail_id'] ?>" class="btn btn-outline-danger btn-sm ms-3"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    if (in_array($value['detail_id'], $_SESSION['cart'])) {
                        $total += $value['sale_price'] * $value['quantity_cart'];
                    }
                endforeach;
            } else {
                ?>
                <div class="text-center px-5 py-4 fs-5" style="background-color: white;">Giỏ hàng của bạn đang trống</div>
            <?php
            }
            ?>
        </div>

        <!-- Cột chi tiết đơn hàng -->
        <div class="col-md-4">
            <?php
            if (!empty($_SESSION['cart'])) {
            ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chi tiết đơn hàng</h5>
                        <ul class="list-unstyled">
                            <li class="d-flex justify-content-between">
                                <span>Tổng giá trị sản phẩm:</span>
                                <strong><?= number_format($total) . " VNĐ" ?></strong>
                            </li>
                            <li class="d-flex justify-content-between mt-2">
                                <span>Vận chuyển:</span>
                                <strong>20.000 VNĐ</strong>
                            </li>
                            <?php
                            if ($total > 500000) {
                            ?>
                                <li class="d-flex justify-content-between text-success mt-2">
                                    <span>Giảm giá vận chuyển:</span>
                                    <strong>-20.000 VNĐ</strong>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                        <hr>
                        <div class="d-flex justify-content-between fs-5">
                            <strong>Tổng thanh toán:</strong>
                            <strong>
                                <?php
                                if ($total < 500000) {
                                    $totalFinal = $total + 20000;
                                    echo number_format($totalFinal) . " VNĐ";
                                } else {
                                    echo number_format($total) . " VNĐ";
                                }
                                ?>
                            </strong>
                        </div>
                        <button class="btn btn-warning w-100 mt-3"><a href="?controller=checkout">Mua hàng <?= $count ?></a></button>
                        <p class="mt-3 text-center">
                            <a href="#" class="text-primary">Chọn Voucher giảm giá ở bước tiếp theo</a>
                        </p>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="text-center p-3" style="background-color: white;">
                    <img class="w-100" src="uploads/cart_empty.png" alt="">
                    <p>Vui lòng chọn sản phẩm </p>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<script>
    function updateQuantity(change) {
        const quantityInput = document.getElementById('quantity');
        let currentQuantity = parseInt(quantityInput.value) || 0;

        currentQuantity += change;

        if (currentQuantity < 1) {
            currentQuantity = 1;
        }
        quantityInput.value = currentQuantity;
    }
</script>