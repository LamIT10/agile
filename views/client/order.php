<style>
    .nav-tabs .nav-link {
        color: #555;
        font-weight: bold;
        border: none;
        min-width: 150px;
    }

    .nav-tabs .nav-link.active {
        color: #ff5a5f;
        border-bottom: 5px solid #ff5a5f;
    }

    .order-item {
        border-bottom: 1px solid #ddd;
        padding: 15px 0;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-item img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
    }

    .order-item .price {
        color: #ff5a5f;
        font-weight: bold;
    }

    .order-item .original-price {
        text-decoration: line-through;
        color: #999;
    }

    .order-item .status {
        color: #ff5a5f;
        font-size: 0.9rem;
        font-weight: bold;
    }

    th {
        padding: 8px 20px 8px 15px;
    }

    .order-summary {
        width: 95%;
        /* Chiếm 1/4 màn hình */
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
        /* Căn giữa */
    }

    .order-summary img {
        max-width: 100%;
        border-radius: 4px;
        margin-bottom: 8px;
    }

    .order-summary .label {
        font-weight: bold;
    }

    .order-summary {
        padding: 15px 0;
        margin-bottom: 10px;
    }

    .offcanvas {
        width: 40% !important;
    }
</style>
<?php
// var_dump($listOrder);
?>
<div class="py-4 bg-white mt-5" style="width:80%;margin:auto">
    <!-- Header -->
    <div class="text-center mb-4">
        <h3 class="fw-bold text-danger">Đơn Hàng</h3>
        <p class="text-muted">Quản lý và theo dõi trạng thái đơn hàng của bạn</p>
    </div>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs justify-content-between mb-4" id="order-tabs">

        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#0">Chờ xác nhận</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#1">Chờ lấy hàng</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#2">Đang vận chuyển</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#3">Đánh giá</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#5">Đã hủy</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#4">Lịch sử mua hàng</button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content px-4">
        <!-- Tất cả -->
        <div class="tab-pane fade" id="4">
            <?php
            $check = 0;
            foreach ($listOrder as $key => $value)
                if ($value['order_status'] == 4 || $value['order_status'] == 3) {
                    $check++;
            ?>
                <div class="order-item d-flex align-items-center justify-content-between">
                    <table>
                        <tr>
                            <th>Mã đơn hàng: </th>
                            <td>ROYAL_<?= $value['order_id'] ?></td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối: </th>
                            <td><?= $value['update_at'] ?></td>
                        </tr>
                        <tr>
                            <th>Tổng thanh toán: </th>
                            <td><?= number_format($value['final_price']) . " VNĐ" ?></td>
                        </tr>
                    </table>
                    <div class="d-flex align-item-end flex-column">
                        <a class="btn btn-info d-block mb-3" data-bs-toggle="offcanvas" href="#r-<?= $value['order_id'] ?>" role="button" aria-controls="offcanvasExample">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            <?php
                }
            if ($check == 0) {
            ?>
                <div>
                    <img style="width: 100%;" src="uploads/order_status_empty.png" alt="">
                </div>
            <?php
            }
            ?>
        </div>

        <!-- Chờ thanh toán -->
        <div class="tab-pane fade show active" id="0">
            <?php
            $check = 0;
            foreach ($listOrder as $key => $value)
                if ($value['order_status'] == 0) {
                    $check++;
            ?>
                <div class="order-item d-flex align-items-center justify-content-between">
                    <table>
                        <tr>
                            <th>Mã đơn hàng: </th>
                            <td>ROYAL_<?= $value['order_id'] ?></td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối: </th>
                            <td><?= $value['update_at'] ?></td>
                        </tr>
                        <tr>
                            <th>Tổng thanh toán: </th>
                            <td><?= number_format($value['final_price']) . " VNĐ" ?></td>
                        </tr>
                    </table>
                    <div>
                        <a class="btn btn-info d-block mb-3" data-bs-toggle="offcanvas" href="#r-<?= $value['order_id'] ?>" role="button" aria-controls="offcanvasExample">
                            Xem chi tiết
                        </a>
                        <a href="?controller=order&action=cancelOrder&order_id=<?= $value['order_id'] ?>" class="d-block btn btn-danger" href="">Huỷ đơn hàng</a>
                    </div>
                </div>
            <?php
                }
            if ($check == 0) {
            ?>
                <div>
                    <img style="width: 100%;" src="uploads/order_status_empty.png" alt="">
                </div>
            <?php
            }
            ?>
        </div>
        <div class="tab-pane fade" id="1">
            <?php
            $check = 0;
            foreach ($listOrder as $key => $value)
                if ($value['order_status'] == 1) {
                    $check++;
            ?>
                <div class="order-item d-flex align-items-center justify-content-between">
                    <table>
                        <tr>
                            <th>Mã đơn hàng: </th>
                            <td>ROYAL_<?= $value['order_id'] ?></td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối: </th>
                            <td><?= $value['update_at'] ?></td>
                        </tr>
                        <tr>
                            <th>Tổng thanh toán: </th>
                            <td><?= number_format($value['final_price']) . " VNĐ" ?></td>
                        </tr>
                    </table>
                    <div>
                        <a class="btn btn-info d-block mb-3" data-bs-toggle="offcanvas" href="#r-<?= $value['order_id'] ?>" role="button" aria-controls="offcanvasExample">
                            Xem chi tiết
                        </a>
                        <a href="?controller=order&action=cancelOrder&order_id=<?= $value['order_id'] ?>" class="d-block btn btn-danger" href="">Huỷ đơn hàng</a>
                    </div>
                </div>
            <?php
                }
            if ($check == 0) {
            ?>
                <div>
                    <img style="width: 100%;" src="uploads/order_status_empty.png" alt="">
                </div>
            <?php
            }
            ?>
        </div>
        <!-- Vận chuyển -->
        <div class="tab-pane fade" id="2">
            <?php
            foreach ($listOrder as $key => $value)
                if ($value['order_status'] == 2) {
                    $check++;
            ?>
                <div class="order-item d-flex align-items-center justify-content-between">
                    <table>
                        <tr>
                            <th>Mã đơn hàng: </th>
                            <td>ROYAL_<?= $value['order_id'] ?></td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối: </th>
                            <td><?= $value['update_at'] ?></td>
                        </tr>
                        <tr>
                            <th>Tổng thanh toán: </th>
                            <td><?= number_format($value['final_price']) . " VNĐ" ?></td>
                        </tr>
                    </table>
                    <div class="d-flex align-item-end flex-column">
                        <a class="btn btn-info d-block mb-3" data-bs-toggle="offcanvas" href="#r-<?= $value['order_id'] ?>" role="button" aria-controls="offcanvasExample">
                            Xem chi tiết
                        </a>
                        <a href="?controller=order&action=shippingSuccess&order_id=<?= $value['order_id'] ?>" class="d-block btn btn-danger" href="">Đã nhận được hàng</a>
                    </div>
                </div>
            <?php
                }
            if ($check == 0) {
            ?>
                <div>
                    <img style="width: 100%;" src="uploads/order_status_empty.png" alt="">
                </div>
            <?php
            }
            ?>
        </div>

        <!-- Hoàn thành -->
        <div class="tab-pane fade" id="3">
            <?php
            foreach ($listOrder as $key => $value)
                if ($value['order_status'] == 3) {
                    $check++;
            ?>
                <div class="order-item d-flex align-items-center justify-content-between">
                    <table>
                        <tr>
                            <th>Mã đơn hàng: </th>
                            <td>ROYAL_<?= $value['order_id'] ?></td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối: </th>
                            <td><?= $value['update_at'] ?></td>
                        </tr>
                        <tr>
                            <th>Tổng thanh toán: </th>
                            <td><?= number_format($value['final_price']) . " VNĐ" ?></td>
                        </tr>
                    </table>
                    <a href="?controller=comment&order_id=<?= $value['order_id'] ?>" class="ms-auto btn btn-danger">Đánh giá đơn hàng</a>
                </div>
            <?php
                }
            if ($check == 0) {
            ?>
                <div>
                    <img style="width: 100%;" src="uploads/order_status_empty.png" alt="">
                </div>
            <?php
            }
            ?>
        </div>

        <!-- Đã hủy -->
        <div class="tab-pane fade" id="5">
            <?php
            foreach ($listOrder as $key => $value)
                if ($value['order_status'] == 5) {
                    $check++;
            ?>
                <div class="order-item d-flex align-items-center justify-content-between">
                    <table>
                        <tr>
                            <th>Mã đơn hàng: </th>
                            <td>ROYAL_<?= $value['order_id'] ?></td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối: </th>
                            <td><?= $value['update_at'] ?></td>
                        </tr>
                        <tr>
                            <th>Tổng thanh toán: </th>
                            <td><?= number_format($value['final_price']) . " VNĐ" ?></td>
                        </tr>
                    </table>
                    <a class="btn btn-info d-block mb-3" data-bs-toggle="offcanvas" href="#r-<?= $value['order_id'] ?>" role="button" aria-controls="offcanvasExample">
                        Xem chi tiết
                    </a>
                </div>
            <?php
                }
            if ($check == 0) {
            ?>
                <div>
                    <img style="width: 100%;" src="uploads/order_status_empty.png" alt="">
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php
$groupByOrderId = [];
foreach ($listOrderDetail as $key => $value) {
    $orderId = $value['order_id'];
    if (!isset($groupByOrderId[$orderId])) {
        $groupByOrderId[$orderId] = [];
    }
    $groupByOrderId[$orderId][] = $value;
}

foreach ($groupByOrderId as $key => $value) {
?>
    <div class="offcanvas offcanvas-start" tabindex="-1" id="r-<?= $key ?>" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h6 class="offcanvas-title fw-bold text-primary" id="offcanvasExampleLabe">Chi tiết đơn hàng</h6>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <?php
                foreach ($value as $ke => $item) {
                ?><div class="order-summary row">
                        <div class="col-4"><img src="uploads/<?= $item['image_main'] ?>" alt="Sản phẩm"></div>
                        <div class="col-8">
                            <p><span class="label">Màu sắc:</span> <?= $item['color_name'] ?></p>
                            <p><span class="label">Size:</span> <?= $item['size_name'] ?></p>
                            <p><span class="label">Số lượng:</span> <?= $item['quantity'] ?></p>
                            <p class="mt-2"><span class="label">Giá:</span> <?= number_format($item['price']) . " VNĐ" ?></p>
                            <p><?php if ($item['payment_status'] == 1) echo "<span class='px-2 py-1 rounded bg-success text-light'>Đã thanh toán</span>";
                                else echo "<span class='px-2 py-1 rounded text-light bg-secondary'>Chưa thanh toán</span>"; ?></p>
                        </div>
                    </div>
                <?php
                }
                ?>
                <p class="text-end p-3 fw-bold">Tổng thanh toán: <?= number_format($value[0]['final_price']) . " VNĐ" ?></p>
            </div>
        </div>
    </div>
<?php
}
?>