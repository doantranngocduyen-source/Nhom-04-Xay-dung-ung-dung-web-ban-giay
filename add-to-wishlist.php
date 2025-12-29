<?php 
include 'includes/db.php';
include 'includes/header.php';
?>
<!-- <style>
    /* Chỉnh hàng tiêu đề */
    .product-name span {
        font-size: 16px !important;   /* Cỡ chữ to hơn */
        font-weight: 700 !important;  /* Chữ đậm */
        color: #000 !important;       /* Màu đen rõ nét */
        text-transform: uppercase;    /* Viết hoa */
    }
    
    /* Chỉnh tên sản phẩm bên dưới */
    .product-cart h3 {
        font-size: 18px !important;
        font-weight: bold;
    }
</style> -->

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="bread"><span><a href="../index.php">Home</a></span> / <span>My Wishlist</span></p>
            </div>
        </div>
    </div>
</div>

<div class="colorlib-product">
    <div class="container">
        <div class="row row-pb-lg">
                    <div class="col-md-12">
                        <div class="product-name d-flex">
                            <div class="one-forth text-left px-4">
                                <span>Sản phẩm yêu thích</span>
                            </div>
                            <div class="one-eight text-center">
                                <span>Giá</span>
                            </div>
                            <div class="one-eight text-center">
                                <span>Tình trạng</span>
                            </div>
                            <div class="one-eight text-center px-2">
                                <span>Thêm vào giỏ</span>
                            </div>
                        </div>

                        <?php
                        // Lấy đại 2 sản phẩm trong database ra giả làm Wishlist
                        $sql = "SELECT * FROM products LIMIT 2";
                        $result = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)) {
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
                                        <span class="status" style="color: green;">Còn hàng</span>
                                    </div>
                                </div>
                                <div class="one-eight text-center">
                                    <div class="display-tc">
                                        <a href="cart.php?add_id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Thêm ngay</a>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            }
                        } else {
                            echo "<p class='text-center mt-3'>Chưa có sản phẩm nào.</p>";
                        }
                        ?>
                        
                    </div>
                </div>
	</div>
</div>

<?php include 'footer.php'; ?>