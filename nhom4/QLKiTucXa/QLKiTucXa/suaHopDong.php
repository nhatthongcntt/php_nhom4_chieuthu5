<?php
include 'conn.php';

// Lấy dữ liệu từ form
$hopDongID = $_POST['HopDongID'] ?? '';
$sinhVienID = $_POST['SinhVienID'] ?? '';
$quanLyID = $_POST['QuanLyID'] ?? '';
$phongID = $_POST['PhongID'] ?? '';
$ngayThue = $_POST['NgayThue'] ?? '';
$ngayTra = $_POST['NgayTra'] ?? '';

// Tạo câu lệnh SQL sử dụng Prepared Statements
$sql = "UPDATE HopDong SET SinhVienID = :sinhVienID, QuanLyID = :quanLyID, PhongID = :phongID, NgayThue = :ngayThue, NgayTra = :ngayTra WHERE HopDongID = :hopDongID";

// Chuẩn bị câu lệnh
$stmt = $conn->prepare($sql);

// Gán giá trị cho các tham số và thực thi câu lệnh
$stmt->execute(['sinhVienID' => $sinhVienID, 'quanLyID' => $quanLyID, 'phongID' => $phongID, 'ngayThue' => $ngayThue, 'ngayTra' => $ngayTra, 'hopDongID' => $hopDongID]);

// Chuyển hướng người dùng về trang quản lý hợp đồng
header('Location: trangQLHopDong.php');
?>
