<?php
include 'conn.php';

// Lấy dữ liệu từ form
$id = $_POST['KhuVucID'] ?? '';
$tkv = $_POST['TenKhuVuc'] ?? '';


// Tạo câu lệnh SQL sử dụng Prepared Statements
$sql = "INSERT INTO KhuVuc (KhuVucID, TenKhuVuc) VALUES (:id, :tkv)";

// Chuẩn bị câu lệnh
$stmt = $conn->prepare($sql);

// Gán giá trị cho các tham số và thực thi câu lệnh
$stmt->execute(['id' => $id, 'tkv' => $tkv]);

// Chuyển hướng người dùng về trang thêm sinh viên
header('Location: trangQLKhuVuc.php');
?>