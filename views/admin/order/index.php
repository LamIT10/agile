<?php
// var_dump($listOrder[4]);
?>
<style>
    .nav-tabs .nav-link {
        color: #555;
        font-weight: bold;
        border: none;
        min-width: 100px;
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

    #line {
        width: 100%;
        height: 5px;
        border-radius: 5px;
    }

    th {
        padding: 8px 20px 8px 0px;
    }
</style>
<?php
// var_dump($listOrder);
?>
<div class="container py-4 bg-white mt-5 mb-5" style="width:80%">
    <!-- Header -->
    <div class="mb-4">
        <h5 class="fw-bold text-primary">Đơn Hàng</h5>
        <div id="line" class="bg-primary"></div>
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
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#5">Đã hủy</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#3">Đơn hàng thành công</button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mb-3">
        <!-- Tất cả -->
        <div class="tab-pane fade" id="3">
            <?php
            $check = 0;
            foreach ($listOrder as $key => $value)
                if ($value['order_status'] == 3 || $value['order_status'] == 4) {
                    $check++;
            ?>
                <div class="order-item d-flex align-items-center justify-content-between border p-3 rounded mb-3">
                    <table>
                        <tr>
                            <th>Tên khách hàng: </th>
                            <td><?= $value['full_name'] ?></td>
                        </tr>
                        <tr>
                            <th>Mã đơn hàng: </th>
                            <td>ROYAL_<?= $value['order_id'] ?></td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối: </th>
                            <td><?= $value['update_at'] ?></td>
                        </tr>
                        <tr>
                            <th>Phương thức thanh toán: </th>
                            <td><?php
                                if ($value['payment_method'] == 0) {
                                    echo "Thanh toán COD";
                                } else if ($value['payment_method'] == 1) {
                                    echo "Thanh toán VNPAY";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th>Trạng thái thanh toán: </th>
                            <td><?php
                                if ($value['payment_status'] == 0) {
                                    echo "<div class='bg-secondary text-white rounded p-1 text-center'>Chưa thanh toán</div>";
                                } else if ($value['payment_status'] == 1) {
                                    echo "<div class='bg-success text-white rounded p-1 text-center'>Đã thanh toán</div>";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th>Tổng thanh toán: </th>
                            <td><?= number_format($value['final_price']) . " VNĐ" ?></td>
                        </tr>
                    </table>
                    <div class="d-flex align-item-end flex-column">
                        <a href="?role=admin&controller=order&action=detail&id=<?= $value['order_id'] ?>" class="btn bg-warning d-block text-white mb-3">Xem chi tiết</a>
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
            foreach ($listOrder as $key => $value) {
                if ($value['order_status'] == 0) {
                    $check = 1;
            ?>
                    <div class="order-item d-flex align-items-center justify-content-between border p-3 rounded mb-3">
                        <table>
                            <tr>
                                <th>Tên khách hàng: </th>
                                <td><?= $value['full_name'] ?></td>
                            </tr>
                            <tr>
                                <th>Mã đơn hàng: </th>
                                <td>ROYAL_<?= $value['order_id'] ?></td>
                            </tr>
                            <tr>
                                <th>Cập nhật lần cuối: </th>
                                <td><?= $value['update_at'] ?></td>
                            </tr>
                            <tr>
                                <th>Phương thức thanh toán: </th>
                                <td><?php
                                    if ($value['payment_method'] == 0) {
                                        echo "Thanh toán COD";
                                    } else if ($value['payment_method'] == 1) {
                                        echo "Thanh toán VNPAY";
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <th>Trạng thái thanh toán: </th>
                                <td><?php
                                    if ($value['payment_status'] == 0) {
                                        echo "<div class='bg-secondary text-white rounded p-1 text-center'>Chưa thanh toán</div>";
                                    } else if ($value['payment_status'] == 1) {
                                        echo "<div class='bg-success text-white rounded p-1 text-center'>Đã thanh toán</div>";
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <th>Tổng thanh toán: </th>
                                <td><?= number_format($value['final_price']) . " VNĐ" ?></td>
                            </tr>
                        </table>
                        <div class="d-flex align-item-end flex-column">
                            <a href="?role=admin&controller=order&action=detail&id=<?= $value['order_id'] ?>" class="btn bg-warning d-block text-white mb-3">Xem chi tiết</a>
                            <a class="btn btn-primary d-block" href="?role=admin&controller=order&action=buttonChangeStatus&status=<?= $value['order_status'] ?>&id=<?= $value['order_id'] ?>">Xác nhận đơn hàng</a>
                        </div>
                    </div>
                <?php
                }
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
                    $check = 1;
            ?>
                <div class="order-item d-flex align-items-center justify-content-between border p-3 rounded mb-3">
                    <table>
                        <tr>
                            <th>Tên khách hàng: </th>
                            <td><?= $value['full_name'] ?></td>
                        </tr>
                        <tr>
                            <th>Mã đơn hàng: </th>
                            <td>ROYAL_<?= $value['order_id'] ?></td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối: </th>
                            <td><?= $value['update_at'] ?></td>
                        </tr>
                        <tr>
                            <th>Phương thức thanh toán: </th>
                            <td><?php
                                if ($value['payment_method'] == 0) {
                                    echo "Thanh toán COD";
                                } else if ($value['payment_method'] == 1) {
                                    echo "Thanh toán VNPAY";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th>Trạng thái thanh toán: </th>
                            <td><?php
                                if ($value['payment_status'] == 0) {
                                    echo "<div class='bg-secondary text-white rounded p-1 text-center'>Chưa thanh toán</div>";
                                } else if ($value['payment_status'] == 1) {
                                    echo "<div class='bg-success text-white rounded p-1 text-center'>Đã thanh toán</div>";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th>Tổng thanh toán: </th>
                            <td><?= number_format($value['final_price']) . " VNĐ" ?></td>
                        </tr>
                    </table>
                    <div class="d-flex align-item-end flex-column">
                        <a href="?role=admin&controller=order&action=detail&id=<?= $value['order_id'] ?>" class="btn bg-warning d-block text-white mb-3">Xem chi tiết</a>
                        <a class="btn btn-primary d-block" href="?role=admin&controller=order&action=buttonChangeStatus&status=<?= $value['order_status'] ?>&id=<?= $value['order_id'] ?>">Bắt đầu vận chuyển</a>
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
            $check = 0;
            foreach ($listOrder as $key => $value)
                if ($value['order_status'] == 2) {
                    $check = 1;
            ?>
                <div class="order-item d-flex align-items-center justify-content-between border p-3 rounded mb-3">
                    <table>
                        <tr>
                            <th>Tên khách hàng: </th>
                            <td><?= $value['full_name'] ?></td>
                        </tr>
                        <tr>
                            <th>Mã đơn hàng: </th>
                            <td>ROYAL_<?= $value['order_id'] ?></td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối: </th>
                            <td><?= $value['update_at'] ?></td>
                        </tr>
                        <tr>
                            <th>Phương thức thanh toán: </th>
                            <td><?php
                                if ($value['payment_method'] == 0) {
                                    echo "Thanh toán COD";
                                } else if ($value['payment_method'] == 1) {
                                    echo "Thanh toán VNPAY";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th>Trạng thái thanh toán: </th>
                            <td><?php
                                if ($value['payment_status'] == 0) {
                                    echo "<div class='bg-secondary text-white rounded p-1 text-center'>Chưa thanh toán</div>";
                                } else if ($value['payment_status'] == 1) {
                                    echo "<div class='bg-success text-white rounded p-1 text-center'>Đã thanh toán</div>";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th>Tổng thanh toán: </th>
                            <td><?= number_format($value['final_price']) . " VNĐ" ?></td>
                        </tr>
                    </table>
                    <div class="d-flex align-item-end flex-column">
                        <a href="?role=admin&controller=order&action=detail&id=<?= $value['order_id'] ?>" class="btn bg-warning d-block text-white mb-3">Xem chi tiết</a>
                        <a class="btn btn-primary d-block" href="?role=admin&controller=order&action=buttonChangeStatus&status=<?= $value['order_status'] ?>&id=<?= $value['order_id'] ?>">Xác nhận giao hàng thành công</a>
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


        <!-- Đã hủy -->
        <div class="tab-pane fade" id="5">
            <?php
            $check = 0;
            foreach ($listOrder as $key => $value)
                if ($value['order_status'] == 5) {
                    $check = 1;
            ?>
                <div class="order-item d-flex align-items-center justify-content-between border p-3 rounded mb-3">
                    <table>
                        <tr>
                            <th>Tên khách hàng: </th>
                            <td><?= $value['full_name'] ?></td>
                        </tr>
                        <tr>
                            <th>Mã đơn hàng: </th>
                            <td>ROYAL_<?= $value['order_id'] ?></td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối: </th>
                            <td><?= $value['update_at'] ?></td>
                        </tr>
                        <tr>
                            <th>Phương thức thanh toán: </th>
                            <td><?php
                                if ($value['payment_method'] == 0) {
                                    echo "Thanh toán COD";
                                } else if ($item['payment_method'] == 1) {
                                    echo "Thanh toán VNPAY";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th>Trạng thái thanh toán: </th>
                            <td><?php
                                if ($value['payment_status'] == 0) {
                                    echo "<div class='bg-secondary text-white rounded p-1 text-center'>Chưa thanh toán</div>";
                                } else if ($value['payment_status'] == 1) {
                                    echo "<div class='bg-success text-white rounded p-1 text-center'>Đã thanh toán</div>";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <th>Tổng thanh toán: </th>
                            <td><?= number_format($value['final_price']) . " VNĐ" ?></td>
                        </tr>
                    </table>
                    <div class="d-flex align-item-end flex-column">
                        <a href="?role=admin&controller=order&action=detail&id=<?= $value['order_id'] ?>" class="btn bg-warning d-block text-white mb-3">Xem chi tiết</a>
                        <a class="btn btn-primary d-block" href="?role=admin&controller=order&action=buttonChangeStatus&status=' . $item['order_status'] . '&id=' . $item['order_id'] . '">Xác nhận đơn hàng</a>
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
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>