<?php 
include 'includes/db.php';
include 'includes/header.php'; 

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Tìm user trong database
    $sql = "SELECT * FROM users WHERE emails = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Kiểm tra mật khẩu (đang so sánh thô cho nhanh, thực tế nên dùng password_verify)
        if ($password == $user['password']) {
            // Lưu thông tin vào Session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['user_role'] = $user['role'];

            // LOGIC PHÂN BIỆT ADMIN / USER
            if ($user['role'] == 1) {
                // LÀ ADMIN: Chuyển thẳng vào trang quản lý đơn hàng
                echo "<script>
                        alert('Xin chào Sếp! Đang vào trang quản lý...'); 
                        window.location='admin/orders.php';
                      </script>";
            } else {
                // LÀ USER: Chuyển về trang chủ mua sắm
                echo "<script>
                        alert('Đăng nhập thành công! Chúc bạn mua sắm vui vẻ.'); 
                        window.location='index.php';
                      </script>";
            }
        } else {
            $error = "Sai mật khẩu!";
        }
    } else {
        $error = "Email không tồn tại!";
    }
}
?>

<div class="colorlib-product">
    <div class="container">
        <div class="row row-pb-lg">
            <div class="col-md-6 offset-md-3">
                <div class="cart-detail text-center">
                    <h2>Đăng Nhập</h2>
                    
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="login" class="btn btn-primary btn-block">Đăng nhập</button>
                        </div>
                    </form>
                    
                    <p class="mt-3">Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>