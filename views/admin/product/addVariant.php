<div class="container mt-4">
    <form action="?role=admin&controller=product&action=storeVariant&id=<?= $_GET['id'] ?>" method="POST" enctype="multipart/form-data" class="p-4 my-5 shadow-sm mx-auto" style="width: 83.33%; background: #fff; border-radius: 8px;">
        <h6 class="mb-4 font-weight-bold text-primary">Thêm Biến Thể</h6>

        <div class="row mb-3">
            <!-- Trường Sale Price -->
            <div class="col-md-4">
                <label for="sale_price" class="form-label">Sale Price</label>
                <input type="number" class="form-control" id="sale_price" name="sale_price" placeholder="Giá khuyến mãi">
                <?= getErorr('sale_price') ?>
            </div>

            <!-- Trường Base Price -->
            <div class="col-md-4">
                <label for="base_price" class="form-label">Base Price</label>
                <input type="number" class="form-control" id="base_price" name="base_price" placeholder="Giá gốc">
                <?= getErorr('base_price') ?>
            </div>

            <!-- Trường Variant Main -->
            <div class="col-md-4">
                <label for="variant_main" class="form-label">Variant Main</label>
                <select class="form-select" id="variant_main" name="variant_main">
                    <option value="0">0</option>
                    <option value="1">1</option>
                </select>
                <?= getErorr('variant_main') ?>
            </div>
        </div>
        <?= getErorr('compare_price') ?>
        <div class="d-flex gap-3">
            <hr>
            <?php
            foreach ($color as $key => $value) {
            ?>
                <div class="form-check">
                    <input class="form-check-input" hidden type="radio" name="color_id" id="color_id<?= $value['color_id'] ?>" value="<?= $value['color_id'] ?>">
                    <label onclick="selectedBox(this)" class="form-check-label color opacity-50 opacity-100" style="width:35px;height:35px;background-color: <?= $value['color_code'] ?>;border:1px solid #474747;" for="color_id<?= $value['color_id'] ?>"></label>
                </div>
            <?php
            }
            ?>


            <?= getErorr('color') ?>
            <?= getErorr('variant') ?>
        </div>
        <div class="row mb-3 mt-3">
            <!-- Trường Color -->


            <!-- Trường Size -->
            <div class="col-md-4">
                <hr>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="s" name="size_id" value="1">
                    <label class="form-check-label" for="s">S</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="m" name="size_id" value="2">
                    <label class="form-check-label" for="m">M</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="l" name="size_id" value="3">
                    <label class="form-check-label" for="l">L</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="xl" name="size_id" value="4">
                    <label class="form-check-label" for="xl">XL</label>
                </div>
                <?= getErorr('size') ?>
            </div>

            <!-- Trường Quantity -->
            <div class="col-md-4">
                <hr>
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Số lượng">
                <?= getErorr('quantity') ?>
            </div>
        </div>
        <!-- Trường Image -->
        <div class="mb-4">
            <label for="image" class="form-label">Image main</label>
            <input type="file" class="form-control" id="image" name="image_main">
            <?= getErorr('image_main') ?>
        </div>
        <div class="mb-4">
            <label for="image" class="form-label">Image add (Choose 3 images)</label>
            <input type="file" class="form-control" id="image" name="image[]" multiple>
            <?= getErorr('image') ?>
        </div>

        <!-- Nút Submit -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Add variant</button>
        </div>
    </form>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const checkColor = document.querySelectorAll(".color");
    const selectedBox = (e) => {
        const checkColor = document.querySelectorAll(".color");
        checkColor.forEach(box => box.classList.remove('rounded-circle', 'opacity-100'));
        e.classList.add('rounded-circle', 'opacity-100');
    }
</script>