<?php
include 'conn.php';

// Lấy dữ liệu từ form
$id = $_POST['LoaiPhongID'] ?? '';
$ten = $_POST['TenLoaiPhong'] ?? '';

// Tạo câu lệnh SQL sử dụng Prepared Statements
$sql = "INSERT INTO LoaiPhong (LoaiPhongID, TenLoaiPhong) VALUES (:id, :ten)";

// Chuẩn bị câu lệnh
$stmt = $conn->prepare($sql);

// Gán giá trị cho các tham số và thực thi câu lệnh
$stmt->execute(['id' => $id, 'ten' => $ten]);

// Chuyển hướng người dùng về trang quản lý loại phòng
header('Location: trangQLLoaiPhong.php');
?>
