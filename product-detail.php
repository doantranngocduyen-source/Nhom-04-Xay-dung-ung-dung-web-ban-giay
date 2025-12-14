<?php 
include 'includes/db.php';
include 'includes/header.php';

// Lấy ID sản phẩm từ URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Truy vấn thông tin sản phẩm
$sql = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

// Nếu không tìm thấy sản phẩm thì báo lỗi
if (!$product) {
    echo "<div class='container p-5 text-center'><h3>Sản phẩm không tồn tại!</h3><a href='index.php' class='btn btn-primary'>Về trang chủ</a></div>";
    include 'footer.php';
    exit();
}
?>

<style>
    
    /* Style cho ô Size khi được chọn (Active) */
    .product-desc .size-wrap .block-26 ul li.active a {
        background: #000 !important; /* Màu nền đen */
        color: #fff !important;      /* Chữ trắng */
        border-color: #000 !important;
    }
</style>

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="bread"><span><a href="index.php">Home</a></span> / <span>Product Details</span></p>
            </div>
        </div>
    </div>
</div>

<div class="colorlib-product product-detail-page">
    <div class="container">
        <div class="row row-pb-lg product-detail-wrap">
            <div class="col-sm-8">
                <div class="product-entry border">
                    <a href="#" class="prod-img">
                        <?php 
                            $img_path = "uploads/" . $product['image'];
                            if(!empty($product['image']) && file_exists($img_path)) {
                                echo '<img src="'.$img_path.'" class="img-fluid" alt="'.$product['name'].'">';
                            } else {
                                echo '<img src="assets/images/item-1.jpg" class="img-fluid" alt="Ảnh lỗi">';
                            }
                        ?>
                    </a>
                </div>
            </div>
            
            <div class="col-sm-4">
                <div class="product-desc">
                    <h3><?php echo $product['name']; ?></h3>
                    <p class="price">
                        <span><?php echo number_format($product['price']); ?> VNĐ</span> 
                        <span class="rate">
                            <i class="icon-star-full"></i>
                            <i class="icon-star-full"></i>
                            <i class="icon-star-full"></i>
                            <i class="icon-star-full"></i>
                            <i class="icon-star-half"></i>
                            (74 Rating)
                        </span>
                    </p>
                    <p><?php echo nl2br($product['description']); ?></p>
                    
                    <div class="size-wrap">
                        <div class="block-26 mb-2">
                            <h4>Size</h4>
                           <ul>
                              <li><a href="#">38</a></li>
                              <li><a href="#">39</a></li>
                              <li class="active"><a href="#">40</a></li>
                              <li><a href="#">41</a></li>
                              <li><a href="#">42</a></li>
                           </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <p class="addtocart">
                                <a href="cart.php?add_id=<?php echo $product['id']; ?>" class="btn btn-primary btn-addtocart">
                                    <i class="icon-shopping-cart"></i> Thêm vào giỏ hàng
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-12 pills">
                        <div class="bd-example bd-example-tabs">
                          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="pills-description-tab" data-toggle="pill" href="#pills-description" role="tab" aria-controls="pills-description" aria-expanded="true">Mô tả</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="pills-review-tab" data-toggle="pill" href="#pills-review" role="tab" aria-controls="pills-review" aria-expanded="true">Đánh giá</a>
                            </li>
                          </ul>

                          <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane border fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
                              <p><?php echo nl2br($product['description']); ?></p>
                            </div>

                            <div class="tab-pane border fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
                              <div class="row">
                                   <div class="col-md-12">
                                       <h3 class="head">Chưa có đánh giá nào.</h3>
                                   </div>
                               </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
    $(document).ready(function(){
        // Xử lý chọn Size
        $(".block-26 ul li").click(function(e){
            e.preventDefault(); // Ngăn thẻ a chuyển trang
            
            // 1. Xóa class 'active' ở tất cả các ô size khác
            $(".block-26 ul li").removeClass("active");
            
            // 2. Thêm class 'active' vào ô (thẻ li) vừa bấm
            $(this).addClass("active");
            
            // (Tùy chọn) Lấy giá trị size để in ra console kiểm tra
            var selectedSize = $(this).find('a').text();
            console.log("Đã chọn size: " + selectedSize);
        });
    });
</script>