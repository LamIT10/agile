<?php
$type = $_GET['type'];
?>
<div>
    <form action="?role=admin&controller=user&action=store&type=<?= $type ?>" method="post" enctype="multipart/form-data" class="shadow-sm mx-auto mb-5" style="width: 70%; background: #fff; border-radius: 8px; padding: 50px">
        <h6 class="mb-4 font-weight-bold text-primary">Form add <?= $type ?></h6>
        <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập:</label>
            <input type="text" class="form-control" <?php getData('username') ?> id="username" name="username">
            <p><?php getErorr('username') ?></p>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu:</label>
            <input type="password" class="form-control" <?php getData('password') ?> id="password" name="password">
            <p><?php getErorr('password') ?></p>
        </div>

        <?php
        if ($type == 'admin') {
        ?>
            <div class="mb-3">
                <label class="form-label">Quyền Admin</label>
                <div class="col-md-4 d-flex gap-5">

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role_id" id="roleAdmin" value="1">
                        <label class="form-check-label" for="roleAdmin">Owner</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role_id" id="roleStaff" value="2">
                        <label class="form-check-label" for="roleStaff">Staff</label>
                    </div>
                </div>
                <p><?php getErorr('role_id') ?></p>
            </div>
        <?php
        }
        ?>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ:</label>
            <input type="text" class="form-control" <?php getData('address') ?> id="address" name="address">
            <p><?php getErorr("address") ?></p>
        </div>

        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Ngày sinh:</label>
            <input type="date" class="form-control" <?php getData('date_of_birth') ?> id="date_of_birth" name="date_of_birth">
            <p><?php getErorr("date_of_birth") ?></p>
        </div>

        <div class="mb-3">
            <label for="full_name" class="form-label">Họ và tên:</label>
            <input type="text" class="form-control" <?php getData('full_name') ?> id="full_name" name="full_name">
            <p><?php getErorr("full_name") ?></p>
        </div>

        <div class="mb-3">
            <label for="avatar" class="form-label">Ảnh đại diện:</label>
            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
            <p><?php getErorr("avatar") ?></p>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại:</label>
            <input type="tel" class="form-control" <?php getData('phone') ?> id="phone" name="phone">
            <p><?php getErorr("phone") ?></p>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="text" class="form-control" <?php getData('email') ?> id="email" name="email">
            <p><?php getErorr("email") ?></p>
        </div>

        <button type="submit" class="btn btn-primary w-100">Lưu thông tin</button>
    </form>
</div>

<!-- Bootstrap JS (tùy chọn, nếu bạn cần các tính năng JS như modal) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>