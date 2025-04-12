<?php
if (isset($banner)) {
?>
    <div>
        <img style="width: 100%" src="uploads/<?= $banner['banner'] ?>" alt="">
    </div>
<?php
}
?>
<div class="container mt-5">
    <?php
    if (!empty($result)) {
    ?>
        <p><?= $result ?></p>
        <?php
    } else {
        echo "<div class='d-flex justify-content-center gap-4 mb-5'>";
        foreach ($child as $key => $value) {
        ?>
            <a class="btn border py-3 fw-bold shadow-sm" href="?controller=product&action=searchByCategory&id=<?= $value['category_id'] ?>"><?= mb_strtoupper($value['category_name']) ?></a>
    <?php
        }
        echo "</div>";
    }
    ?>
    <div class="row g-5">
        <?php
        foreach ($list as $key => $value):
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
</div>