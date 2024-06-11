<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $LoaiPhongID = $_POST['LoaiPhongID'];
    $TenLoaiPhong = $_POST['TenLoaiPhong'];

    $sql = "UPDATE LoaiPhong SET TenLoaiPhong = :TenLoaiPhong WHERE LoaiPhongID = :LoaiPhongID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':LoaiPhongID', $LoaiPhongID);
    $stmt->bindParam(':TenLoaiPhong', $TenLoaiPhong);

    if ($stmt->execute()) {
        header("Location: trangQLLoaiPhong.php?message=Sửa loại phòng thành công");
    } else {
        echo "Lỗi khi sửa loại phòng.";
    }
} else {
    echo "Phương thức không hợp lệ.";
}
?>
