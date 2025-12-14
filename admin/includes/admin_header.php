<?php
// Kết nối Database (Lùi ra 1 cấp để tìm file db.php trong includes)
include $_SERVER['DOCUMENT_ROOT'] . '/web_ban_giay/includes/db.php';

// BẢO VỆ ADMIN: Nếu không phải admin thì đá về trang login
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header('Location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Shop Giày</title>

    <link href="/web_ban_giay/admin/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="/web_ban_giay/admin/assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index_admin.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-shoe-prints"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Shoe Admin</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="index_admin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Tổng Quan</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Quản Lý
            </div>

            <li class="nav-item">
                <a class="nav-link" href="orders.php">
                    <i class="fas fa-fw fa-file-invoice"></i>
                    <span>Đơn Hàng</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="products.php">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Sản Phẩm</span></a>
            </li>
            
             <li class="nav-item">
                <a class="nav-link" href="stats.php">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Báo Cáo</span></a>
            </li>

            <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link text-warning" href="../index.php">
                    <i class="fas fa-home"></i> Xem Shop</a>
                </li>       

            <!-- <li class="nav-item">
                <a class="nav-link" href="../../index.php" target="_blank">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Xem Website</span></a>
            </li> -->

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin'; ?>
                                </span>
                                <img class="img-profile rounded-circle" src="/web_ban_giay/admin/assets/img/undraw_profile.svg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Đăng xuất
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <div class="container-fluid">