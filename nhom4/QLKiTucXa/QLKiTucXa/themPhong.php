<?php
include 'conn.php';

// Lấy dữ liệu từ form
$phongID = $_POST['PhongID'] ?? '';
$tenPhong = $_POST['TenPhong'] ?? '';
$khuVucID = $_POST['KhuVucID'] ?? '';
$loaiPhongID = $_POST['LoaiPhongID'] ?? '';

// Tạo câu lệnh SQL sử dụng Prepared Statements
$sql = "INSERT INTO Phong (PhongID, TenPhong, KhuVucID, LoaiPhongID) VALUES (:phongID, :tenPhong, :khuVucID, :loaiPhongID)";

// Chuẩn bị câu lệnh
$stmt = $conn->prepare($sql);

// Gán giá trị cho các tham số và thực thi câu lệnh
$stmt->execute(['phongID' => $phongID, 'tenPhong' => $tenPhong, 'khuVucID' => $khuVucID, 'loaiPhongID' => $loaiPhongID]);

// Chuyển hướng người dùng về trang quản lý phòng
header('Location: trangQLPhong.php');
?>
