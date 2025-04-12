<style>
    .card-body {
        padding: 0;
    }

    .card {
        padding: 0;
    }

    .decoration-line {
        text-decoration: line-through;
        font-size: 13px;
    }

    .card-text {
        margin: 8px 0;
    }
</style>
<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        foreach ($listBanners as $key => $value):
        ?>
            <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                <img src="uploads/<?= $value['banner_link'] ?>" class="d-block w-100" alt="Banner Image">
            </div>
        <?php
        endforeach;
        ?>

    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container">
    <div class="fs-4 fw-bold text-center py-2 px-5" style="width: max-content;margin: 30px auto;border-bottom: 2px solid orangered;">Sản phẩm mới về</div>
    <div class="row g-5">
        <?php
        foreach ($listNew as $key => $value):
        ?>
            <div class="col-md-3">
                <a href="?controller=productdetail&id=<?= $value['product_id'] ?>&colorId=<?= $value['color_id'] ?>&sizeId=<?= $value['size_id'] ?>">
                    <div class="position-relative">
                        <img src="uploads/<?= $value['image'] ?>" class="card-img-top" alt="Product Image">
                    </div>
                    <div class="card-body mt-3">
                        <h6 class="card-title fw-normal"><?= $value['product_name'] ?></h6>
                        <div class="fw-bold my-1 fs-5"><?= number_format($value['sale_price']) ?> VNĐ</div>
                        <div class="text-muted text-decoration-line-through"><?= number_format($value['base_price']) ?> VNĐ</div>
                    </div>
                </a>
            </div>
        <?php
        endforeach;
        ?>
    </div>
    <div class="my-4">
        <img style="width: 100%" src="uploads/home1.webp" alt="">
    </div>
    <div class="fs-4 fw-bold text-center py-2 px-5" style="width: max-content;margin: 30px auto;border-bottom: 2px solid orangered;">Top sản phẩm nhiều lượt xem</div>
    <div class="row g-5">
        <?php
        foreach ($listView as $key => $value):
        ?>
            <div class="col-md-3">
                <a href="?controller=productdetail&id=<?= $value['product_id'] ?>&colorId=<?= $value['color_id'] ?>&sizeId=<?= $value['size_id'] ?>">
                    <div class="position-relative">
                        <img src="uploads/<?= $value['image'] ?>" class="card-img-top" alt="Product Image">
                    </div>
                    <div class="card-body mt-3">
                        <h6 class="card-title fw-normal"><?= $value['product_name'] ?></h6>
                        <div class="fw-bold my-1 fs-5"><?= number_format($value['sale_price']) ?> VNĐ</div>
                        <div class="text-muted text-decoration-line-through"><?= number_format($value['base_price']) ?> VNĐ</div>
                    </div>
                </a>
            </div>
        <?php
        endforeach;
        ?>
    </div>
    <div class="my-4">
        <img style="width: 100%" src="uploads/home2.webp" alt="">
    </div>
</div>