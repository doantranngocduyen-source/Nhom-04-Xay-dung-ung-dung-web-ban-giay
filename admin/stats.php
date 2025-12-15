<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Nhom-04-Xay-dung-ung-dung-web-ban-giay/includes/db.php';
include 'includes/admin_header.php';

// BẢO VỆ ADMIN
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    echo "<script>window.location='../login.php';</script>";
    exit();
}

// 1. XỬ LÝ LỌC THỜI GIAN
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'this_month';
$where_sql = "";
$title_time = "Tháng này";

switch ($filter) {
    case 'this_month':
        $where_sql = "AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
        $title_time = "Tháng " . date('m/Y');
        break;
        
    case 'last_month':
        // Lùi lại 1 tháng so với hiện tại
        $where_sql = "AND MONTH(created_at) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) 
                      AND YEAR(created_at) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)";
        $title_time = "Tháng trước";
        break;

    case 'this_year':
        $where_sql = "AND YEAR(created_at) = YEAR(CURRENT_DATE())";
        $title_time = "Năm nay (" . date('Y') . ")";
        break;

    case 'last_year':
        $where_sql = "AND YEAR(created_at) = YEAR(CURRENT_DATE()) - 1";
        $title_time = "Năm ngoái (" . (date('Y') - 1) . ")";
        break;

    case 'all':
        $where_sql = "";
        $title_time = "Toàn thời gian";
        break;
}

// 2. TÍNH TỔNG DOANH THU & ĐƠN HÀNG
$sql_revenue = "SELECT SUM(total_money) as total_money, COUNT(id) as total_orders 
                FROM orders WHERE status = 2 $where_sql"; 
// Lưu ý: Thường chỉ tính doanh thu cho đơn hàng thành công (status = 2). 
// Nếu bạn muốn tính cả đơn đang giao thì bỏ 'status = 2' đi nhé.

$res_revenue = mysqli_query($conn, $sql_revenue);
$stat = mysqli_fetch_assoc($res_revenue);
$total_money = $stat['total_money'] ? $stat['total_money'] : 0;
$total_orders = $stat['total_orders'];

// 3. TÌM TOP 5 SẢN PHẨM BÁN CHẠY
$sql_best = "SELECT p.name, p.image, SUM(od.quantity) as total_sold, SUM(od.price * od.quantity) as total_earn
             FROM order_details od
             JOIN products p ON od.product_id = p.id
             JOIN orders o ON od.order_id = o.id
             WHERE o.status = 2 $where_sql
             GROUP BY p.id
             ORDER BY total_sold DESC
             LIMIT 5";
$res_best = mysqli_query($conn, $sql_best);

// 4. TÌM SẢN PHẨM "Ế" (CHƯA BÁN ĐƯỢC CÁI NÀO TRONG THỜI GIAN LỌC)
$sql_bad = "SELECT * FROM products 
            WHERE id NOT IN (
                SELECT DISTINCT product_id FROM order_details od 
                JOIN orders o ON od.order_id = o.id 
                WHERE 1=1 $where_sql
            ) LIMIT 5";
$res_bad = mysqli_query($conn, $sql_bad);
?>

<div class="container-fluid"> <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">📊 Báo Cáo Thống Kê</h1>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="btn-group" role="group">
                <a href="?filter=this_month" class="btn <?php echo ($filter=='this_month')?'btn-primary':'btn-light'; ?>">Tháng này</a>
                <a href="?filter=last_month" class="btn <?php echo ($filter=='last_month')?'btn-primary':'btn-light'; ?>">Tháng trước</a>
                <a href="?filter=this_year" class="btn <?php echo ($filter=='this_year')?'btn-primary':'btn-light'; ?>">Năm nay</a>
                <a href="?filter=last_year" class="btn <?php echo ($filter=='last_year')?'btn-primary':'btn-light'; ?>">Năm ngoái</a>
                <a href="?filter=all" class="btn <?php echo ($filter=='all')?'btn-primary':'btn-light'; ?>">Tất cả</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Doanh Thu (<?php echo $title_time; ?>)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($total_money); ?> VNĐ
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Đơn Hàng Thành Công (<?php echo $title_time; ?>)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo $total_orders; ?> đơn
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">🏆 Top 5 Bán Chạy Nhất</h6>
                </div>
                <div class="card-body"><div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Đã bán</th>
                                    <th>Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($res_best) > 0): ?>
                                    <?php while($row = mysqli_fetch_assoc($res_best)): ?>
                                    <tr>
                                        <td>
                                            <img src="../uploads/<?php echo $row['image']; ?>" width="40" height="40" style="object-fit: cover; border-radius: 5px; border: 1px solid #eee; margin-right: 5px;">
                                            <?php echo $row['name']; ?>
                                        </td>
                                        <td class="font-weight-bold text-center text-success"><?php echo $row['total_sold']; ?></td>
                                        <td><?php echo number_format($row['total_earn']); ?> đ</td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" class="text-center">Chưa có dữ liệu...</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">💤 Sản Phẩm Chưa Bán Được (Tồn kho)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá bán</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($res_bad) > 0): ?>
                                    <?php while($row = mysqli_fetch_assoc($res_bad)): ?>
                                    <tr>
                                        <td><img src="../uploads/<?php echo $row['image']; ?>" width="40" height="40" style="object-fit: cover; border-radius: 5px; border: 1px solid #eee; margin-right: 5px;">
                                            <?php echo $row['name']; ?>
                                        </td>
                                        <td><?php echo number_format($row['price']); ?> đ</td>
                                        <td><span class="badge badge-warning">Ế ẩm</span></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" class="text-center text-success">Tuyệt vời! Tất cả sản phẩm đều đã bán được.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
