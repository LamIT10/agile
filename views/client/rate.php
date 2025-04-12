<style>
    .rate {
        display: flex;
        gap: 5px;
    }

    .rate input[type="radio"] {
        display: none;
    }

    .rate label {
        font-size: 32px;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s ease;
    }
</style>
<?php
?>
<div class="container py-5">
    <div class="row">
        <div class="col-5">
            <?php
            foreach ($orderInfor as $key => $item) {
            ?>
                <div class="row shadow-sm p-3 rounded bg-white mb-3 mr-2">
                    <div class="col-5"><img style="width: 100%;" src="uploads/<?= $item['image_main'] ?>" alt="Sản phẩm"></div>
                    <div class="col-7">
                        <p><span class="label">Màu sắc:</span> <?= $item['color_name'] ?></p>
                        <p><span class="label">Size:</span> <?= $item['size_name'] ?></p>
                        <p><span class="label">Số lượng:</span> <?= $item['quantity'] ?></p>
                        <p class="mt-2"><span class="label">Giá:</span> <?= number_format($item['price']) . " VNĐ" ?></p>
                        
                    </div>
                </div>

            <?php
            }
            ?>
        </div>
        <!-- Bên phải: Đánh giá -->
        <div class="col-md-7 bg-white shadow-sm p-4 rounded">
            <h5>Đánh giá sản phẩm</h5>
            <hr>

            <form action="?controller=comment&action=store&order_id=<?= $orderInfor[0]['order_id'] ?>" method=post class="comment-section">

                <!-- Đánh giá bằng sao -->
                <?php
                foreach ($orderInfor as $key => $value) {
                ?>
                    <div class="p-3 border rounded shadow-sm mt-3">
                        <h6 class="text-primary"><?= $value['product_name'] ?></h6>
                        <div class="rate rating-container<?= $value['detail_id'] ?> mb-2">
                            <input type="radio" id="star<?= $value['detail_id'] ?>1" name="rating[<?= $value['detail_id'] ?>][rating]" value="1">
                            <label for="star<?= $value['detail_id'] ?>1">&#9733;</label>
                            <input type="radio" id="star<?= $value['detail_id'] ?>2" name="rating[<?= $value['detail_id'] ?>][rating]" value="2">
                            <label for="star<?= $value['detail_id'] ?>2">&#9733;</label>
                            <input type="radio" id="star<?= $value['detail_id'] ?>3" name="rating[<?= $value['detail_id'] ?>][rating]" value="3">
                            <label for="star<?= $value['detail_id'] ?>3">&#9733;</label>
                            <input type="radio" id="star<?= $value['detail_id'] ?>4" name="rating[<?= $value['detail_id'] ?>][rating]" value="4">
                            <label for="star<?= $value['detail_id'] ?>4">&#9733;</label>
                            <input type="radio" id="star<?= $value['detail_id'] ?>5" name="rating[<?= $value['detail_id'] ?>][rating]" value="5">
                            <label for="star<?= $value['detail_id'] ?>5">&#9733;</label>
                        </div>
                        <!-- Nhập nhận xét -->
                        <input type="hidden" name="rating[<?= $value['detail_id'] ?>][product_id]" value="<?= $value['product_id'] ?>">
                        <input type="hidden" name="rating[<?= $value['detail_id'] ?>][user_id]" value="<?= $_SESSION['user']['user_id'] ?>">
                        <input type="hidden" name="rating[<?= $value['detail_id'] ?>][order_id]" value="<?= $value['order_id'] ?>">
                        <textarea class=" form-control mb-3" rows="3" name="rating[<?= $value['detail_id'] ?>][content]" placeholder="Viết nhận xét của bạn tại đây..."></textarea>
                    </div>
                <?php
                }
                ?>
                <!-- Nút gửi -->
                <button type="submit" class="btn btn-primary w-100 mt-3 submit-btn">Gửi đánh giá</button>
            </form>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript -->
<script>
    // Lấy tất cả các input radio
    <?php
    foreach ($orderInfor as $key => $value) {
    ?>
        const stars<?= $value['detail_id'] ?> = document.querySelectorAll('.rating-container<?= $value['detail_id'] ?> input[type="radio"]');

        // Thêm sự kiện 'change' cho từng input radio
        stars<?= $value['detail_id'] ?>.forEach(star => {
            star.addEventListener('change', () => {
                // Lấy giá trị sao được chọn
                const ratingValue = star.value;

                // Lặp qua các label và input để cập nhật trạng thái
                stars<?= $value['detail_id'] ?>.forEach((input) => {
                    const label = input.nextElementSibling;

                    // Nếu giá trị input <= giá trị được chọn thì tô màu vàng
                    if (input.value <= ratingValue) {
                        label.style.color = '#ffc107'; // Màu vàng
                    } else {
                        label.style.color = '#ccc'; // Màu mặc định
                    }
                });
            });
        });
    <?php
    }
    ?>
</script>