<?php
// Kết nối đến cơ sở dữ liệu
include 'conn.php'; // Đảm bảo bạn đã tạo tệp conn.php để kết nối cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin đăng nhập từ biểu mẫu
    $username = $_POST['username'];
    $password = $_POST['user_password'];

    // Kiểm tra thông tin đăng nhập
    $sql = "SELECT * FROM quanly WHERE QuanLyID = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Kiểm tra kết quả truy vấn
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // Lấy năm sinh từ NgaySinh
        $yearOfBirth = date('Y', strtotime($user['NgaySinh']));

        // So sánh mật khẩu
        if ($password == $yearOfBirth) {
            // Đăng nhập thành công
           
            // Chuyển hướng đến trang khác hoặc thiết lập session
            session_start();
            $_SESSION['QuanLyID'] = $user['QuanLyID'];
            $_SESSION['HoTen'] = $user['HoTen'];
            header("Location: trangQLKiTucXa.php");
            echo "<script>alert('Đăng nhập thành công.');</script>";
            exit();
        } else {
            // Mật khẩu không đúng
            echo "<script>alert('Sai mật khẩu.'); window.location.href='index.php';</script>";
        }
    } else {
        // QuanLyID không đúng
        echo "<script>alert('Tài khoản không tồn tại.'); window.location.href='index.php';</script>";
    }
}
?>
