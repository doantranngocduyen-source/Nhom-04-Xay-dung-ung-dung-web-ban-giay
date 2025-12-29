<?php
include $_SERVER['DOCUMENT_ROOT'] . '/web_ban_giay/includes/db.php';
include 'includes/admin_header.php';

// Kiểm tra ID đơn hàng
if (!isset($_GET['id'])) {
    echo "<script>window.location='orders.php';</script>";
    exit();
}
$order_id = intval($_GET['id']);

// Lấy thông tin người mua
$sql_order = "SELECT * FROM orders WHERE id = $order_id";
$result_order = mysqli_query($conn, $sql_order);
$order = mysqli_fetch_assoc($result_order);

// Lấy danh sách sản phẩm họ mua (Kết nối bảng order_details và products)
$sql_details = "SELECT d.*, p.name, p.image 
                FROM order_details d 
                JOIN products p ON d.product_id = p.id 
                WHERE d.order_id = $order_id";
$result_details = mysqli_query($conn, $sql_details);
?>

<div class="container-fluid">
    <a href="orders.php" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Quay lại danh sách</a>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chi tiết đơn hàng #<?php echo $order['id']; ?></h6>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="font-weight-bold text-dark">Thông tin khách hàng:</h5>
                    <p><strong>Họ tên:</strong> <?php echo $order['fullname']; ?></p>
                    <p><strong>Số điện thoại:</strong> <?php echo $order['phone']; ?></p>
                    <p><strong>Địa chỉ:</strong> <?php echo $order['address']; ?></p>
                    <p><strong>Ngày đặt:</strong> <?php echo date("d/m/Y H:i", strtotime($order['created_at'])); ?></p>
                </div>
                <div class="col-md-6 text-right">
                    <h5 class="font-weight-bold text-dark">Trạng thái:</h5>
                    <?php 
                        if($order['status'] == 0) echo '<span class="badge badge-warning" style="font-size: 1rem;">Chờ xử lý</span>';
                        elseif($order['status'] == 1) echo '<span class="badge badge-primary" style="font-size: 1rem;">Đang giao hàng</span>';
                        elseif($order['status'] == 2) echo '<span class="badge badge-success" style="font-size: 1rem;">Đã giao thành công</span>';
                        else echo '<span class="badge badge-danger" style="font-size: 1rem;">Đã hủy</span>';
                    ?>
                </div>
            </div>

            <h5 class="font-weight-bold text-dark">Sản phẩm đã đặt:</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        while ($item = mysqli_fetch_assoc($result_details)) { 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td><img src="../uploads/<?php echo $item['image']; ?>" width="80" style="border-radius: 5px;"></td>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo number_format($item['price']); ?> đ</td>
                            <td class="text-center font-weight-bold"><?php echo $item['quantity']; ?></td>
                            <td class="font-weight-bold"><?php echo number_format($subtotal); ?> đ</td>
                        </tr>
                        <?php } ?>
                        
                        <tr class="bg-light">
                            <td colspan="4" class="text-right font-weight-bold text-primary" style="font-size: 1.2rem;">TỔNG THANH TOÁN:</td>
                            <td class="font-weight-bold text-danger" style="font-size: 1.2rem;"><?php echo number_format($total); ?> đ</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-right mt-3">
                <button onclick="window.print()" class="btn btn-info"><i class="fas fa-print"></i> In hóa đơn</button>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>