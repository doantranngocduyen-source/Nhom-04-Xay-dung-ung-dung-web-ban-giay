<?php 
include 'includes/db.php';
include 'includes/header.php';

// Lấy thông tin đơn hàng
if(isset($_GET['order_id'])){
    $order_id = $_GET['order_id'];
    
    // 1. Lấy thông tin người mua và tổng tiền
    $sql = "SELECT * FROM orders WHERE id = $order_id";
    $result = mysqli_query($conn, $sql);
    $order = mysqli_fetch_assoc($result);

    // 2. Lấy tên đôi giày đầu tiên trong đơn hàng này để làm nội dung CK
    $sql_prod = "SELECT p.name 
                 FROM order_details od 
                 JOIN products p ON od.product_id = p.id 
                 WHERE od.order_id = $order_id 
                 LIMIT 1";
    $result_prod = mysqli_query($conn, $sql_prod);
    $prod = mysqli_fetch_assoc($result_prod);

    // Tạo nội dung chuyển khoản: "CK [Tên Giày]"
    // (Dùng hàm urlencode để xử lý khoảng trắng cho mã QR không bị lỗi)
    $shoe_name = isset($prod['name']) ? $prod['name'] : 'GIAY';
    
    // Nếu tên dài quá thì cắt bớt cho đẹp mã QR
    if(strlen($shoe_name) > 20) {
        $shoe_name = substr($shoe_name, 0, 20) . "...";
    }

    $noi_dung_ck = "CK " . $shoe_name;
    $noi_dung_ck_encoded = urlencode($noi_dung_ck);
}
?>

<div class="colorlib-product">
    <div class="container">
        <div class="row row-pb-lg">
            <div class="col-sm-10 offset-sm-1 text-center">
                
                <?php if(isset($order) && strtoupper(trim($order['payment_method'])) == 'BANK'): ?>
                    
                    <p class="icon-addcart"><span><i class="icon-credit-card"></i></span></p>
                    <h2 class="mb-4">QUÉT MÃ QR ĐỂ THANH TOÁN</h2>
                    <h4 class="text-primary">Tổng tiền: <?php echo number_format($order['total_money']); ?> VNĐ</h4>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card shadow p-3 mb-5 bg-white rounded" style="border: 1px solid #ddd;">
                                <img src="https://img.vietqr.io/image/MBBank-0000000000-compact.jpg?amount=<?php echo $order['total_money']; ?>&addInfo=<?php echo $noi_dung_ck_encoded; ?>" 
                                     class="img-fluid" alt="QR Code">
                                
                                <p class="mt-3">Nội dung CK: <strong><?php echo $noi_dung_ck; ?></strong></p>
                                <p class="text-danger small">* Vui lòng nhập đúng nội dung chuyển khoản.</p>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    
                    <p class="icon-addcart"><span><i class="icon-check"></i></span></p>
                    <h2 class="mb-4">Đặt hàng thành công!</h2>
                    <p>Cảm ơn bạn đã mua hàng. Shop sẽ gọi điện xác nhận đơn hàng sớm nhất.</p>
                    
                <?php endif; ?>

                <p>
                    <a href="index.php" class="btn btn-primary btn-outline-primary">Về trang chủ</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>