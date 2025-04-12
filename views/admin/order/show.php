
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Chi tiết đơn hàng</h5>
    </div>
    <?php
    foreach ($list as $key => $value) {
    ?>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <img style="width: 200px" src="uploads/<?= $value['image_main'] ?>" alt="Sản phẩm" class="img-fluid rounded shadow-sm">
                </div>
                <div class="col-md-9">
                    <h5 class="card-title"><?= $value['product_name'] ?></h5>
                    <p class="mb-2"><strong>Màu sắc:</strong> <?= $value['color_name'] ?></p>
                    <p class="mb-2"><strong>Kích cỡ:</strong> <?= $value['size_name'] ?></p>
                    <p class="mb-2"><strong>Số lượng:</strong> <?= $value['quantity'] ?></p>
                    <p class="mb-2"><strong>Giá 1 sản phẩm:</strong> <?= number_format($value['price']) . " VNĐ" ?></p>
                </div>
            </div>
            <hr>
        </div>
    <?php
    }
    ?>
</div>