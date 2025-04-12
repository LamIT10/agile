        <style>
            .sidebar {
                transition: 0.5s;
                background-size: contain;
            }
        </style>
        <ul class="navbar-nav sidebar bg-gradient-primary sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    r
                </div>
                <div class="sidebar-brand-text mx-3">ROYAL</div>
            </a>
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="?role=admin">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Trang chủ</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Quản lý danh mục</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="?role=admin&controller=category">Danh sách danh mục</a>
                        <a class="collapse-item" href="?role=admin&controller=category&action=add">Thêm danh mục</a>
                    </div>
                </div>
            </li>
            <?php
            if ($_SESSION['user']['role_id'] == 1) {
            ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBanner"
                        aria-expanded="true" aria-controls="collapseBanner">
                        <i class="fas fa-fw fa-images"></i>
                        <span>Quản lý banner</span>
                    </a>
                    <div id="collapseBanner" class="collapse" aria-labelledby="headingBanner" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="?role=admin&controller=banner">Danh sách banner</a>
                            <a class="collapse-item" href="?role=admin&controller=banner&action=add">Thêm banner</a>
                        </div>
                    </div>
                </li>
            <?php
            }
            ?>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTw"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Quản lý sản phẩm</span>
                </a>
                <div id="collapseTw" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="?role=admin&controller=product">Danh sách sản phẩm</a>
                        <a class="collapse-item" href="?role=admin&controller=product&action=add">Thêm sản phẩm</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseT"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Quản lý người dùng</span>
                </a>
                <div id="collapseT" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="?role=admin&controller=user&view=customer">Danh sách khách hàng</a>
                        <a class="collapse-item" href="?role=admin&controller=user&view=admin">Danh sách quản trị viên</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Quản lý voucher</span>
                </a>
                <div id="collapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="?role=admin&controller=voucher">Danh sách voucher</a>
                        <a class="collapse-item" href="?role=admin&controller=voucher&action=add">Thêm voucher</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?role=admin&controller=comment">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Quản lý bình luận</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?role=admin&controller=order">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Quản lý đơn hàng</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Về trang web</span></a>
            </li>
<hr>


            <hr>
        </ul>
        <!-- End of Sidebar -->