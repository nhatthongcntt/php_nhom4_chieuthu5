<?php
include 'conn.php';

// Lấy dữ liệu từ form
$id = $_POST['QuanLyID'] ?? '';
$ht = $_POST['HoTen'] ?? '';
$gt = $_POST['GioiTinh'] ?? '';
$ns = $_POST['NgaySinh'] ?? '';
$dt = $_POST['DienThoai'] ?? '';

// Tạo câu lệnh SQL sử dụng Prepared Statements
$sql = "INSERT INTO QuanLy (QuanLyID, HoTen, GioiTinh, NgaySinh, DienThoai) VALUES (:id, :ht, :gt, :ns, :dt)";

// Chuẩn bị câu lệnh
$stmt = $conn->prepare($sql);

// Gán giá trị cho các tham số và thực thi câu lệnh
$stmt->execute(['id' => $id, 'ht' => $ht, 'gt' => $gt, 'ns' => $ns, 'dt' => $dt]);

// Chuyển hướng người dùng về trang thêm ql
header('Location: trangQLQuanLy.php');
?>