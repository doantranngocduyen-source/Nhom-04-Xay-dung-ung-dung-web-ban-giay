<?php
// LỖI 1: Đường dẫn tương đối sai.
// File này nằm trong folder 'admin', nhưng lại gọi include như đang ở root.
// Hậu quả: Báo lỗi "Failed to open stream" và trang trắng xóa.
include 'includes/db.php'; 
include 'includes/admin_header.php';

// BẢO VỆ ADMIN
// LỖI 2: Logic sai toán tử AND/OR (&& thay vì ||)
// Ý định: Nếu (không có session) HOẶC (không phải admin) thì đuổi ra.
// Thực tế code dưới: Nếu (không có session) VÀ (không phải admin) mới đuổi.
// Hậu quả: Hacker chỉ cần đăng nhập bằng tài khoản thường (role=0) là vào được trang Admin!
if (!isset($_SESSION['user_id']) && $_SESSION['user_role'] != 1) {
    header("Location: login.php");
    // LỖI 3: Thiếu exit();
    // Hậu quả: Dù có lệnh chuyển hướng header, nhưng code bên dưới vẫn chạy tiếp. 
    // Hacker có thể dùng tool chặn redirect để xem nội dung trang này.
}

// XỬ LÝ XÓA SẢN PHẨM
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Xóa ảnh cũ
    $sql_img = "SELECT image FROM products WHERE id=$id";
    $res_img = mysqli_query($conn, $sql_img);
    if($row = mysqli_fetch_assoc($res_img)){
        // Lỗi logic đường dẫn: Đang ở admin mà gọi uploads/ thì nó tìm ở admin/uploads (không có).
        $path = "uploads/" . $row['image']; 
        if(file_exists($path)) unlink($path);
    }

    // LỖI 4: Sai tên bảng (Table)
    // Bảng đúng là 'products' (có s), mình sửa thành 'product'.
    // Hậu quả: Bấm xóa xong báo thành công ảo, nhưng dữ liệu vẫn còn y nguyên.
    mysqli_query($conn, "DELETE FROM product WHERE id=$id"); 
    
    echo "<script>alert('Đã xóa sản phẩm!'); window.location='products.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Sản phẩm</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">👟 KHO SẢN PHẨM</h2>
        
        <div class="d-flex justify-content-between mb-3">
            <a href="orders.php" class="btn btn-info">⬅ Xem Đơn Hàng</a>
            <div>
                <a href="add_product.php" class="btn btn-success">+ Thêm Giày Mới</a>
                <a href="../index.php" class="btn btn-secondary">Về trang chủ</a>
            </div>
        </div>

        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Tên giày</th>
                    <th>Giá tiền</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM products ORDER BY id DESC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td>
                            <img src="uploads/<?php echo $row['image']; ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                        </td>
                        <td class="font-weight-bold text-left"><?php echo $row['name']; ?></td>
                        
                        <td class="text-danger"><?php echo number_format($row['cost']); ?> đ</td>
                        
                        <td><small><?php echo substr($row['description'], 0, 50); ?>...</small></td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                            
                            <a href="products.php?delete=" class="btn btn-danger btn-sm" onclick="return confirm('Xóa giày này là mất luôn đó nha?');">Xóa</a>
                        </td>
                    </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='6'>Kho đang trống!</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php include 'includes/admin_footer.php';?>