<style>
    body {
        background-color: #f8f9fa;
    }

    .form-wrapper {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        margin: 50px auto;
    }

    .form-header {
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        border-radius: 8px 8px 0 0;
        text-align: center;
    }
</style>

<div class="main-content">
    <div class="content-wrapper">
        <?php
        // var_dump($categoryDetail);
        ?>
        <div class="container">
            <div class="form-wrapper">
                <div class="form-header">
                    <h4>Edit category</h4>
                </div>
                <form action="?role=admin&controller=category&action=update&id=<?php echo $categoryDetail['category_id']; ?>" method="post" enctype="multipart/form-data">
                    <!-- Tên Danh Mục -->
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input value="<?php echo $categoryDetail['category_name']; ?>" type="text" class="form-control" id="categoryName" placeholder="Enter category name" name="category_name">
                        <?php getErorr('category_name') ?>
                    </div>
                    <!-- Danh Mục Cha -->
                    <div class="mb-3">
                        <label for="parentCategory" class="form-label">Parent Category</label>
                        <select class="form-select" id="parentCategory" name="parent_id">
                            <?php
                            if ($categoryDetail['parent_id'] != null) echo "<option value=''>NULL</option>";
                            ?>
                            <?php
                            foreach ($category as $key => $value) :
                                if ($categoryDetail['parent_id'] == null) echo "<option value='' hidden selected>Danh mục gốc</option>";
                                if ($categoryDetail['category_id'] == $value['category_id']) continue;
                            ?>
                                <option value="<?php echo $value['category_id']; ?>" <?php echo ($value['category_id'] == $categoryDetail['parent_id']) ? "selected" : ""; ?>><?php echo $value['category_name']; ?></option>
                            <?php endforeach; ?>

                        </select>
                        <?php getErorr('parent_id') ?>
                    </div>

                    <!-- Banner -->
                    <div class="mb-3">
                        <img width="100px" src="uploads/<?php echo $categoryDetail['banner']; ?>" alt="">
                        <label for="banner" class="form-label">Banner Image URL</label>

                        <input type="file" class="form-control" name="banner" id="banner">
                        <?php getErorr('banner') ?>
                    </div>

                    <!-- Nút Submit -->
                    <button type="submit" name="btn-update-category" class="btn btn-primary w-100">Update</button>
                </form>

            </div>
            <a href="?role=admin&controller=category">Quay lại trang danh sách</a>
        </div>

    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>