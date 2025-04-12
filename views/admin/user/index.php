<?php
// var_dump($user);
$mode = $_GET['view'];
?>
<style>

</style>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"> <?php echo $title ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style="width: 400px">Họ tên</th>
                            <th>Tên đăng nhập</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Trạng thái</th>
                            <?php
                            if ($_GET['view'] == 'admin') {
                                echo "<th>Chức vụ</th>";
                            }
                            ?>
                            <th>Ảnh đại diện</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user as $key => $item) : ?>
                            <tr class="product">
                                <td><?= $key + 1 ?></td>
                                <td><?= $item['full_name'] ?></td>
                                <td><?= $item['username'] ?></td>
                                <td><?= $item['email'] ?></td>
                                <td><?= $item['phone'] ?></td>
                                <td class="<?php echo $item['status'] == 1 ? 'text-success' : 'text-danger' ?>"><?= $item['status'] == 1 ? 'Active' : 'Inactive' ?> </td>
                                <?php
                                if ($item['role_id'] != 3) {
                                ?>
                                    <td><?php echo $item['role_id'] == 1 ? 'Chủ shop' : 'Nhân viên' ?></td>
                                <?php
                                }
                                ?>
                                <td><?php
                                    echo "<img style='border-radius: 10%;' src='uploads/" . $item['avatar'] . "' width='70px'>";
                                    ?></td>
                                <td class="action-btns d-flex">
                                    <div class="mr-2">
                                        <a href="?role=admin&controller=user&action=edit&type=<?= $mode ?>&id=<?= $item['user_id'] ?>">
                                            <button class="btn btn-info btn-sm">
                                                <i class="fa fa-pencil-alt"></i>
                                            </button>
                                        </a>
                                    </div>

                                    <div class="mr-2">
                                        <a href="?role=admin&controller=user&action=show&id=<?= $item['user_id'] ?>">
                                            <button class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="mr-2">
                                        <a href="?role=admin&controller=user&action=changeStatus&type=<?= $mode ?>&id=<?= $item['user_id'] ?>&status=<?= $item['status'] ?>">
                                            <button class="btn btn-secondary btn-sm">
                                                <?php echo $item['status'] == 1 ? 'disable' : 'enable' ?>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="pagination" class="d-flex justify-content-end align-items-center"></div>
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