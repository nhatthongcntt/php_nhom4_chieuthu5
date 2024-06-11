<?php
include 'conn.php';

// Nhận ID hợp đồng từ yêu cầu AJAX
$hopDongID = $_GET['hopDongID'];

// Truy vấn để lấy danh sách sinh viên có hợp đồng của phòng đó
$sql = "SELECT * FROM SinhVien WHERE HopDongID = :hopDongID";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':hopDongID', $hopDongID, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Trả về dữ liệu dưới dạng JSON
echo json_encode($students);
?>
