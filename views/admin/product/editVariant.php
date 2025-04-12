<div class="container mt-4">
    <form action="?role=admin&controller=product&action=updateVariant&id=<?= $_GET['id'] ?>&product_id=<?= $_GET['product_id'] ?>" method="POST" enctype="multipart/form-data" class="p-4 mb-5 shadow-sm mx-auto" style="width: 83.33%; background: #fff; border-radius: 8px;">
        <h6 class="mb-4 font-weight-bold text-primary">Sửa Biến Thể</h6>
        <div class="row mb-3">

            <!-- Trường Base Price -->
            <div class="col-md-4">
                <label for="base_price" class="form-label">Base Price</label>
                <input type="text" value="<?= ($variant['base_price']); ?>" class="form-control" id="base_price" name="base_price">
                <p><?php getErorr('base_price') ?></p>
            </div>
            <!-- Trường Sale Price -->
            <div class="col-md-4">
                <label for="sale_price" class="form-label">Sale Price</label>
                <input type="text" value="<?= ($variant['sale_price']); ?>" class="form-control" id="sale_price" name="sale_price">
                <p><?php getErorr('sale_price') ?></p>
            </div>


            <!-- Trường Variant Main -->
            <div class="col-md-4">
                <label for="variant_main" class="form-label">Variant Main</label>
                <select class="form-select" id="variant_main" name="variant_main">
                    <?php
                    for ($i = 0; $i < 2; $i++) {
                    ?>
                        <option <?php echo ($variant['variant_main'] == $i) ? "selected" : "" ?> value="<?= $i ?>"><?= $i ?></option>
                    <?php
                    }
                    ?>
                </select>
                <p><?php getErorr('variant_main') ?></p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="d-flex gap-4">
                <?php
                foreach ($color as $key => $value) {
                ?>
                    <div class="form-check me-2">
                        <input <?php echo ($variant['color_id'] == $value['color_id']) ? "checked" : "" ?> class="form-check-input" type="radio" name="color_id" id="color<?= $value['color_id'] ?>" value="<?= $value['color_id'] ?>">
                        <label for="color<?= $value['color_id'] ?>" style="background-color: <?= $value['color_code'] ?>; width:30px;height:30px;border:1px solid" class="form-check-label rounded-circle"></label>
                    </div>
                <?php
                }
                getErorr('color_id');
                ?>
            </div>

            <!-- Trường Size -->

            <div class="col-md-4">
                <label for="size" class="form-label">Size</label>
                <select class="form-select" id="size" name="size_id">
                    <?php
                    foreach ($size as $key => $value) {
                    ?>
                        <option <?php echo ($variant['size_id'] == $value['size_id']) ? "selected" : "" ?> value="<?= $value['size_id'] ?>"><?= $value['size_name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <p><?php getErorr('size_id') ?></p>
                <p><?php getErorr('variant') ?></p>
            </div>

            <!-- Trường Quantity -->
            <div class="col-md-4">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" value="<?= $variant['quantity'] ?>" name="quantity" placeholder="Số lượng">
            </div>
            <p><?php getErorr('quantity') ?></p>
        </div>
        <div class="row mb-3 d-flex align-items-center justify-content-between gap-3">
            <!-- Trường Image -->
            <div>
                <label for="image" class="form-label">Image main</label>
                <input type="file" class="form-control" id="image" name="image_main">
                <img class="m-2 rounded border" width="200px" src="uploads/<?= $variant['image_main'] ?>" alt="">
                <?php getErorr('image_main') ?>
            </div>
            <div>
                <label for="image" class="form-label">Image add</label>
                <input type="file" class="form-control" id="image" name="image[]" multiple>
                <?php
                $imageAddArray = explode(",", $variant['image_urls']);
                foreach ($imageAddArray as $key => $value) {
                ?>
                    <img class="m-2 rounded border" width="100px" src="uploads/<?= $value ?>" alt="">
                <?php
                }
                ?>
                <p><?php getErorr('image') ?></p>
            </div>

        </div>

        <!-- Nút Submit -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Update variant</button>
        </div>
    </form>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>