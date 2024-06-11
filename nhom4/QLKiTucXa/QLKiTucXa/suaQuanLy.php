<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $QuanLyID = $_POST['QuanLyID'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $DienThoai = $_POST['DienThoai'];

    $sql = "UPDATE QuanLy SET HoTen = :HoTen, GioiTinh = :GioiTinh, NgaySinh = :NgaySinh, DienThoai = :DienThoai WHERE QuanLyID = :QuanLyID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':QuanLyID', $QuanLyID);
    $stmt->bindParam(':HoTen', $HoTen);
    $stmt->bindParam(':GioiTinh', $GioiTinh);
    $stmt->bindParam(':NgaySinh', $NgaySinh);
    $stmt->bindParam(':DienThoai', $DienThoai);

    if ($stmt->execute()) {
        header("Location: trangQLQuanLy.php?message=Sửa nhân viên thành công");
    } else {
        echo "Lỗi khi sửa nhân viên.";
    }
} else {
    echo "Phương thức không hợp lệ.";
}
?>
