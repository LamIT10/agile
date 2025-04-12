<?php
$type = $_GET['type'];
?>
<div>
    <form action="?role=admin&controller=user&action=update&type=<?= $type ?>&id=<?= $user['user_id'] ?>" method="post" enctype="multipart/form-data" class="shadow-sm mx-auto mb-5" style="width: 70%; background: #fff; border-radius: 8px; padding: 50px">
        <h6 class="mb-4 font-weight-bold text-primary">Form update <?= $type ?></h6>
        <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập:</label>
            <input type="text" class="form-control" value="<?= $user['username'] ?>" id="username" name="username">
            <p><?php getErorr('username') ?></p>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu:</label>
            <input type="password" hidden class="form-control" disabled value="<?= $user['password'] ?>" id="password" name="password">
            <p><?php getErorr('password') ?></p>
        </div>

        <div class="mb-3">
            <label class="form-label">Chức vụ</label>
            <div class="col-md-12 d-flex gap-5">
                <div class="form-check">
                    <input class="form-check-input" <?= $user['role_id'] == 1 ? 'checked' : '' ?> type="radio" name="role_id" id="roleAdmin" value="1">
                    <label class="form-check-label" for="roleAdmin">Chủ shop</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" <?= $user['role_id'] == 2 ? 'checked' : '' ?> type="radio" name="role_id" id="roleStaff" value="2">
                    <label class="form-check-label" for="roleStaff">Nhân viên</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" <?= $user['role_id'] == 3 ? 'checked' : '' ?> type="radio" name="role_id" id="roleCus" value="3">
                    <label class="form-check-label" for="roleCus">Khách hàng</label>
                </div>
            </div>
            <p><?php getErorr('role_id') ?></p>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ:</label>
            <input type="text" class="form-control" value="<?= $user['address'] ?>" id="address" name="address">
            <p><?php getErorr("address") ?></p>
        </div>

        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Ngày sinh:</label>
            <input type="date" class="form-control" value="<?= $user['date_of_birth'] ?>" id="date_of_birth" name="date_of_birth">
            <p><?php getErorr("date_of_birth") ?></p>
        </div>

        <div class="mb-3">
            <label for="full_name" class="form-label">Họ và tên:</label>
            <input type="text" class="form-control" value="<?= $user['full_name'] ?>" id="full_name" name="full_name">
            <p><?php getErorr("full_name") ?></p>
        </div>

        <div class="mb-3 d-flex gap-5 align-items-center justify-content-between ">
            <div>
                <label for="avatar" class="form-label">Ảnh đại diện:</label>
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                <p><?php getErorr("avatar") ?></p>
            </div>
            <div class="mr-5">
                <img class="rounded border" src="uploads/<?= $user['avatar'] ?>" alt="" width="100px">
            </div>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại:</label>
            <input type="tel" class="form-control" value="<?= $user['phone'] ?>" id="phone" name="phone">
            <p><?php getErorr("phone") ?></p>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="text" class="form-control" value="<?= $user['email'] ?>" id="email" name="email">
            <p><?php getErorr("email") ?></p>
        </div>

        <button type="submit" class="btn btn-primary w-100">Lưu thông tin</button>
    </form>
</div>

<!-- Bootstrap JS (tùy chọn, nếu bạn cần các tính năng JS như modal) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>