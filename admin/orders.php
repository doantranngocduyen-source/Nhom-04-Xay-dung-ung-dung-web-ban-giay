<?php
include $_SERVER['DOCUMENT_ROOT'] . '/web_ban_giay/includes/db.php';
include 'includes/admin_header.php';

// KIỂM TRA QUYỀN ADMIN
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    echo "<script>alert('Bạn không có quyền truy cập!'); window.location='../login.php';</script>";
    exit();
}

// --- XỬ LÝ: CẬP NHẬT TRẠNG THÁI ---
if (isset($_GET['status']) && isset($_GET['id'])) {
    $status = intval($_GET['status']);
    $id = intval($_GET['id']);
    
    // Câu lệnh Update
    $sql_update = "UPDATE orders SET status = $status WHERE id = $id";
    
    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Cập nhật trạng thái thành công!'); window.location='orders.php';</script>";
    } else {
        echo "<script>alert('Lỗi: " . mysqli_error($conn) . "');</script>";
    }
}

// --- XỬ LÝ: XÓA ĐƠN VĨNH VIỄN ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Xóa chi tiết đơn hàng trước (ràng buộc khóa ngoại)
    mysqli_query($conn, "DELETE FROM order_details WHERE order_id=$id");
    // Xóa đơn hàng
    mysqli_query($conn, "DELETE FROM orders WHERE id=$id");
    echo "<script>alert('Đã xóa đơn hàng vĩnh viễn!'); window.location='orders.php';</script>";
}
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Quản Lý Đơn Hàng</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách đơn hàng</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr class="text-center">
                        <th>Mã</th>
                        <th>Khách Hàng</th>
                        <th>Tổng Tiền</th>
                        <th>Ngày Đặt</th>
                        <th style="width: 200px;">Trạng Thái / Thao tác</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM orders ORDER BY id DESC";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td class="text-center">#<?php echo $row['id']; ?></td>
                            <td>
                                <b><?php echo $row['fullname']; ?></b><br>
                                <small><?php echo $row['phone']; ?></small><br>
                                <small class="text-muted"><?php echo $row['address']; ?></small>
                            </td>
                            <td class="text-danger font-weight-bold text-right">
                                <?php echo number_format($row['total_money']); ?> đ
                            </td>
                            <td class="text-center">
                                <?php echo date("d/m/Y", strtotime($row['created_at'])); ?>
                            </td>
                            
                            <td class="text-center">
                                <?php if($row['status'] == 0): // 0: Chờ xử lý ?>
                                    <span class="badge badge-warning mb-2">Chờ xử lý</span><br>
                                    
                                    <a href="orders.php?status=1&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success" title="Duyệt đơn này">
                                        <i class="fas fa-check"></i> Duyệt
                                    </a>
                                    <a href="orders.php?status=3&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn hủy đơn này?');" title="Hủy đơn này">
                                        <i class="fas fa-times"></i> Hủy
                                    </a>

                                <?php elseif($row['status'] == 1): // 1: Đang giao ?>
                                    <span class="badge badge-primary mb-2">Đang giao hàng</span><br>
                                    <a href="orders.php?status=2&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-check-double"></i> Xác nhận đã giao
                                    </a>

                                <?php elseif($row['status'] == 2): // 2: Thành công ?>
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> Giao thành công
                                    </span>

                                <?php elseif($row['status'] == 3): // 3: Đã hủy ?>
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-ban"></i> Đã hủy
                                    </span>
                                    <br>
                                    <a href="orders.php?status=0&id=<?php echo $row['id']; ?>" class="text-dark small" onclick="return confirm('Khôi phục lại đơn này?');">
                                        <u>Khôi phục</u>
                                    </a>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <a href="order_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-circle btn-sm" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <?php if($row['status'] == 2 || $row['status'] == 3): ?>
                                <a href="orders.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-circle btn-sm" onclick="return confirm('CẢNH BÁO: Xóa là mất luôn dữ liệu. Bạn có chắc không?');" title="Xóa vĩnh viễn">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Chưa có đơn hàng nào!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>