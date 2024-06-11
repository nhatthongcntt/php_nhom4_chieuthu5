<?php
include 'conn.php';

$phongID = $_GET['id'];

$sql = "SELECT SinhVien.HoTen, HopDong.NgayThue, HopDong.NgayTra
        FROM HopDong
        JOIN SinhVien ON HopDong.SinhVienID = SinhVien.SinhVienID
        WHERE HopDong.PhongID = :phongID";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':phongID', $phongID, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($students);
?>
