<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Nhom-04-Xay-dung-ung-dung-web-ban-giay/includes/db.php';
include 'includes/admin_header.php';

// BẢO VỆ
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header("Location: login.php"); exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    
    // Nếu có chọn ảnh mới
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        
        // Cập nhật cả ảnh
        $sql_update = "UPDATE products SET name='$name', price='$price', image='$image', description='$desc' WHERE id=$id";
    } else {
        // Giữ nguyên ảnh cũ
        $sql_update = "UPDATE products SET name='$name', price='$price', description='$desc' WHERE id=$id";
    }

    mysqli_query($conn, $sql_update);
    echo "<script>alert('Đã sửa xong!'); window.location='products.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>.container{max-width: 600px; margin-top: 30px;}</style>
</head>
<body>
    <div class="container">
        <h3 class="text-center">✏️ Sửa Thông Tin Giày</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Tên giày:</label>
                <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Giá tiền:</label>
                <input type="number" name="price" class="form-control" value="<?php echo $row['price']; ?>" required>
            </div>
            <div class="form-group">
                <label>Ảnh hiện tại:</label><br>
                <img src="../uploads/<?php echo $row['image']; ?>" style="width: 100px;">
                <input type="file" name="image" class="form-control mt-2">
                <small class="text-muted">Không chọn nếu muốn giữ ảnh cũ</small>
            </div>
            <div class="form-group">
                <label>Mô tả:</label>
                <textarea name="description" class="form-control" rows="4"><?php echo $row['description']; ?></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-warning btn-block">CẬP NHẬT</button>
            <a href="products.php" class="btn btn-secondary btn-block">Hủy</a>
        </form>
    </div>
</body>
</html>
<?php include 'includes/admin_footer.php'; ?>