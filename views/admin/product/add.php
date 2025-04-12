<div class="container">


    <form action="?role=admin&controller=product&action=store" method="POST" enctype="multipart/form-data" class="p-4 shadow-sm mx-auto mb-5" style="width: 83.33%; background: #fff; border-radius: 8px;">
        <h6 class="mb-4 font-weight-bold text-primary">Thêm sản phẩm</h6>

        <div class="">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Nhập tên sản phẩm">
            <p><?php getErorr('product_name'); ?></p>
        </div>
        <div class="">
            <div><label for="category_id" class="form-label">Category</label></div>
            <select class="form-select" id="category_id" name="category_id">
                <option value="" selected hidden>Chọn danh mục</option>
                <?php

                foreach ($category as $key => $value) : ?>
                    <option value="<?php echo $value['category_id']; ?>"><?php echo $value['category_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <p><?php getErorr('category_id'); ?></p>
        </div>
        <div class="">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <p><?php getErorr('image'); ?></p>
        </div>
        <!-- <div class="mb-3">
            <label for="avatar" class="form-label">Ảnh đại diện:</label>
            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
        </div> -->
        <div class="row mb-3">
            <!-- Trường Description -->
            <div class="col-md-8">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Nhập mô tả sản phẩm" rows="2"></textarea>
                <p><?php getErorr('description'); ?></p>
            </div>

            <!-- Trường Image -->

        </div>

        <!-- Nút Submit -->
        <div class="text-end">
            <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
        </div>
    </form>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>