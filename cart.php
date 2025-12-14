<?php 
include 'includes/db.php';
include 'includes/header.php';

// --- PHẦN 1: XỬ LÝ THÊM/XÓA GIỎ HÀNG ---

// 1. Thêm sản phẩm vào giỏ
if (isset($_GET['add_id'])) {
    $id = $_GET['add_id'];
    // Nếu trong giỏ đã có món này rồi thì tăng số lượng lên 1
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        // Nếu chưa có thì set số lượng là 1
        $_SESSION['cart'][$id] = 1;
    }
    // Tải lại trang để xóa thông tin trên thanh địa chỉ (tránh F5 bị thêm lần nữa)
    echo "<script>window.location='cart.php';</script>";
}

// 2. Xóa sản phẩm khỏi giỏ
if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    unset($_SESSION['cart'][$id]);
    echo "<script>window.location='cart.php';</script>";
}
?>

<div class="colorlib-product">
    <div class="container">
        <div class="row row-pb-lg">
            <div class="col-md-10 offset-md-1">
                <div class="process-wrap">
                    <div class="process text-center active">
                        <p><span>01</span></p>
                        <h3>Giỏ hàng</h3>
                    </div>
                    <div class="process text-center">
                        <p><span>02</span></p>
                        <h3>Thanh toán</h3>
                    </div>
                    <div class="process text-center">
                        <p><span>03</span></p>
                        <h3>Hoàn tất</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-pb-lg">
            <div class="col-md-12">
                <div class="product-name d-flex">
                    <div class="one-forth text-left px-4">
                        <span>Sản phẩm</span>
                    </div>
                    <div class="one-eight text-center">
                        <span>Giá</span>
                    </div>
                    <div class="one-eight text-center">
                        <span>Số lượng</span>
                    </div>
                    <div class="one-eight text-center">
                        <span>Tổng</span>
                    </div>
                    <div class="one-eight text-center px-4">
                        <span>Xóa</span>
                    </div>
                </div>

                <?php
                $total_money = 0;
                
                // Kiểm tra giỏ hàng có trống không
                if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                    
                    // Lấy danh sách ID sản phẩm trong giỏ
                    $ids = implode(",", array_keys($_SESSION['cart']));
                    $sql = "SELECT * FROM products WHERE id IN ($ids)";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $qty = $_SESSION['cart'][$row['id']]; // Số lượng khách mua
                        $subtotal = $row['price'] * $qty;      // Thành tiền từng món
                        $total_money += $subtotal;             // Cộng vào tổng tiền
                ?>
                
                <div class="product-cart d-flex">
                    <div class="one-forth">
                        <div class="product-img" style="background-image: url(uploads/<?php echo $row['image']; ?>);">
                        </div>
                        <div class="display-tc">
                            <h3><?php echo $row['name']; ?></h3>
                        </div>
                    </div>
                    <div class="one-eight text-center">
                        <div class="display-tc">
                            <span class="price"><?php echo number_format($row['price']); ?> đ</span>
                        </div>
                    </div>
                    <div class="one-eight text-center">
                        <div class="display-tc">
                            <input type="text" class="form-control input-number text-center" value="<?php echo $qty; ?>" readonly>
                        </div>
                    </div>
                    <div class="one-eight text-center">
                        <div class="display-tc">
                            <span class="price"><?php echo number_format($subtotal); ?> đ</span>
                        </div>
                    </div>
                    <div class="one-eight text-center">
                        <div class="display-tc">
                            <a href="cart.php?del_id=<?php echo $row['id']; ?>" class="closed"></a>
                        </div>
                    </div>
                </div>

                <?php 
                    } // Kết thúc vòng lặp
                } else {
                    // Đã sửa đường dẫn href='index.php'
                    echo "<div class='text-center p-5'><h3>Giỏ hàng đang trống!</h3><a href='index.php' class='btn btn-primary'>Mua sắm ngay</a></div>";
                }
                ?>
            </div>
        </div>
        
        <?php if($total_money > 0): ?>
        <div class="row row-pb-lg">
            <div class="col-md-12">
                <div class="total-wrap">
                    <div class="row">
                        <div class="col-sm-8"></div> <div class="col-sm-4 text-center">
                            <div class="total">
                                <div class="sub">
                                    <p><span>Tạm tính:</span> <span><?php echo number_format($total_money); ?> đ</span></p>
                                </div>
                                <div class="grand-total">
                                    <p><span><strong>Tổng cộng:</strong></span> <span><?php echo number_format($total_money); ?> VNĐ</span></p>
                                </div>
                                <p><a href="checkout.php" class="btn btn-primary">Tiến hành thanh toán</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php include 'includes/footer.php'; ?>