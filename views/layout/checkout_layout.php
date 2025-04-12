<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<style>
    .toas {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        z-index: 1000;
        background-color: #ffffff;
        overflow: hidden;
        animation: slideInOut 7s ease-out forwards;
        border-radius: 0px;
        min-width: 300px;
    }

    @keyframes slideInOut {
        0% {
            opacity: 1;
            transform: translateX(100%);
        }

        5% {
            opacity: 1;
            transform: translateX(0);
        }

        70% {
            opacity: 1;
            transform: translateX(0);
        }

        100% {
            opacity: 0;
            transform: translateX(100%);
        }
    }

    .fa-circle-check,
    .fa-triangle-exclamation {
        margin-right: 15px;
        font-size: 25px;
        border-radius: 4px;
        padding: 5px 7px;
    }

    .fa-circle-check {
        color: green;
        background-color: white;

    }

    .fa-triangle-exclamation {
        color: red;
        background-color: white;
    }

    .line {
        width: 100%;
        height: 5px;
        border-radius: 5px;
    }
</style>

<body>
    <?php
    getToast();
    $final_price = 0;
    if ($totalFinal > 0) {
        if ($totalPrice > 500000) {
            $final_price = $totalFinal;
        } else {
            $final_price = $totalFinal  + 20000;
        }
    } else {
        if ($totalPrice < 500000) {
            $final_price = $totalPrice + 20000;
        } else {
            $final_price = $totalPrice;
        }
    }    ?>
    <div class="container my-5">
        <a class="btn btn-danger" style="position: fixed; top: 20px; left: 20px;" href="?controller=cart">Huỷ thanh toán</a>
        <div class="row">
            <!-- Form bên trái -->
            <div class="col-md-7" style="padding:0 50px 0 70px;">
                <?php
                if (!empty($inforUsedTo)) {
                    echo "<div class='accordion p-3 p-1' style='background-color: #E3EEFF' id='accordionExample'>";
                    echo "<h5 class='mb-3 fs-6 text-primary'>Thông tin bạn đã sử dụng</h5>";
                    foreach ($inforUsedTo as $key => $value) {
                ?>

                        <div class="accordion-item" style="border-radius: 5px">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#col<?= $value['infor_id'] ?>" aria-expanded="false" aria-controls="col<?= $value['infor_id'] ?>">
                                    <?php echo $value['address'] ?>
                                </button>
                            </h2>
                            <div id="col<?= $value['infor_id'] ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body" style="border-bottom:3px solid #CFE2FF">
                                    <div class="mb-2 py-3">
                                        <p><b>Tên người nhận:</b> <?= $value['name'] ?></p>
                                        <p><b>Địa chỉ:</b> <?= $value['address'] ?></p>
                                        <p><b>SĐT người nhận:</b> <?= $value['phone'] ?></p>
                                        <?php
                                        if (isset($_SESSION['inforUsedTo']) && $_SESSION['inforUsedTo']['infor_id'] == $value['infor_id']) {
                                        ?>
                                            <a href="?controller=checkout&action=unUseInforOld&id=<?= $value['infor_id'] ?>" class="btn btn-danger">Bỏ chọn</a>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="?controller=checkout&action=useInforOld&id=<?= $value['infor_id'] ?>" class="btn btn-primary">Dùng thông tin này</a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                    echo "</div>";
                }
                ?>
                <h5 class="mb-3 fs-6 text-primary mt-3">Thông tin người nhận</h5>
                <form method="POST" action="?controller=order&action=store">
                    <!-- Name -->
                    <?php
                    if (!isset($_SESSION['inforUsedTo'])) {
                    ?>
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và tên</label>
                            <input type="text" value="" id="name" name="name" class="form-control" placeholder="Nhập họ và tên">
                            <?php getErorr('name') ?>
                        </div>
                    <?php
                    } else {
                    ?>
                        <p class="mb-3 py-2 px-3 border"><b>Họ và tên người nhận:</b> <?= showInforRecept("name") ?></p>
                    <?php
                    }
                    ?>

                    <!-- Address -->
                    <div class="mb-3">

                        <?php
                        if (!isset($_SESSION['inforUsedTo'])) {
                        ?><label for="address" class="form-label">Địa chỉ</label>
                            <div class="px-4 py-3 border">
                                <div class="mb-3">
                                    <label for="city" class="form-label">Tỉnh/Thành phố</label>
                                    <select id="city" name="city" class="form-select">
                                        <option value="">Chọn tỉnh/thành</option>
                                    </select>
                                    <!-- Hidden input lưu tên -->
                                    <input type="hidden" id="city_name" name="city_name">
                                </div>

                                <div class="mb-3">
                                    <label for="district" class="form-label">Quận/Huyện</label>
                                    <select id="district" name="district" class="form-select">
                                        <option value="">Chọn quận/huyện</option>
                                    </select>
                                    <!-- Hidden input lưu tên -->
                                    <input type="hidden" id="district_name" name="district_name">
                                </div>

                                <div class="mb-3">
                                    <label for="ward" class="form-label">Phường/Xã</label>
                                    <select id="ward" name="ward" class="form-select">
                                        <option value="">Chọn phường/xã</option>
                                    </select>
                                    <!-- Hidden input lưu tên -->
                                    <input type="hidden" id="ward_name" name="ward_name">
                                </div>
                            </div>
                            <?php getErorr('address') ?>
                        <?php
                        } else {
                            $arrAddres = explode(" - ", showInforRecept("address"));
                        ?>
                            <div class="mb-3 py-2 px-3 border">
                                <p><b>Tỉnh/Thành phố:</b> <?= $arrAddres[0] ?></p>
                                <p><b>Quận/Huyện:</b> <?= $arrAddres[1] ?></p>
                                <p><b>Phường/Xã:</b> <?= $arrAddres[2] ?></p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <!-- Phone -->
                    <?php
                    if (!isset($_SESSION['inforUsedTo'])) {
                    ?>
                        <div class=" mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" id="phone" name="phone" value="" class="form-control" placeholder="Nhập số điện thoại">
                            <?php getErorr('phone') ?>
                        </div>
                    <?php
                    } else {
                    ?>
                        <p class="mb-3 py-2 px-3 border"><b>Số điện thoại:</b> <?= showInforRecept("phone") ?></p>
                    <?php
                    }
                    ?>

                    <!-- Payment Method -->
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                        <div>
                            <input class="method" type="radio" name="payment_method" checked value="0" id=""><span style="margin-right: 20px;"> Tiền mặt</span style="margin-right: 20px;">
                            <input class="method" type="radio" name="payment_method" value="1" id="vnpay"> VNPAY
                        </div>
                    </div>
                    <input type="hidden" name="final_price" value="<?= $final_price ?>">

                    <!-- Submit Button -->
                    <button type="submit" id="place-order" class="btn btn-primary w-100">Xác nhận thanh toán khi nhận hàng</button>
                </form>
            </div>

            <!-- Chi tiết đơn hàng bên phải -->
            <div class="col-md-5 px-3 py-5" style="background-color: #F2F5F8;border-left: 1px solid; ">
                <div class="">
                    <!-- Cột Thông tin sản phẩm -->
                    <div class="">
                        <h5 class="mb-4 fs-6">Thông tin sản phẩm</h5>
                        <!-- Sản phẩm 1 -->
                        <?php
                        foreach ($order as $key => $value) {
                        ?>
                            <div class="d-flex mb-3 bg-white p-3 align-items-center">
                                <img style="width: 80px;" src="uploads/<?= $value['image_main'] ?>" class="img-fluid" alt="Product Image">
                                <div class="ms-3">
                                    <h6 class="mb-1"><?= $value['product_name'] ?></h6>
                                    <p class="mb-1 text-secondary small"><?= $value['color_name'] ?>, <?= $value['size_name'] ?></p>
                                    <div class="text-danger fw-bold">
                                        <?php echo number_format($value['sale_price']) . " VNĐ" ?> <del class="text-muted"><?php echo number_format($value['base_price']) . " VNĐ" ?></del>
                                    </div>
                                </div>
                                <div class="ms-auto">x<?= $value['quantity_cart'] ?></div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="bg-white p-3">
                        <h5 class="mb-4 fs-6">Chi tiết thanh toán</h5>
                        <form action="?controller=checkout&action=addVoucher" method="POST" class="d-flex justify-content-between align-items-center p-3 mb-3" style="background-color: #e3eeff;">
                            <div class="text-warning fw-bold">
                                <input type="text" value="<?php if (isset($_SESSION['voucher'])) echo $_SESSION['voucher']['voucher_code']; ?>" class="form-control border-0 rounded-0" name="voucher_code" placeholder="Nhập mã giảm giá" id="">
                            </div>
                            <?php
                            if (!isset($_SESSION['voucher'])) {
                            ?>
                                <button value="btn-add" name="btn-add" class="btn btn-primary btn-sm">Áp mã</button>
                            <?php
                            } else {
                            ?>
                                <button value="btn-unset" name="btn-unset" class="btn btn-danger btn-sm">Huỷ mã</button>
                            <?php
                            }
                            ?>
                        </form>
                        <ul class="list-unstyled">
                            <li class="d-flex justify-content-between py-2 px-3">
                                <span>Tổng giá trị sản phẩm:</span>
                                <span><?= number_format($totalPrice) . " VNĐ" ?></span>
                            </li>
                            <li class="d-flex justify-content-between px-3 py-2">
                                <span>Vận chuyển:</span>
                                <span><?= number_format(20000) . " VNĐ" ?></span>
                            </li>
                            <?php
                            if ($totalPrice > 500000) {
                            ?>
                                <li class="d-flex justify-content-between text-danger px-3 py-2">
                                    <span>Giảm giá vận chuyển:</span>
                                    <span>-20.000 VNĐ</span>
                                </li>
                            <?php
                            }
                            ?>
                            <?php
                            if ($discount > 0) {
                            ?>
                                <li class="d-flex justify-content-between text-danger px-3 py-2">
                                    <span>Giảm giá:</span>
                                    <span>-<?= number_format($discount) . " VNĐ" ?></span>
                                </li>
                            <?php
                            }
                            ?>

                        </ul>
                        <hr>
                        <!-- Tổng thanh toán -->
                        <div class="d-flex justify-content-between fs-5 px-3 py-2">
                            <strong>Tổng thanh toán:</strong>
                            <strong>
                                <?php
                                echo number_format($final_price) . " VNĐ";
                                ?>
                            </strong>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <?php
            if (!empty($_SESSION['error'])) unset($_SESSION['error']);
            ?>
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
    var citis = document.getElementById("city");
    var districts = document.getElementById("district");
    var wards = document.getElementById("ward");
    var Parameter = {
        url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
        method: "GET",
        responseType: "application/json",
    };
    var promise = axios(Parameter);
    promise.then(function(result) {
        renderCity(result.data);
    });

    function renderCity(data) {
        for (const x of data) {
            citis.options[citis.options.length] = new Option(x.Name, x.Id);
        }
        citis.onchange = function() {
            district.length = 1; // Reset quận/huyện
            ward.length = 1; // Reset phường/xã

            document.getElementById("city_name").value = citis.options[citis.selectedIndex].text;

            if (this.value != "") {
                const result = data.filter((n) => n.Id === this.value);

                for (const k of result[0].Districts) {
                    district.options[district.options.length] = new Option(k.Name, k.Id);
                }
            }
        };
        district.onchange = function() {
            ward.length = 1; // Reset phường/xã

            // Gán tên quận/huyện vào hidden input
            document.getElementById("district_name").value = district.options[district.selectedIndex].text;

            const dataCity = data.filter((n) => n.Id === citis.value);
            if (this.value != "") {
                const dataWards = dataCity[0].Districts.filter((n) => n.Id === this.value)[0].Wards;

                for (const w of dataWards) {
                    wards.options[wards.options.length] = new Option(w.Name, w.Id);
                }
            }
        };
        ward.onchange = function() {
            // Gán tên phường/xã vào hidden input
            document.getElementById("ward_name").value = ward.options[ward.selectedIndex].text;
        };
    }
    let payment_method = document.querySelectorAll(".method");
    let place_order = document.getElementById("place-order");
    payment_method.forEach(element => {
        element.addEventListener('click', () => {
            if (element.checked) {
                if (element.value == 0) {
                    place_order.innerHTML = "Xác nhận thanh toán khi nhận hàng";
                } else if (element.value == 1) {
                    place_order.innerHTML = "Thanh toán bằng VNPAY"
                }
            }
        })
    });
</script>