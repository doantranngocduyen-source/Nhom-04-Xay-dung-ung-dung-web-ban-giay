<?php 
// LỖI 1: Sai tên thư mục (Thư mục đúng là 'includes' có chữ 's', ở đây viết thiếu)
// Hậu quả: Web báo lỗi "Warning: include(include/db.php): failed to open stream..."
include 'include/db.php';

// LỖI 2: Sai dấu gạch chéo (Dùng Backslash '\' thay vì Forward slash '/')
// Hậu quả: Chạy trên Windows (XAMPP) có thể vẫn được, nhưng up lên Hosting (Linux) là lỗi ngay lập tức.
include 'includes\header.php';
?>

<div class="colorlib-product">
    <div class="container">
        <div class="row row-pb-lg">
            <div class="col-sm-10 offset-sm-1 text-center">
                
                <p class="icon-addcart"><span><i class="icon-check"></i></span></p>
                <h2 class="mb-4">Đặt hàng thành công!</h2>
                <p>Cảm ơn bạn đã mua hàng. Shop sẽ gọi điện xác nhận đơn hàng sớm nhất.</p>

                <p>
                    <a href="../admin/index.php" class="btn btn-primary btn-outline-primary">Về trang chủ</a>
                </p>

            </div>
        </div>
    </div>
</div>

<?php include 'footer.html'; ?>