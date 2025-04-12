<div class="category-form">
    <h4 class="mb-4">Create Category</h4>
    <form action="?role=admin&controller=category&action=store" method="post" enctype="multipart/form-data">
        <!-- Category Name -->
        <div class="mb-3">
            <label for="categoryName" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="categoryName" placeholder="Enter category name" value="<?php echo $_SESSION['data']['category_name'] ?? null ?>" name="category_name">
            <?php getErorr('category_name') ?>
        </div>
        <!-- Parent Category -->
        <div class="mb-3">
            <label for="parentCategory" class="form-label">Parent Category</label>
            <select class="form-select" id="parentCategory" name="parent_id">
                <option value="" hidden selected>Chọn danh mục cha</option>
                <?php

                foreach ($category as $key => $value) : ?>
                    <option value="<?php echo $value['category_id']; ?>"><?php echo $value['category_name']; ?></option>
                <?php endforeach; ?>

            </select>
            <?php getErorr('parent_id') ?>
        </div>


        <!-- Banner Image URL -->
        <div class="mb-3">
            <label for="bannerImage" class="form-label">Banner Image URL</label>
            <input type="file" class="form-control" id="bannerImage" name="banner">
            <?php getErorr('banner') ?>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Create Category</button>
        <button type="button" class="btn btn-warning ml-2"><a href="?role=admin&controller=category">Back</a></button>
    </form>
</div>

<style>
    .category-form {
        max-width: 66.67%;
        /* 4/6 của trang */
        margin: auto;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>