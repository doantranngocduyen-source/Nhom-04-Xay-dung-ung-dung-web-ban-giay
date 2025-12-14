<?php 
include 'includes/db.php';
include 'includes/header.php';

if (isset($_POST['register'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Lưu ý: Nên mã hóa password_hash() nếu có thời gian

    // Kiểm tra email trùng
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email này đã được sử dụng!";
    } else {
        $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$password')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Đăng ký thành công! Mời đăng nhập.'); window.location='login.php';</script>";
        } else {
            $error = "Lỗi đăng ký: " . mysqli_error($conn);
        }
    }
}
?>

<div class="colorlib-product">
    <div class="container">
        <div class="row row-pb-lg">
            <div class="col-md-6 offset-md-3">
                <div class="cart-detail text-center">
                    <h2>Đăng Ký Tài Khoản</h2>
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-group">
                            <input type="text" name="fullname" class="form-control" placeholder="Họ và tên" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="register" class="btn btn-primary btn-block">Đăng ký</button>
                        </div>
                    </form>
                    <p class="mt-3">Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>