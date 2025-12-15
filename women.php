<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 
?>

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="bread"><span><a href="index.php">Home</a></span> / <span>Women</span></p>
            </div>
        </div>
    </div>
</div>

<div class="breadcrumbs-two">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumbs-img" style="background-image: url(assets/images/cover-img-1.jpg);">
                    <h2>Women's</h2>
                </div>
                <div class="menu text-center">
                    <p><a href="#">New Arrivals</a> <a href="#">Best Sellers</a> <a href="#">Extended Widths</a> <a href="#">Sale</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="colorlib-product">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 offset-sm-2 text-center colorlib-heading colorlib-heading-sm">
                <h2>Giày Nữ Thời Trang</h2>
            </div>
        </div>
        
        <div class="row row-pb-md">
            <?php
            // --- LỌC SẢN PHẨM NỮ ---
            // Chỉ lấy những dòng có cột category là 'Women'
            $sql = "SELECT * FROM products WHERE category = 'Women' ORDER BY id DESC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="col-md-3 col-lg-3 mb-4 text-center">
                    <div class="product-entry border">
                        <a href="product-detail.php?id=<?php echo $row['id']; ?>" class="prod-img">
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
                }
            } else {
                echo "<div class='col-12 text-center text-muted'>
                        <p>Hiện chưa có sản phẩm giày nữ nào.</p>
                        <a href='index.php' class='btn btn-primary'>Xem tất cả sản phẩm</a>
                      </div>";
            }
            ?>
        </div>
    </div>
</div>

<div class="colorlib-partner">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 offset-sm-2 text-center colorlib-heading colorlib-heading-sm">
                <h2>Thương hiệu đối tác</h2>
            </div>
        </div>
        <div class="row">
            <div class="col partner-col text-center">
                <img src="assets/images/brand-1.jpg" class="img-fluid" alt="Brand">
            </div>
            <div class="col partner-col text-center">
                <img src="assets/images/brand-2.jpg" class="img-fluid" alt="Brand">
            </div>
            <div class="col partner-col text-center">
                <img src="assets/images/brand-3.jpg" class="img-fluid" alt="Brand">
            </div>
            <div class="col partner-col text-center">
                <img src="assets/images/brand-4.jpg" class="img-fluid" alt="Brand">
            </div>
            <div class="col partner-col text-center">
                <img src="assets/images/brand-5.jpg" class="img-fluid" alt="Brand">
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>