<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web-ban-giay"; // Đã sửa tên DB theo ảnh bạn gửi

// Tạo kết nối
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$conn) {
  die("Kết nối thất bại: " . mysqli_connect_error());
}

// Chỉnh font tiếng Việt
mysqli_set_charset($conn, "utf8");

// Khởi động session cho giỏ hàng
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>