<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $maHoaDon = $_POST['maHoaDon'];
    $hopDongID = $_POST['hopDongID'];
    $soDien = $_POST['soDien'];
    $soNuoc = $_POST['soNuoc'];
    $ngayLap = date('Y-m-d'); // Lấy ngày hiện tại
    $tongTien = str_replace(['.', ' VND'], '', $_POST['tongTien']); // Loại bỏ định dạng tiền tệ

    $sql = "INSERT INTO HoaDon (HopDongID, SoDien, SoNuoc, NgayLap, TongTien) 
            VALUES (:hopDongID, :soDien, :soNuoc, :ngayLap, :tongTien)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':hopDongID', $hopDongID);
    $stmt->bindParam(':soDien', $soDien);
    $stmt->bindParam(':soNuoc', $soNuoc);
    $stmt->bindParam(':ngayLap', $ngayLap);
    $stmt->bindParam(':tongTien', $tongTien);

    try {
        if ($stmt->execute()) {
            echo "Thanh toán thành công!";
        } else {
            echo "Lỗi trong quá trình thanh toán!";
            print_r($stmt->errorInfo()); // In ra lỗi SQL nếu có
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>