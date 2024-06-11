<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $SinhVienID = $_POST['SinhVienID'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $QueQuan = $_POST['QueQuan'];
    $DienThoai = $_POST['DienThoai'];

    $sql = "UPDATE SinhVien SET HoTen = :HoTen, GioiTinh = :GioiTinh, NgaySinh = :NgaySinh, QueQuan = :QueQuan, DienThoai = :DienThoai WHERE SinhVienID = :SinhVienID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':SinhVienID', $SinhVienID);
    $stmt->bindParam(':HoTen', $HoTen);
    $stmt->bindParam(':GioiTinh', $GioiTinh);
    $stmt->bindParam(':NgaySinh', $NgaySinh);
    $stmt->bindParam(':QueQuan', $QueQuan);
    $stmt->bindParam(':DienThoai', $DienThoai);

    if ($stmt->execute()) {
        header("Location: trangQLSinhVien.php?message=Sửa sinh viên thành công");
    } else {
        echo "Lỗi khi sửa sinh viên.";
    }
} else {
    echo "Phương thức không hợp lệ.";
}
?>
