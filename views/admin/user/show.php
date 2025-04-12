<div class="container py-4">
    <h3 class="mb-4">User Details</h3>
    <div class="row g-4  bg-light p-4 rounded shadow">
        <!-- Avatar -->
        <div class="col-md-3 text-center">
            <img src="uploads/<?= $user['avatar'] ?>" alt="User Avatar" class="rounded-circle img-fluid border border-secondary" style="max-width: 150px;">
        </div>
        <!-- User Information -->
        <div class="col-md-9">
            <div class="row mb-3">
                <div class="col-sm-4"><strong>User ID:</strong></div>
                <div class="col-sm-8"><?= $user['user_id'] ?></div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-sm-4"><strong>Tên dăng nhập:</strong></div>
                <div class="col-sm-8"><?= $user['username'] ?></div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-sm-4"><strong>Họ và tên:</strong></div>
                <div class="col-sm-8"><?= $user['full_name'] ?></div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-sm-4"><strong>Chức vụ:</strong></div>
                <div class="col-sm-8"><?php
                                        if ($user['role_id'] == 1) {
                                            echo 'Chủ shop';
                                        } else if ($user['role_id'] == 2) {
                                            echo 'Nhân viên';
                                        } else {
                                            echo 'Khách hàng';
                                        }
                                        ?></div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-sm-4"><strong>Email:</strong></div>
                <div class="col-sm-8"><?= $user['email'] ?></div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-sm-4"><strong>Số điện thoại:</strong></div>
                <div class="col-sm-8"><?= $user['phone'] ?></div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-sm-4"><strong>Địa chỉ:</strong></div>
                <div class="col-sm-8"><?= $user['address'] ?></div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-sm-4"><strong>Ngày sinh:</strong></div>
                <div class="col-sm-8"><?= $user['date_of_birth'] ?></div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-sm-4"><strong>Trạng thái:</strong></div>
                <span style="width: max-content" class="col-sm-8 p-3 text-white rounded bg-<?= $user['status'] == 1 ? 'success' : 'danger' ?>"><?= $user['status'] == 1 ? 'Active' : 'Inactive' ?></span>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-sm-4"><strong>Ngày tạo:</strong></div>
                <div class="col-sm-8"><?= $user['create_at'] ?></div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-sm-4"><strong>Ngày cập nhật:</strong></div>
                <div class="col-sm-8"><?= $user['update_at'] ?></div>
            </div>
        </div>
        <?php
        if ($user['role_id'] == 3) {
            $view = "customer";
        } else {
            $view = "admin";
        }
        ?>
        <div><a href="?role=admin&controller=user&view=<?= $view ?>" class="btn btn-primary">Về trang danh sách</a></div>
    </div>
</div>