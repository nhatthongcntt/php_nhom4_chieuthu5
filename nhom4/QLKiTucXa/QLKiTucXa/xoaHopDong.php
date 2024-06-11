<?php
include 'conn.php';

// Lấy ID của hợp đồng cần xóa từ URL
$hopDongID = $_GET['id'] ?? '';

// Tạo câu lệnh SQL sử dụng Prepared Statements
$sql = "DELETE FROM HopDong WHERE HopDongID = :hopDongID";

// Chuẩn bị câu lệnh
$stmt = $conn->prepare($sql);

// Gán giá trị cho các tham số và thực thi câu lệnh
$stmt->execute(['hopDongID' => $hopDongID]);

// Chuyển hướng người dùng về trang quản lý hợp đồng
header('Location: trangQLHopDong.php');
?>
