<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 
?>

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="bread"><span><a href="index.php">Home</a></span> / <span>Contact</span></p>
            </div>
        </div>
    </div>
</div>

<div id="colorlib-contact">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h3>Thông tin liên hệ</h3>
                <div class="row contact-info-wrap">
                    <div class="col-md-3">
                        <p><span><i class="icon-location"></i></span> 123 Đường ABC, Quận 1, TP.HCM</p>
                    </div>
                    <div class="col-md-3">
                        <p><span><i class="icon-phone3"></i></span> <a href="tel://123456789">+ 84 123 456 789</a></p>
                    </div>
                    <div class="col-md-3">
                        <p><span><i class="icon-paperplane"></i></span> <a href="mailto:info@zoneshoes.com">info@zoneshoes.com</a></p>
                    </div>
                    <div class="col-md-3">
                        <p><span><i class="icon-globe"></i></span> <a href="#">zoneshoes.com</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="contact-wrap">
                    <h3>Gửi tin nhắn cho chúng tôi</h3>
                    <form action="#" class="contact-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">Họ</label>
                                    <input type="text" id="fname" class="form-control" placeholder="Họ của bạn">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname">Tên</label>
                                    <input type="text" id="lname" class="form-control" placeholder="Tên của bạn">
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" id="email" class="form-control" placeholder="Email liên hệ">
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="subject">Chủ đề</label>
                                    <input type="text" id="subject" class="form-control" placeholder="Tiêu đề tin nhắn">
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="message">Nội dung</label>
                                    <textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="Nội dung cần hỗ trợ..."></textarea>
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="submit" value="Gửi Tin Nhắn" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </form>     
                </div>
            </div>
            <div class="col-md-6">
                <div id="map" class="colorlib-map"></div>       
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>