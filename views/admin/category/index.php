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
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Quản lý danh mục sản phẩm</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên danh mục</th>
                        <th>Parent Id</th>
                        <th>Trạng thái</th>
                        <th>Banner</th>
                        <th colspan="4">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($category as $key => $item) : ?>

                        <tr class="product">
                            <td><?= $key + 1 ?></td>
                            <td><?= $item['category_name'] ?></td>
                            <td><?= $item['parent_id'] ? $item['parent_id'] : 'Root' ?></td>

                            <td class="<?php echo $item['status'] == 1 ? 'text-success' : 'text-danger' ?>"><?= $item['status'] == 1 ? 'Active' : 'Inactive' ?> </td>
                            <td><?php
                                echo ($item['banner']) ? " <img src='uploads/" . $item['banner'] . "' width='100px'>" : 'Empty';
                                ?></td>
                            <td class="action-btns">
                                <a href="?role=admin&controller=category&action=edit&id=<?= $item['category_id'] ?>">
                                    <button class="btn btn-info btn-sm">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </a>

                            </td>
                            <td>
                                <a href="?role=admin&controller=category&action=show&id=<?= $item['category_id'] ?>">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </a>
                            </td>
                            <?php
                            if ($_SESSION['user']['role_id'] == 1) {
                            ?>
                                <td>
                                    <a onclick="return confirm('Các danh mục con của danh mục này cũng sẽ bị xoá, bạn có chắc chắn không?')" href="?role=admin&controller=category&action=delete&id=<?= $item['category_id'] ?>">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <a href="?role=admin&controller=category&action=changeStatus&id=<?= $item['category_id'] ?>&status=<?= $item['status'] ?>">
                                        <button class="btn btn-secondary btn-sm">
                                            <i class="fa fa-ban"></i> <?php echo $item['status'] == 1 ? 'disable' : 'enable' ?>
                                        </button>
                                    </a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div id="pagination" class="float-right"></div>
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