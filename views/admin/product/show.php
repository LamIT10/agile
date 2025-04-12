<?php
echo "<pre>";
$variant = $list;
// $imageString = $variant[1]['image_urls'];

// $imageArray = explode(",", $imageString);
// var_dump($variant);
// var_dump($imageArray);
echo "</pre>";
?>
<?php
// var_dump($product['image_main']);
// echo "<br>";
// echo "<br>";
// var_dump($category);
?>
<div class="container-fluid">

    <?php
    if (isset($_SESSION['success'])) {
        if ($_SESSION['success']) {
    ?>
            <div class="notification alert px-5" style="box-shadow: 2px 2px green; color: green;border:1px solid green">
                <i class="fa-solid fa-circle-check"></i><?php echo $_SESSION['message']; ?>
            </div>
        <?php
        } else {
        ?>
            <div class="notification alert px-5" style="box-shadow: 2px 2px red; color: #940000; border:1px solid red">
                <i class="fa-solid fa-triangle-exclamation"></i><?php echo $_SESSION['message']; ?>
            </div>
    <?php
        }
        unset($_SESSION['success'], $_SESSION['message']);
    }

    ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách biến thể của sản phẩm</h6>
            <a class="btn btn-primary" href="?role=admin&controller=product&action=addVariant&id=<?= $_GET['id'] ?>">Thêm biến thể</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Thứ tự</th>
                            <th>Ảnh chỉnh</th>
                            <th>Ảnh phụ</th>
                            <th>Giá gốc</th>
                            <th>Giá</th>
                            <th>Màu</th>
                            <th>Kích thước</th>
                            <th>Số lượng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($variant as $key => $item) :
                            $imageArray = explode(",", $item['image_urls']);
                        ?>

                            <tr class="product">
                                <td><?= $key + 1 ?></td>
                                <td><span><img class="mb-2 mr-2 rounded border" src="uploads/<?= $item['image_main'] ?>" width="90px"></span></td>
                                <td><?php
                                    foreach ($imageArray as $key => $image) {
                                        echo "<span><img  class='mb-2 mr-2 rounded border' src='uploads/" . $image . "' width='60px'></span>";
                                    }
                                    ?></td>
                                <td><?= number_format($item['base_price']) ?></td>
                                <td><?= number_format($item['sale_price']) ?></td>
                                <td><?= $item['color_name'] ?></td>
                                <td><?= $item['size_name'] ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td class="action-btns d-flex flex-row gap-2">
                                    <a class="mr-2" href="?role=admin&controller=product&action=editVariant&id=<?= $item['variant_id'] ?>&product_id=<?= $_GET['id'] ?>">
                                        <button class="btn btn-info btn-sm">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                    </a>
                                    <?php
                                    if ($_SESSION['user']['role_id'] == 1) {
                                    ?>
                                <td>
                                    <a onclick="return confirm('Bạn có chắc chắn không?')" href="?role=admin&controller=product&action=deleteVariant&id=<?= $item['variant_id'] ?>&product_id=<?= $_GET['id'] ?>">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a>
                                </td>
                            <?php
                                    }
                            ?>

                            </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="pagination" class="float-right"></div>
            </div>
        </div>
    </div>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const products = document.querySelectorAll(".product");
        const itemsPerPage = 5;
        const totalPages = Math.ceil(products.length / itemsPerPage);
        const paginationContainer = document.getElementById("pagination");
        let currentPage = 1;

        function showPage(page) {
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            products.forEach((product, index) => {
                product.style.display = index >= start && index < end ? "table-row" : "none";
            });
        }

        function renderPagination() {
            paginationContainer.innerHTML = "";
            if (currentPage > 1) {
                const prevButton = document.createElement("button");
                prevButton.classList.add("btn", "border-primary", "text-primary", "m-1");
                prevButton.textContent = "←";
                prevButton.onclick = function() {
                    currentPage--;
                    updatePagination();
                };
                paginationContainer.appendChild(prevButton);
            }
            const currentButton = document.createElement("button");
            currentButton.classList.add("btn", "btn-primary", "m-1");
            currentButton.textContent = currentPage;
            currentButton.disabled = true;
            paginationContainer.appendChild(currentButton);

            if (currentPage < totalPages) {
                const nextButton = document.createElement("button");
                nextButton.classList.add("btn", "border-primary", "text-primary", "m-1");
                nextButton.textContent = "→";
                nextButton.onclick = function() {
                    currentPage++;
                    updatePagination();
                };
                paginationContainer.appendChild(nextButton);
            }
        }

        function updatePagination() {
            showPage(currentPage);
            renderPagination();
        }

        updatePagination();
    });
</script>