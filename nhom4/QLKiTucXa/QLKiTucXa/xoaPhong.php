<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $phongID = $_GET['id'];

    $sql = "DELETE FROM Phong WHERE PhongID = :phongID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':phongID', $phongID);

    if ($stmt->execute()) {
        header("Location: trangQLPhong.php?message=Xóa phòng thành công");
    } else {
        echo "Lỗi khi xóa phòng.";
    }
} else {
    echo "Không có ID phòng để xóa.";
}
?>
