<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoaDonID = $_POST['HoaDonID'];
    $hopDongID = $_POST['HopDongID'];
    $soDien = $_POST['SoDien'];
    $soNuoc = $_POST['SoNuoc'];
    $ngayLap = $_POST['NgayLap'];
    $tongTien = $_POST['TongTien'];

    $sql = "UPDATE HoaDon SET HopDongID = :hopDongID, SoDien = :soDien, SoNuoc = :soNuoc, NgayLap = :ngayLap, TongTien = :tongTien WHERE HoaDonID = :hoaDonID";
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':hoaDonID', $hoaDonID);
    $stmt->bindParam(':hopDongID', $hopDongID);
    $stmt->bindParam(':soDien', $soDien);
    $stmt->bindParam(':soNuoc', $soNuoc);
    $stmt->bindParam(':ngayLap', $ngayLap);
    $stmt->bindParam(':tongTien', $tongTien);

    if ($stmt->execute()) {
        echo "<script>alert('Sửa hóa đơn thành công!'); window.location.href = 'trangQLHoaDon.php';</script>";
    } else {
        echo "<script>alert('Sửa hóa đơn thất bại!'); window.location.href = 'trangQLHoaDon.php';</script>";
    }
}
?>
