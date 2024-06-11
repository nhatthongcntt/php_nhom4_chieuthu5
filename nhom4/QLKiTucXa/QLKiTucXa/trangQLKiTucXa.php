<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Kí Túc Xá</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 200px;
            background: #f8f9fa;
            padding: 15px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            
        }
        
        .main-content {
            margin-left: 220px;
            padding: 15px;
            width: calc(100% - 220px);
        }
        .menu-header {
            font-weight: bold;
            margin-top: 20px;
        }
        .sidebar a {
            display: block;
            padding: 5px 0;
            color: #007bff;
            text-decoration: none;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="sidebar">
<?php
session_start(); // Bắt đầu session

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if(isset($_SESSION['HoTen'])) {
    $tenNguoiDangNhap = $_SESSION['HoTen'];
    echo "Xin chào $tenNguoiDangNhap!"; // Hiển thị tên người đăng nhập
} else {
    echo "Chưa đăng nhập";
}
?>
    <div class="menu-header">Quản lý phòng KTX</div>
    <a href="trangQLKiTucXa.php">Quản lý KTX</a>
    <div class="menu-header">Quản lý danh mục</div>
    <a href="trangQLKhuVuc.php" data-content="content-khu-vuc">Quản lý khu vực</a>
    <a href="trangQLPhong.php">Quản lý phòng</a>
    <a href="trangQLLoaiPhong.php">Quản lý loại phòng</a>
    <a href="trangQLHopDong.php">Quản lý hợp đồng</a>
    <a href="trangQLHoaDon.php">Quản lý hóa đơn</a>
    <div class="menu-header">Quản lý sinh viên</div>
    <a href="trangQLSinhVien.php">Quản lý sinh viên</a>
    <div class="menu-header">Quản lý nhân viên</div>
    <a href="trangQLQuanLy.php">Quản lý nhân viên</a>
</div>

<div class="main-content">


    <center><h3 class="mt-2">Quản Lý Kí Túc Xá</h3></center>
   
    <!-- Các nội dung khác của trang -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên phòng</th>
                <th>Khu vực</th>
                <th>Loại phòng</th>
                <th>Trạng thái</th>
                <th>Số lượng </th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'conn.php';
            $sql = "SELECT Phong.PhongID, Phong.TenPhong, KhuVuc.TenKhuVuc, LoaiPhong.TenLoaiPhong,
                           CASE WHEN HopDong.PhongID IS NOT NULL THEN 'Có người' ELSE 'Còn trống' END AS TrangThai,
                           HopDong.HopDongID,
                           COUNT(HopDong.HopDongID) AS SoLuongHopDong, LoaiPhong.TenLoaiPhong AS LoaiPhongTen                    
                    FROM Phong
                    LEFT JOIN KhuVuc ON Phong.KhuVucID = KhuVuc.KhuVucID
                    LEFT JOIN LoaiPhong ON Phong.LoaiPhongID = LoaiPhong.LoaiPhongID
                    LEFT JOIN HopDong ON Phong.PhongID = HopDong.PhongID
                    GROUP BY Phong.PhongID, Phong.TenPhong, KhuVuc.TenKhuVuc, LoaiPhong.TenLoaiPhong";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>{$row['PhongID']}</td>";
                    echo "<td>{$row['TenPhong']}</td>";
                    echo "<td>{$row['TenKhuVuc']}</td>";
                    echo "<td>{$row['TenLoaiPhong']}</td>";
                    echo "<td>{$row['TrangThai']}</td>";
                    echo "<td>{$row['SoLuongHopDong']} / {$row['LoaiPhongTen']}</td>";
                    echo "<td>";
                    echo "<button type='button' class='btn btn-info mr-1 view-btn' data-phongid='{$row['PhongID']}' data-toggle='modal' data-target='#viewModal'>";
                    echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye-fill' viewBox='0 0 16 16'>";
                    echo "<path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.07-.12.146-.193.23a13.14 13.14 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z'/>";
                    echo "<path d='M8 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6z'/>";
                    echo "</svg>";
                    echo "</button>";

                    echo "<button type='button' class='btn btn-warning mr-1 payment-btn' data-phongid='{$row['PhongID']}' data-hopdongid='{$row['HopDongID']}' data-toggle='modal' data-target='#paymentModal'>";
                    echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-credit-card-fill' viewBox='0 0 16 16'>";
                    echo "<path d='M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4zm0 2h16v7a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6zm4.5 5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z'/>";
                    echo "</svg>";
                    echo "</button>";

                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>Không có dữ liệu</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-primary">Đăng xuất</a>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết phòng</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="studentDetails"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thanh toán phòng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="paymentForm">
                    <div class="form-group">
                        <label for="soDien">Số điện</label>
                        <input type="number" class="form-control" id="soDien" placeholder="Nhập số điện" required>
                    </div>
                    <div class="form-group">
                        <label for="soNuoc">Số nước</label>
                        <input type="number" class="form-control" id="soNuoc" placeholder="Nhập số nước" required>
                    </div>
                    <div class="form-group">
                        <label for="tongTien">Tổng tiền</label>
                        <input type="text" class="form-control" id="tongTien" readonly>
                    </div>
                    <input type="hidden" id="hopDongID">
                    <input type="hidden" id="maHoaDon">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="confirmPayment()">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$('.view-btn').click(function() {
    var phongID = $(this).data('phongid');
    $.ajax({
        url: 'getStudentDetails.php',
        type: 'GET',
        data: { id: phongID },
        success: function(response) {
            const students = JSON.parse(response);
            let html = '<table class="table table-striped"><thead><tr><th>STT</th><th>Tên Sinh Viên</th><th>Ngày Thuê</th><th>Ngày Trả</th></tr></thead><tbody>';
            if (students.length > 0) {
                students.forEach((student, index) => {
                    html += `<tr><td>${index + 1}</td><td>${student.HoTen}</td><td>${student.NgayThue}</td><td>${student.NgayTra}</td></tr>`;
                });
            } else {
                html += '<tr><td colspan="4" class="text-center">Không có dữ liệu</td></tr>';
            }
            html += '</tbody></table>';
            $('#studentDetails').html(html);
        }
    });
});


$('.payment-btn').click(function() {
    var phongID = $(this).data('phongid');
    var hopDongID = $(this).data('hopdongid');
    $('#hopDongID').val(hopDongID || '');  // Đảm bảo giá trị không undefined
    const maHoaDon = `HD${Date.now()}`;    // Tạo mã hóa đơn ngẫu nhiên
    $('#maHoaDon').val(maHoaDon);
    console.log("hopDongID: ", hopDongID); // Thêm dòng này
    console.log("maHoaDon: ", maHoaDon);   // Thêm dòng này

    // Fetch the number of students in the room and store it
    $.ajax({
        url: 'getStudentCount.php', // This should be a new PHP file to return the number of students in the room
        type: 'GET',
        data: { id: phongID },
        success: function(response) {
            const studentCount = parseInt(response);
            $('#paymentModal').data('student-count', studentCount);
            calculateTotal(); // Update the total calculation with the new student count
        }
    });

    $('#paymentModal').modal('show');
});

$('#soDien, #soNuoc').on('input', function() {
    calculateTotal();
});

function calculateTotal() {
    var soDien = parseFloat($('#soDien').val()) || 0;
    var soNuoc = parseFloat($('#soNuoc').val()) || 0;
    var studentCount = $('#paymentModal').data('student-count') || 0;
    var baseCost = studentCount * 500000; // 500000 VND per student
    var tongTien = baseCost + (soDien * 3000) + (soNuoc * 6000);
    $('#tongTien').val(tongTien.toLocaleString('vi-VN') + ' VND');
}

function confirmPayment() {
    var soDien = $('#soDien').val();
    var soNuoc = $('#soNuoc').val();
    var tongTien = $('#tongTien').val();
    var hopDongID = $('#hopDongID').val();
    var maHoaDon = $('#maHoaDon').val();

    console.log("hopDongID: ", hopDongID); // Thêm dòng này
    console.log("maHoaDon: ", maHoaDon);   // Thêm dòng này

    if (!hopDongID || !maHoaDon) {
        alert('Thông tin hóa đơn không hợp lệ.');
        return;
    }

    $.ajax({
        url: 'themHoaDon.php',
        type: 'POST',
        data: {
            maHoaDon: maHoaDon,
            hopDongID: hopDongID,
            soDien: soDien,
            soNuoc: soNuoc,
            tongTien: tongTien
        },
        success: function(response) {
            alert(response);
            $('#paymentModal').modal('hide');
        },
        error: function(xhr, status, error) {
            alert('Lỗi: ' + error);
        }
    });
}
</script>
</body>
</html>
