<div class="container">

    <form action="?role=admin&controller=product&action=update&id=<?= $_GET['id'] ?>" method="POST" enctype="multipart/form-data" class="p-4 shadow-sm mx-auto mb-5" style="width: 83.33%; background: #fff; border-radius: 8px;">
        <h6 class="mb-4 font-weight-bold text-primary">Chỉnh sửa sản phẩm</h6>

        <div class="">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="<?= $product['product_name']; ?>">
            <p><?php getErorr('product_name'); ?></p>
        </div>
        <div class="d-flex gap-3 justify-content-between p-3 border rounded">
            <div>
                <div><label for="category_id" class="form-label">Category</label></div>
                <select class="form-select" id="category_id" name="category_id">
                    <?php
    
                    foreach ($list as $key => $value) : ?>
                        <option value="<?php echo $value['category_id']; ?>" <?php echo ($value['category_id'] == $product['category_id']) ? "selected" : "" ?>><?php echo $value['category_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <p><?php getErorr('category_id'); ?></p>
            </div>
            <div class="d-flex gap-2 mb-3 ">
                <div class="">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <p><?php getErorr('image'); ?></p>
                </div>
                <div class="p-3">
                    <img class="rounded border" width="160px" src="uploads/<?php echo $product['image']; ?>" alt="">
                </div>
            </div>
        </div>


        <div class="row mb-3">
            <!-- Trường Description -->
            <div class="col-md-8">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="2"><?= $product['description']; ?></textarea>
                <p><?php getErorr('description'); ?></p>
            </div>
        </div>

        <!-- Nút Submit -->
        <div class="text-end">
            <button type="submit" class="btn btn-success">Cập nhật sản phẩm</button>
        </div>
    </form>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>