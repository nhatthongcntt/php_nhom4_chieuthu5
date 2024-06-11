<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phongID = $_POST['PhongID'];
    $tenPhong = $_POST['TenPhong'];
    $khuVucID = $_POST['KhuVucID'];
    $loaiPhongID = $_POST['LoaiPhongID'];

    $sql = "UPDATE Phong SET TenPhong = :tenPhong, KhuVucID = :khuVucID, LoaiPhongID = :loaiPhongID WHERE PhongID = :phongID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':phongID', $phongID);
    $stmt->bindParam(':tenPhong', $tenPhong);
    $stmt->bindParam(':khuVucID', $khuVucID);
    $stmt->bindParam(':loaiPhongID', $loaiPhongID);

    if ($stmt->execute()) {
        header("Location: trangQLPhong.php?message=Sửa phòng thành công");
    } else {
        echo "Lỗi khi sửa phòng.";
    }
} else {
    echo "Phương thức không hợp lệ.";
}
?>
