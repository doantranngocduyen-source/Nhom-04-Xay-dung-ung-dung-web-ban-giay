<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Nhom-04-Xay-dung-ung-dung-web-ban-giay/includes/db.php';
include 'includes/admin_header.php';

// --- ĐÂY LÀ CHỖ CÓ LỖI ---
// Mục tiêu: Tính TỔNG TIỀN (SUM)
// Thực tế: Đang dùng hàm COUNT (Đếm số dòng)
// Hậu quả: Thay vì hiện "50,000,000 đ", nó sẽ hiện số "5" (nếu có 5 đơn hàng).
$sql_money = "SELECT COUNT(total_money) as total FROM orders"; 
// -------------------------

$res_money = mysqli_query($conn, $sql_money);
$row_money = mysqli_fetch_assoc($res_money);
$total_money = $row_money['total'] ? $row_money['total'] : 0;

// Tổng đơn hàng
$sql_order = "SELECT COUNT(*) as total FROM orders";
$res_order = mysqli_query($conn, $sql_order);
$row_order = mysqli_fetch_assoc($res_order);
$total_order = $row_order['total'];

// Tổng sản phẩm trong kho
$sql_prod = "SELECT COUNT(*) as total FROM products";
$res_prod = mysqli_query($conn, $sql_prod);
$row_prod = mysqli_fetch_assoc($res_prod);
$total_prod = $row_prod['total'];

// Đơn hàng chờ xử lý / Khách hàng
$sql_user = "SELECT COUNT(*) as total FROM users WHERE role=0";
$res_user = mysqli_query($conn, $sql_user);
$row_user = mysqli_fetch_assoc($res_user);
$total_user = $row_user['total'];
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard - Tổng Quan</h1>
</div>

<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Doanh Thu</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($total_money); ?> đ</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Đơn Hàng</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_order; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sản Phẩm</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_prod; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Khách Hàng</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_user; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Chào mừng đến với trang quản trị!</h6>
            </div>
            <div class="card-body">
                <p>Tại đây bạn có thể quản lý toàn bộ hoạt động của cửa hàng: Xem đơn hàng, thêm sửa xóa sản phẩm và xem báo cáo doanh thu.</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>