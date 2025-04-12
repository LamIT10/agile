<style>
    .product-images img {
        width: 100%;
        cursor: pointer;
    }

    .thumbnail {
        width: 100px;
        height: 100px;
        object-fit: cover;
        cursor: pointer;
    }

    .thumbnail-container {
        display: flex;
        gap: 10px;
    }

    .product-info {
        padding-left: 30px;
    }

    .btn-orange {
        background-color: #ff9900;
        color: white;
    }

    .btn-orange:hover {
        background-color: #ff6600;
    }

    .product-title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .price {
        font-size: 1.2rem;
        color: #e53935;
    }

    #main {
        animation: to-right 0.5s ease-in-out forwards;
    }

    .add {
        animation: to 0.5s ease-in-out forwards;
    }

    @keyframes to {
        0% {
            transform: translate(-100%);
        }

        100% {
            transform: translate(0);
        }
    }

    @keyframes to-right {
        0% {
            scale: 0.5;
        }

        50% {
            scale: 1.1;
        }

        100% {
            scale: 1;
        }
    }
</style>
<?php
$product = $productDetail['product'][0];
?>



<div class="container mt-5">
    <div class="row">
        <!-- Ảnh to và Ảnh nhỏ -->
        <div class="col-lg-6">
            <div class="d-flex justify-content-center gap-2">
                <div class="col-2 d-flex flex-column gap-2">
                    <img class='add' width="89px" src="uploads/<?= $product['image_main'] ?>" alt="Thumbnail 1" class="">
                    <?php foreach ($productDetail['image'] as $key => $value) {
                    ?>
                        <img class="add" width="89px" src="uploads/<?= $value['image_link'] ?>" alt="Thumbnail" class="">
                    <?php
                    }
                    ?>
                </div>
                <!-- Ảnh nhỏ -->
                <div class="col-9">
                    <div class="product-images">
                        <img id="main" src="uploads/<?= $product['image_main'] ?>" alt="Product Image" class="img-fluid">
                    </div>
                </div>
                <!-- Ảnh lớn -->
            </div>
        </div>
        <!-- Thông tin sản phẩm -->
        <div class="col-lg-6 product-info">
            <div class="product-title"><?= $product['product_name'] ?></div>
            <?php
            if (!empty($rating)) {
            ?>
                <div class="mt-2 d-flex align-items-center">
                    <div><?= renderStar($rating['rating']) ?></div>
                    <div class="ms-3"><b class="text-primary"><?= $rating['count'] ?></b> đánh giá</div>
                </div>
            <?php
            } else {
            ?>
                <div class="mt-2 text-secondary">Chưa có đánh giá</div>
            <?php
            }
            ?>
            <div class="price mt-3 fw-bold"><?= number_format($product['sale_price']) ?> VNĐ</div>
            <div class="fs-6 price mt-2 text-decoration-line-through text-secondary"><?= number_format($product['base_price']) ?> VNĐ</div>

            <!-- Màu sắc -->
            <div class="mt-3">
                <label class="mb-2" for="color">Màu sắc:</label><br>
                <?php
                foreach ($productDetail['color'] as $key => $value) {
                ?>
                    <a class="me-1" style="display:inline-block;width:30px;height:30px;background-color: <?= $value['color_code'] ?>;border-radius:50%;border:1px solid" href="?controller=productdetail&id=<?= $_GET['id'] ?>&colorId=<?= $value['color_id'] ?>&sizeId=<?= $_GET['sizeId'] ?>"></a>
                <?php
                }
                ?>
            </div>

            <!-- Kích thước -->
            <div class="mt-3">
                <label class="mb-2" for="size">Kích thước:</label><br>
                <?php
                foreach ($productDetail['size'] as $key => $value) {
                ?>
                    <a class="btn btn-outline-dark" href="?controller=productdetail&id=<?= $_GET['id'] ?>&colorId=<?= $_GET['colorId'] ?>&sizeId=<?= $value['size_id'] ?>"><?= $value['size_name'] ?></a>
                <?php
                }
                ?>
            </div>
            <div class="mt-3">
                <?php
                if (isset($_SESSION['user'])) {
                    if ($productDetail['addToCart']) {
                ?>
                        <form action="?controller=cart&action=store" method="post">
                            <div class="mt-3">
                                Sản phẩm được chọn: <b class="text-primary fw-bold"><?= $product['color_name'] ?> - <?= $product['size_name'] ?></b>
                            </div>
                            <p class="mt-3">Số lượng sản phẩm còn: <b class="text-primary fw-bold"><?= $product['quantity'] ?></b></p>
                            <input type="hidden" name="variant_id" value="<?= $product['variant_id'] ?>">
                            <label for="quantity_cart">Số lượng:</label><br>
                            <input type="number" class="form-control w-25 d-inline" min="1" value="1" id="quantity_cart" name="quantity_cart">
                            <br>
                            <button type="submit" name="addCart" class="btn btn-orange w-100 mt-3">Thêm vào giỏ hàng</button>
                        </form>
                <?php
                    } else {
                        echo "<button type='submit' name='addCart' class='btn btn-secondary w-100 mt-3'>Vui lòng chọn lại size</button>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-5"></div>
        <div class="mt-4 col-7">
            <h6 class="p-3 bg-white mb-3" style="border-left: 6px solid orange;">Tất cả bình luận</h6>
            <div class="list-group " style="border-radius: 0;border-left: 6px solid orange;">
                <?php
                foreach ($allComment as $key => $value) {
                ?>
                    <div class="list-group-item py-3 px-4" style="position: relative;">
                        <div class="d-flex align-items-start">
                            <img width="70px" height="70px" src="uploads/<?= $value['avatar'] ?>" class="rounded-circle me-3" alt="Avatar">
                            <div class="flex-grow-1">
                                <div class="">
                                    <h6 class="mb-1 fw-bold"><?= $value['full_name'] ?></h6>
                                    <div class="text-warning rating mb-1" data-rating="<?= $value['rating'] ?>">

                                    </div>
                                </div>
                                <small class="text-primary"><?= $value['create_at'] ?></small> | <span class="text-secondary">Mã đơn: ROYAL_<?= $value['order_id'] ?></span>
                                <p class="mb-1 mt-2"><?= $value['content'] ?></p>
                            </div>
                        </div>
                        <?php
                        if (isset($_SESSION['user']) && $_SESSION['user']['user_id'] == $value['user_id']) {
                        ?>
                            <a href="?controller=comment&action=delete&id=<?= $value['comment_id'] ?>" style="position: absolute; top: 0; right: 15;" class="btn btn-link text-danger p-0 mt-2 delete-btn">Xoá bình luận</a>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    let add = document.querySelectorAll('.add');
    let main = document.getElementById('main');
    // main = new Image();
    // console.log(main.src);

    for (let index = 0; index < add.length; index++) {
        // add[index] = new Image();
        const element = add[index];
        element.addEventListener('click', function() {
            main.src = element.src;
        })
    }

    function renderStars(rating) {
        let stars = "";
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                stars += ' <i class="bi bi-star-fill text-warning"></i> '; // Sao vàng (đã chọn)
            } else {
                stars += ' <i class="bi bi-star text-warning"></i> '; // Sao rỗng (chưa chọn)
            }
        }
        return stars;
    }
    let rating = document.querySelectorAll('.rating');
    for (let i = 0; i < rating.length; i++) {
        rating[i].innerHTML = renderStars(rating[i].dataset.rating);
    }
</script>