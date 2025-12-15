<?php 
include 'includes/db.php';
include 'includes/header.php'; 

// KICK RA NGOÀI NẾU GIỎ HÀNG TRỐNG
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<script>alert('Giỏ hàng đang trống!'); window.location='../index.php';</script>";
}

// --- XỬ LÝ KHI BẤM NÚT "ĐẶT HÀNG" ---
if (isset($_POST['btn_submit'])) {
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $note = ""; // Có thể thêm trường ghi chú nếu muốn

    // 1. Tính tổng tiền lại lần cuối để lưu vào DB
    $total_money = 0;
    $ids = implode(",", array_keys($_SESSION['cart']));
    $sql_prod = "SELECT * FROM products WHERE id IN ($ids)";
    $result_prod = mysqli_query($conn, $sql_prod);
    
    // Mảng tạm để lưu giá sản phẩm đỡ phải query lại
    $cart_data = []; 
    while ($row = mysqli_fetch_assoc($result_prod)) {
        $cart_data[$row['id']] = $row;
        $total_money += $row['price'] * $_SESSION['cart'][$row['id']];
    }

    // 2. Lưu vào bảng ORDERS
    // Lấy phương thức thanh toán từ form
    $payment_method = $_POST['payment_method']; 

    // Sửa câu lệnh SQL thêm cột payment_method
    $sql_order = "INSERT INTO orders (fullname, address, phone, email, total_money, payment_method, created_at) 
                  VALUES ('$fullname', '$address', '$phone', '$email', '$total_money', '$payment_method', NOW())";
    
    if (mysqli_query($conn, $sql_order)) {
        $order_id = mysqli_insert_id($conn); // Lấy ID đơn hàng vừa tạo

        // 3. Lưu chi tiết vào bảng ORDER_DETAILS
        foreach ($_SESSION['cart'] as $prod_id => $qty) {
            $price = $cart_data[$prod_id]['price'];
            $sql_detail = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                           VALUES ('$order_id', '$prod_id', '$qty', '$price')";
            mysqli_query($conn, $sql_detail);
        }

        // 4. Xóa giỏ hàng và chuyển sang trang cảm ơn
        // QUAN TRỌNG: Gửi kèm order_id sang trang cảm ơn để hiện mã QR
        unset($_SESSION['cart']);
        echo "<script>window.location='thankyou.php?order_id=$order_id';</script>";
    } else {
        echo "Lỗi đặt hàng: " . mysqli_error($conn);
    }
}
?>

<div class="colorlib-product">
    <div class="container">
        <form method="post" class="colorlib-form">
            <div class="row row-pb-lg">
                <div class="col-lg-8">
                    <h2>Thông tin thanh toán</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="fullname">Họ và tên</label>
                                <input type="text" name="fullname" class="form-control" placeholder="Nhập họ tên đầy đủ" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Địa chỉ nhận hàng</label>
                                <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ nhận hàng" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email (Tùy chọn)</label>
                                <input type="text" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
    <div class="cart-detail">
        <h2>Tổng đơn hàng</h2>
        
        <?php
        $display_total = 0;
        // Lấy dữ liệu từ giỏ hàng để tính toán
        if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){
            $ids = implode(",", array_keys($_SESSION['cart']));
            $sql_display = "SELECT * FROM products WHERE id IN ($ids)";
            $res_display = mysqli_query($conn, $sql_display);
            while($r = mysqli_fetch_assoc($res_display)){
                $display_total += $r['price'] * $_SESSION['cart'][$r['id']];
            }
        }
        ?>
        <ul>
            <li>
                <span>Tạm tính</span> 
                <span><?php echo number_format($display_total); ?> đ</span>
            </li>
            <li>
                <span>Phí ship</span> 
                <span>0 đ</span> </li>
            <li>
                <span><strong>Tổng cộng</strong></span> 
                <span style="font-size: 18px; color: red; white-space: nowrap;">
                    <strong><?php echo number_format($display_total); ?> VNĐ</strong>
                </span>            
            </li>
        </ul>

        <hr>

        <div class="form-group mt-4">
            <label style="font-weight: bold;">Hình thức thanh toán:</label>
            <div class="radio">
               <label><input type="radio" name="payment_method" value="COD" checked> Thanh toán khi nhận (COD)</label>
            </div>
            <div class="radio">
               <label><input type="radio" name="payment_method" value="BANK"> Chuyển khoản (QR Code)</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center">
            <br>
            <button type="submit" name="btn_submit" class="btn btn-primary btn-lg btn-block">ĐẶT HÀNG NGAY</button>
        </div>
    </div>
</div>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>