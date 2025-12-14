<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 

// 1. LẤY TỪ KHÓA TỪ THANH TÌM KIẾM
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
?>

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="bread"><span><a href="index.php">Trang chủ</a></span> / <span>Tìm kiếm</span></p>
            </div>
        </div>
    </div>
</div>

<div class="colorlib-product">
    <div class="container">
        
        <div class="row">
            <div class="col-sm-8 offset-sm-2 text-center colorlib-heading">
                <?php if($keyword): ?>
                    <h2>Kết quả tìm kiếm cho: "<span class="text-primary"><?php echo htmlspecialchars($keyword); ?></span>"</h2>
                <?php else: ?>
                    <h2>Bạn chưa nhập từ khóa nào</h2>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="row row-pb-md">
            <?php
            if ($keyword) {
                $safe_keyword = mysqli_real_escape_string($conn, $keyword);
                
                // LỖI 1: Thiếu dấu nháy đơn '' bao quanh chuỗi tìm kiếm trong SQL
                // Hậu quả: Nếu tìm chữ (vd: Nike) sẽ báo lỗi SQL Syntax. Nếu tìm số thì may ra chạy được.
                $sql = "SELECT * FROM products WHERE name LIKE %$safe_keyword% ORDER BY id DESC"; 
                
                $result = mysqli_query($conn, $sql);

                // Nếu câu lệnh SQL trên lỗi, dòng này sẽ warning vì $result là false
                if(mysqli_num_rows($result) > 0){
                    
                    // LỖI 2: "Ăn mất" dòng đầu tiên
                    // Dòng dưới đây lấy ra sản phẩm đầu tiên nhưng KHÔNG in ra (vì chưa vào vòng lặp).
                    // Hậu quả: Tìm thấy 5 đôi giày nhưng chỉ hiện 4 đôi (mất đôi mới nhất).
                    $check_row = mysqli_fetch_assoc($result); 

                    while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="col-lg-3 mb-4 text-center">
                    <div class="product-entry border">
                        <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="prod-img">
                            
                            <img src="uploads/<?php echo $row['image']; ?>" class="img-fluid" alt="<?php echo $row['name']; ?>" style="height: 200px; object-fit: cover;">
                        </a>
                        <div class="desc">
                            <h2><a href="product-detail.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></h2>
                            <span class="price"><?php echo number_format($row['price']); ?> VNĐ</span>
                            <p>
                                <a href="cart.php?add_id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Thêm vào giỏ</a>
                            </p>
                        </div>
                    </div>
                </div>
            <?php 
                    } // Kết thúc while
                } else {
                    echo "<div class='col-12 text-center'>
                            <h3 class='text-muted'>Rất tiếc, không tìm thấy sản phẩm nào!</h3>
                            <a href='index.php' class='btn btn-primary'>Về trang chủ</a>
                          </div>";
                }
            } else {
                echo "<div class='col-12 text-center'><p>Vui lòng nhập tên sản phẩm vào ô tìm kiếm ở trên.</p></div>";
            }
            ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>