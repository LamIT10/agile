<?php
// var_dump($list);
?>
<div class="container my-5">
    <div class="row">
        <form action="?role=admin&action=product" method="post" class="p-3 border rounded shadow-sm w-100 col-md-4 p-3" style="max-width: 300px;background-color: #fff;max-height:max-content;margin-right: 25px">
            <div class="mb-3">
                <label for="startDate" class="form-label">Ngày bắt đầu</label>
                <input type="date" class="form-control" id="startDate" name="start">
            </div>
            <div class="mb-3">
                <label for="endDate" class="form-label">Ngày kết thúc</label>
                <input type="date" class="form-control" id="endDate" name="end">
            </div>
            <button type="submit" class="btn btn-primary w-100">Xem thống kê</button>
        </form>
        <div class="row col-md-8 p-3 border rounded shadow-sm" style="background-color: #fff;">
            <div class="col-md-12">
                <h5 class="mb-4 fw-bold text-primary">Top 5 Sản Phẩm Bán Chạy Nhất</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Mã</th>
                            <th scope="col">Tên Sản Phẩm</th>
                            <th scope="col">Số Lượng Bán</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sản phẩm 1 -->
                        <?php
                        foreach ($list as $key => $value) {
                        ?>
                            <tr>
                                <th scope="row">ROYAL-<?= $value['product_id'] ?></th>
                                <td><?= $value['product_name'] ?></td>
                                <td><?= $value['totalQuantity'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>