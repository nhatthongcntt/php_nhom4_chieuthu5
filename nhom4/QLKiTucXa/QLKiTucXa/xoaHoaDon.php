<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $hoaDonID = $_GET['id'];

    $sql = "DELETE FROM HoaDon WHERE HoaDonID = :hoaDonID";
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':hoaDonID', $hoaDonID);

    if ($stmt->execute()) {
        echo "<script>alert('Xóa hóa đơn thành công!'); window.location.href = 'trangQLHoaDon.php';</script>";
    } else {
        echo "<script>alert('Xóa hóa đơn thất bại!'); window.location.href = 'trangQLHoaDon.php';</script>";
    }
}
?>
