<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Nhom-04-Xay-dung-ung-dung-web-ban-giay/includes/db.php';
include 'includes/admin_header.php';

// BẢO VỆ ADMIN
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    echo "<script>window.location='../login.php';</script>";
    exit();
}

// --- ĐÃ BỎ BỘ LỌC THỜI GIAN ---
// Mặc định là thống kê tất cả
$title_time = "Toàn thời gian";


// 1. TÍNH TỔNG DOANH THU & ĐƠN HÀNG (TẤT CẢ)
$sql_revenue = "SELECT SUM(total_money) as total_money, COUNT(id) as total_orders 
                FROM orders WHERE status = 2"; 
// Lưu ý: Chỉ tính đơn hàng thành công (status = 2)

$res_revenue = mysqli_query($conn, $sql_revenue);
$stat = mysqli_fetch_assoc($res_revenue);
$total_money = $stat['total_money'] ? $stat['total_money'] : 0;
$total_orders = $stat['total_orders'];


// 2. TÌM TOP 5 SẢN PHẨM BÁN CHẠY NHẤT (TỪ TRƯỚC ĐẾN NAY)
$sql_best = "SELECT p.name, p.image, SUM(od.quantity) as total_sold, SUM(od.price * od.quantity) as total_earn
             FROM order_details od
             JOIN products p ON od.product_id = p.id
             JOIN orders o ON od.order_id = o.id
             WHERE o.status = 2
             GROUP BY p.id
             ORDER BY total_sold DESC
             LIMIT 5";
$res_best = mysqli_query($conn, $sql_best);


// 3. TÌM SẢN PHẨM "Ế" (CHƯA TỪNG BÁN ĐƯỢC CÁI NÀO)
$sql_bad = "SELECT * FROM products 
            WHERE id NOT IN (
                SELECT DISTINCT product_id FROM order_details od 
                JOIN orders o ON od.order_id = o.id 
                WHERE o.status = 2
            ) LIMIT 5";
$res_bad = mysqli_query($conn, $sql_bad);
?>

<div class="container-fluid"> 
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">📊 Báo Cáo Thống Kê Tổng Hợp</h1>
    </div>

    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tổng Doanh Thu</div>
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
                                Tổng Số Đơn Hàng Thành Công</div>
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
                    <h6 class="m-0 font-weight-bold text-success">🏆 Top 5 Bán Chạy Nhất (Mọi thời đại)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
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
                    <h6 class="m-0 font-weight-bold text-danger">💤 Sản Phẩm Chưa Từng Bán Được</h6>
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
                                        <td>
                                            <img src="../uploads/<?php echo $row['image']; ?>" width="40" height="40" style="object-fit: cover; border-radius: 5px; border: 1px solid #eee; margin-right: 5px;">
                                            <?php echo $row['name']; ?>
                                        </td>
                                        <td><?php echo number_format($row['price']); ?> đ</td>
                                        <td><span class="badge badge-warning">Tồn kho</span></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="3" class="text-center text-success">Tuyệt vời! Tất cả sản phẩm đều đã có người mua.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div> 
<?php include 'includes/admin_footer.php'; ?>