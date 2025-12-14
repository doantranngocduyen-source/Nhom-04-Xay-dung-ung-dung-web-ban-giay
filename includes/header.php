<!DOCTYPE HTML>
<html>
	<head>
	<title>Footwear - Free Bootstrap 4 Template by Colorlib</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Rokkitt:100,300,400,700" rel="stylesheet">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="assets/css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="assets/css/icomoon.css">
	<!-- Ion Icon Fonts-->
	<link rel="stylesheet" href="assets/css/ionicons.min.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="assets/css/magnific-popup.css">

	<!-- Flexslider  -->
	<link rel="stylesheet" href="assets/css/flexslider.css">

	<!-- Owl Carousel -->
	<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
	
	<!-- Date Picker -->
	<link rel="stylesheet" href="assets/css/bootstrap-datepicker.css">
	<!-- Flaticons  -->
	<link rel="stylesheet" href="assets/fonts/flaticon/font/flaticon.css">

	<!-- Theme style  -->
	<link rel="stylesheet" href="assets/css/style.css">

	<?php
// Tính tổng số lượng sản phẩm trong giỏ
$total_qty = 0;
if (isset($_SESSION['cart'])) {
    // array_sum sẽ cộng hết các số lượng lại (Ví dụ: Giày A mua 2, Giày B mua 1 => Tổng = 3)
    $total_qty = array_sum($_SESSION['cart']);
}
?>
	</head>
<body>

	<div id="page">
		<nav class="colorlib-nav" role="navigation">
			<div class="top-menu">
				<div class="container">
					<div class="row">
						<div class="col-sm-7 col-md-9">
							<div id="colorlib-logo"><a href="index.php">ZoneShoes</a></div>
						</div>
						<div class="col-sm-5 col-md-3">
			            <form action="index.php" method="GET" class="search-wrap">
   							<div class="form-group">
      							<input type="search" name="keyword" class="form-control search" placeholder="Tìm kiếm sản phẩm..." value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
      							<button class="btn btn-primary submit-search text-center" type="submit"><i class="icon-search"></i></button>
   							</div>
						</form>
			         </div>
		         </div>
					<div class="row">
						<div class="col-sm-12 text-left menu-1">
							<ul>
    <li class="active"><a href="index.php">Home</a></li>
    <li class="has-dropdown">
        <a href="men.php">Men</a>
        <!-- <ul class="dropdown">
            <li><a href="product-detail.php">Product Detail</a></li>
            <li><a href="cart.php">Shopping Cart</a></li>
            <li><a href="checkout.php">Checkout</a></li>
            <li><a href="add-to-wishlist.php">Wishlist</a></li>
        </ul> -->
    </li>
    <li><a href="women.php">Women</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="contact.php">Contact</a></li>
	<li class="cart">
    <a href="cart.php">
        <i class="icon-shopping-cart"></i> Cart [<?php echo $total_qty; ?>]
    </a>
	</li>
	<?php if (isset($_SESSION['user_name'])): ?>
            <li class="has-dropdown" style="position: relative;">
                <a href="#" style="color: #FF5722; font-weight: bold;">Chào, <?php echo $_SESSION['user_name']; ?></a>
                	<ul class="dropdown" style="right: 0; text-align: left; padding: 15px 20px;"> 
						<?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1): ?>
                        <li>
                            <a href="admin/orders.php" >QUẢN LÝ ĐƠN</a>
                        </li>
                        <li>
                            <a href="admin/products.php" >QUẢN LÝ KHO</a>
                        </li>
						<li>
							<a href="admin/stats.php" >THỐNG KÊ</a>
                        </li>
                        <hr> <?php endif; ?>
                    
                    <li><a href="logout.php">Đăng xuất</a></li>
                </ul>
            </li>
        		<?php else: ?>
            		<li><a href="login.php">Đăng nhập</a></li>
            		<li><a href="register.php">Đăng ký</a></li>
        		<?php endif; ?>
				<div class="sale">
				<div class="container">
					<div class="row">
						<div class="col-sm-8 offset-sm-2 text-center">
							<div class="row">
								<div class="owl-carousel2">
									<div class="item">
										<div class="col">
											<h3><a href="#">25% off (Almost) Everything! Use Code: Summer Sale</a></h3>
										</div>
									</div>
									<div class="item">
										<div class="col">
											<h3><a href="#">Our biggest sale yet 50% off all summer shoes</a></h3>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>