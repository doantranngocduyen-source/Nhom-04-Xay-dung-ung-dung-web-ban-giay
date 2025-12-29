<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 
?>

<aside id="colorlib-hero">
    <div class="flexslider">
        <ul class="slides">
           <li style="background-image: url(assets/images/img_bg_1.jpg);">
               <div class="overlay"></div>
               <div class="container-fluid">
                   <div class="row">
                       <div class="col-sm-6 offset-sm-3 text-center slider-text">
                           <div class="slider-text-inner">
                               <div class="desc">
                                   <h1 class="head-1">Men's</h1>
                                   <h2 class="head-2">Shoes</h2>
                                   <h2 class="head-3">Collection</h2>
                                   <p class="category"><span>New trending shoes</span></p>
                                   <p><a href="men.php" class="btn btn-primary">Shop Collection</a></p>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </li>
           <li style="background-image: url(assets/images/img_bg_2.jpg);">
               <div class="overlay"></div>
               <div class="container-fluid">
                   <div class="row">
                       <div class="col-sm-6 offset-sm-3 text-center slider-text">
                           <div class="slider-text-inner">
                               <div class="desc">
                                   <h1 class="head-1">Huge</h1>
                                   <h2 class="head-2">Sale</h2>
                                   <h2 class="head-3"><strong class="font-weight-bold">50%</strong> Off</h2>
                                   <p class="category"><span>Big sale sandals</span></p>
                                   <p><a href="women.php" class="btn btn-primary">Shop Collection</a></p>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </li>
           <li style="background-image: url(assets/images/img_bg_3.jpg);">
               <div class="overlay"></div>
               <div class="container-fluid">
                   <div class="row">
                       <div class="col-sm-6 offset-sm-3 text-center slider-text">
                           <div class="slider-text-inner">
                               <div class="desc">
                                   <h1 class="head-1">New</h1>
                                   <h2 class="head-2">Arrival</h2>
                                   <h2 class="head-3">up to <strong class="font-weight-bold">30%</strong> off</h2>
                                   <p class="category"><span>New stylish shoes for men</span></p>
                                   <p><a href="men.php" class="btn btn-primary">Shop Collection</a></p>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </li>
        </ul>
    </div>
</aside>

<div class="colorlib-product">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 offset-sm-2 text-center colorlib-heading">
                <h2>Best Sellers</h2>
            </div>
        </div>
        
        <div class="row row-pb-md">
            <?php
            // Mặc định lấy 8 sản phẩm mới nhất
            $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 8";
            
            // Nếu người dùng bấm nút "Xem tất cả" thì lấy hết
            if (isset($_GET['viewall'])) {
                $sql = "SELECT * FROM products ORDER BY id DESC";
            }

            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="col-lg-3 mb-4 text-center">
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
                echo "<div class='col-12 text-center'><p>Chưa có sản phẩm nào.</p></div>";
            }
            ?>
        </div> 
        
        <div class="row">
            <div class="col-md-12 text-center">
                <?php if(!isset($_GET['viewall'])): ?>
                    <a href="?viewall=1" class="btn btn-primary btn-lg" style="background:#333; color:#fff; padding:15px 50px; border-radius:50px; text-decoration:none;">
                        Xem tất cả sản phẩm
                    </a>
                <?php endif; ?>
            </div>
        </div>

    </div> 
</div> 

<div class="colorlib-partner">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 offset-sm-2 text-center colorlib-heading colorlib-heading-sm">
                <h2>Trusted Partners</h2>
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