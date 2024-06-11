<?php
include 'conn.php';

// Lấy dữ liệu từ form
$id = $_POST['SinhVienID'] ?? '';
$ht = $_POST['HoTen'] ?? '';
$gt = $_POST['GioiTinh'] ?? '';
$ns = $_POST['NgaySinh'] ?? '';
$qq = $_POST['QueQuan'] ?? '';
$dt = $_POST['DienThoai'] ?? '';

// Tạo câu lệnh SQL sử dụng Prepared Statements
$sql = "INSERT INTO SinhVien (SinhVienID, HoTen, GioiTinh, NgaySinh, QueQuan, DienThoai) VALUES (:id, :ht, :gt, :ns, :qq, :dt)";

// Chuẩn bị câu lệnh
$stmt = $conn->prepare($sql);

// Gán giá trị cho các tham số và thực thi câu lệnh
$stmt->execute(['id' => $id, 'ht' => $ht, 'gt' => $gt, 'ns' => $ns, 'qq' => $qq, 'dt' => $dt]);

// Chuyển hướng người dùng về trang thêm sinh viên
header('Location: trangQLSinhVien.php');
?>