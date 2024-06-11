<?php
include 'conn.php';

$SinhVienID = $_POST['SinhVienID'];
$QuanLyID = $_POST['QuanLyID'];
$PhongID = $_POST['PhongID'];
$NgayThue = $_POST['NgayThue'];
$NgayTra = $_POST['NgayTra'];

// Kiểm tra nếu ngày thuê lớn hơn ngày hiện tại
$ngayHienTai = new DateTime();
$ngayThue = new DateTime($NgayThue);

if ($ngayThue < $ngayHienTai) {
    echo "<script>alert('Ngày thuê không thể bé hơn ngày hiện tại.'); window.location.href='trangQLHopDong.php';</script>";
    exit;
}

// Lấy thông tin sinh viên
$sql = "SELECT GioiTinh FROM SinhVien WHERE SinhVienID = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$SinhVienID]);
$sinhVien = $stmt->fetch(PDO::FETCH_ASSOC);

// Lấy thông tin khu vực của phòng
$sql = "SELECT LoaiPhongID, KhuVucID FROM Phong WHERE PhongID = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$PhongID]);
$phong = $stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra xem sinh viên đã có hợp đồng nào chưa
$sql = "SELECT COUNT(*) AS SoLuong FROM HopDong WHERE SinhVienID = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$SinhVienID]);
$soLuong = $stmt->fetch(PDO::FETCH_ASSOC)['SoLuong'];

if ($soLuong > 0) {
    echo "<script>alert('Sinh viên này đã có hợp đồng.'); window.location.href='trangQLHopDong.php';</script>";
    exit;
}

// Kiểm tra giới tính và khu vực
if (($sinhVien['GioiTinh'] == 'Nam' && $phong['KhuVucID'] != 1) || 
    ($sinhVien['GioiTinh'] == 'Nu' && $phong['KhuVucID'] != 2)) {
    echo "<script>alert('Sinh viên không thể đăng ký phòng trong khu vực này.'); window.location.href='trangQLHopDong.php';</script>";
    exit;
}

// Kiểm tra ngày thuê và ngày trả
$ngayTra = new DateTime($NgayTra);

if ($ngayThue->format('d') != $ngayTra->format('d') || $ngayThue->format('m') >= $ngayTra->format('m')) {
    echo "<script>alert('Ngày thuê và ngày trả phải giống nhau về ngày và tháng của ngày trả phải lớn hơn tháng của ngày thuê.'); window.location.href='trangQLHopDong.php';</script>";
    exit;
}

// Lấy số lượng hợp đồng hiện tại cho phòng này
$sql = "SELECT COUNT(*) AS SoLuong FROM HopDong WHERE PhongID = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$PhongID]);
$soLuong = $stmt->fetch(PDO::FETCH_ASSOC)['SoLuong'];

// Xác định số lượng sinh viên tối đa cho loại phòng này
$soLuongToiDa = 0;
if ($phong['LoaiPhongID'] == 1) {
    $soLuongToiDa = 4;
} elseif ($phong['LoaiPhongID'] == 2) {
    $soLuongToiDa = 6;
} elseif ($phong['LoaiPhongID'] == 3) {
    $soLuongToiDa = 8;
}

// Kiểm tra xem phòng đã đủ sinh viên hay chưa
if ($soLuong >= $soLuongToiDa) {
    echo "<script>alert('Phòng đã đủ số lượng sinh viên.'); window.location.href='trangQLHopDong.php';</script>";
    exit;
}

// Thêm hợp đồng mới nếu tất cả các điều kiện đều thỏa mãn
$sql = "INSERT INTO HopDong (SinhVienID, QuanLyID, PhongID, NgayThue, NgayTra) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$SinhVienID, $QuanLyID, $PhongID, $NgayThue, $NgayTra]);

echo "<script>alert('Thêm hợp đồng thành công!'); window.location.href='trangQLHopDong.php';</script>";
?>
