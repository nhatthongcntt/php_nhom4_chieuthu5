<?php
include 'conn.php';

// Kiểm tra xem có phải là yêu cầu GET hợp lệ không
if (isset($_GET['id'])) {
    $phongID = $_GET['id'];

    // Truy vấn để lấy thông tin thanh toán của phòng với phongID tương ứng
    $sql = "SELECT * FROM HoaDon WHERE HopDongID IN (SELECT HopDongID FROM HopDong WHERE PhongID = :phongID)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':phongID', $phongID);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Chuyển đổi kết quả thành định dạng JSON và trả về
    echo json_encode($result);
} else {
    // Nếu không có phòngID được cung cấp, trả về mảng JSON rỗng
    echo json_encode([]);
}
?>
